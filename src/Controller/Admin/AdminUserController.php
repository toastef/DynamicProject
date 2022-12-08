<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminUserController extends AbstractController
{
    #[Route('/admin/user', name: 'app_admin_user')]
    #[IsGranted('ROLE_SUPER_ADMIN')]
    public function adminUser(UserRepository $repository): Response
    {
        $user = $repository->findBy(
            [], // where
            ['createdAt' => 'DESC'],
        );

        return $this->render('admin/user/users.html.twig', [
            'users' => $user,
        ]);
    }

    #[Route('admin/user/publish/{id}', name: 'app_admin_user_publish')]
    public function published(User $user, EntityManagerInterface $manager): Response
    {
        $user->setIsDisabled(!$user->isIsDisabled());
        $manager->flush();
        $this->addFlash('success', 'modification enregistrée avec succes pour le user!');
        return $this->redirectToRoute('app_admin_user');
    }

    #[Route('/admin/role_user/{id}', name: 'app_admin_role_user_user')]
    public function userToUser(User $user, EntityManagerInterface $manager): Response
    {
        $role[] = 'ROLE_USER';
        $user->setRoles($role);
        $manager->flush();
        return $this->redirectToRoute('app_admin_user');
    }

    #[Route('/admin/role_admin/{id}', name: 'app_admin_role_user_admin')]
    public function userToAdmin(User $user, EntityManagerInterface $manager): Response
    {
        $role[] = 'ROLE_ADMIN';
        $user->setRoles($role);
        $manager->flush();
        return $this->redirectToRoute('app_admin_user');
    }

    #[Route('/admin/role_super_admin/{id}', name: 'app_admin_role_user_super_admin')]
    public function userToSuperAdmin(User $user, EntityManagerInterface $manager): Response
    {
        $role[] = 'ROLE_SUPER_ADMIN';
        $user->setRoles($role);
        $manager->flush();
        return $this->redirectToRoute('app_admin_user');
    }
}
