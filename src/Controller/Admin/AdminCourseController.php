<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCourseController extends AbstractController
{
    #[Route('/admin/courses', name: 'app_admin_course')]
    public function adminCourses(): Response
    {
        return $this->render('admin/courses/courses.html.twig', [

        ]);
    }
}
