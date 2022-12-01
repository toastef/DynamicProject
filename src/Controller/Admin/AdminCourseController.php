<?php

namespace App\Controller\Admin;

use App\Entity\Course;
use App\Repository\CourseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

     #[Route('/admin/delete/{id}', name: 'delete')]
    public function delete(Course $course, EntityManagerInterface $manager): Response
    {
        $manager->remove($course);
        $manager->flush(); // script pour le delete pris en compte par $manager
        return $this->redirectToRoute('app_admin_course'); // vient de l'abstractcontroller pour rediriger vers l'admin
    }
}
