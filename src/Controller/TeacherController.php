<?php

namespace App\Controller;

use App\Repository\CourseCategoryRepository;
use App\Repository\CourseRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeacherController extends AbstractController
{
    #[Route('/teacher', name: 'app_teacher')]
    public function teachers(UserRepository $user, CourseRepository $course, CourseCategoryRepository $category): Response
    {
        $prof = $user->findByRole('ROLE_PROF');
        $cour = $course->findAll();
        $categorys = $category->findAll();

        return $this->render('teacher/teacher.html.twig', [
            'profs' => $prof,
            'courses' => $cour,
            'categories' =>$categorys,
        ]);
    }

    // créer une fonction pour renvoi dans le header des category

}
