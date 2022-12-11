<?php

namespace App\Controller;

use App\Repository\CourseCategoryRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NavController extends AbstractController
{

    #[Route('/', name: 'app_nav')]
    public function NavBarCat(UserRepository $user ,CourseCategoryRepository $categoryRepository): Response
    {
        $prof = $user->findByRole('ROLE_PROF');
        $categorys = $categoryRepository->findAll();

        return $this->render('nav/index.html.twig', [
            'profs' => $prof,
            'categories' => $categorys,

        ]);
    }
}
