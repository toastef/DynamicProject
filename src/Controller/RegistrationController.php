<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request); // récup des données du formulaire

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
              $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
                if(empty($user->getImageFile())) $user->setImageName('default.jpg');
                $user->setCreatedAt(new \DateTimeImmutable())
                ->setUpdatedAt(new \DateTimeImmutable())
                ->setRoles(['ROLE_USER'])
                ->setIsDisabled(false);

            $entityManager->persist($user); // persist un nouvel utilisateur
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('home'); // redirection
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(), // passage du form vers la vue
        ]);
    }
}
