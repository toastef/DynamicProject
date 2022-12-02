<?php

namespace App\Controller\Admin;

use App\Entity\Course;
use App\Form\NewCourseType;
use App\Repository\CourseRepository;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCourseController extends AbstractController
{
    #[Route('/admin/courses', name: 'app_admin_course')]
    public function adminCourses(CourseRepository $repository): Response
    {
        $cousres = $repository->findBy(
            [], // where
            ['createdAt' => 'DESC'],
        );

        return $this->render('admin/courses/courses.html.twig', [
            'courses' => $cousres,
        ]);
    }

    #[Route('/admin/delete/{id}', name: 'app_admin_delete')]
    public function delete(Course $course, EntityManagerInterface $manager): Response
    {
        $manager->remove($course);
        $manager->flush(); // script pour le delete pris en compte par $manager
        $this->addFlash('success', 'Le cours' . $course->getName() . ' a été supprimé avec succes');
        return $this->redirectToRoute('app_admin_course');
    }

    /**
     * @param Course $course
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('admin/publish/{id}', name: 'app_admin_publish')]
    public function published(Course $course, EntityManagerInterface $manager): Response
    {
        $course->setIsPublished(!$course->isIsPublished());// set le contraire de ce qu'il récupère
        $manager->flush();
        $this->addFlash('success', 'modification enregistrée avec succes pour le cours!');
        return $this->redirectToRoute('app_admin_course');
    }

    #[Route('/admin/new', name: 'app_admin_new')]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $slugify = new Slugify();
        $course = new Course();
        $form = $this->createForm(NewCourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
             $course->setCreatedAt(new \DateTimeImmutable())
                    ->setIsPublished(False)
                    ->setSlug($slugify->slugify($course->getName()));
            $manager->persist($course);
            $manager->flush();
            $this->addFlash(
                'success',
                'La formation '.$course->getName().' a bien été ajoutée.'
            );

            return $this->redirectToRoute('app_admin_course');
        }
        return $this->renderForm('admin/courses/newCourse.html.twig', [
            'form' => $form
        ]);
    }
}
