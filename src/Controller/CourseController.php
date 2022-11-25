<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Course;
use App\Entity\User;
use App\Form\CommentType;
use App\Repository\CourseCategoryRepository;
use App\Repository\CourseRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CourseController extends AbstractController
{
  #[Route('/courses', name: 'courses')]
  public function courses(CourseCategoryRepository $categoryRepository, CourseRepository $courseRepository): Response
  {
      $categories = $categoryRepository->findBy(
          [],
          ['name' => 'ASC']
      );
      $courses = $courseRepository->findBy(
          ['isPublished' => true],
          ['name' => 'ASC']
      );
      return $this->render('course/courses.html.twig', [
            'categories'    => $categories,
            'courses'       => $courses
    ]);
  }

  /**
   * @return Response
   */
  #[Route('/course/{slug}', name: 'course')]
  public function course(Course $course, Request $request, EntityManagerInterface $manager): Response
  {


      $comment = new Comment();
      $form = $this->createForm(CommentType::class, $comment);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
          $comment->setCreatedAt(new \DateTimeImmutable())
                  ->setUser($this->getUser())
                  ->setCourse($comment->getCourse());
          $manager->persist($comment);
          $course->addComment($comment);
          $this->getUser()->addComment($comment);
          $manager->flush();
          $this->redirectToRoute('course',['slug' => $course->getSlug()]);
      }

    return $this->render('course/course.html.twig', [
        'course' =>$course,
        'form' => $form->createView(),

    ]);
      }

}
