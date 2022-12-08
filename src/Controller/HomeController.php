<?php

namespace App\Controller;

use App\Repository\CourseCategoryRepository;
use App\Repository\CourseRepository;
use App\Repository\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
  /**
   * @return Response
   */
  #[Route('/', name: 'home')]
    public function home(CourseRepository $courseRepository, NewsRepository $newsRepository, CourseCategoryRepository $categoryRepository): Response
    {
        $courses = $courseRepository->findBy(
            ['isPublished' => true],
            ['createdAt' => 'DESC'],
            3
        );
        $news = $newsRepository->findBy(
            ['isPublished' => true],
            ['createdAt' => 'DESC'],
            4
        );
        $category =  $categoryRepository->findAll();

        return $this->render('home/index.html.twig',
        [
            'courses'   => $courses,
            'news'      => $news,
            'category' => $category,
        ]);
    }
}
