<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
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
            // email de confirmation
            $email = (new TemplatedEmail())
                ->from($user->getEmail())
                ->to('admin@infor.be')
                ->subject('Inscription')
                ->htmlTemplate('contact/email-basic.html.twig')
                ->context([
                    'firstName' => $user->getFirstName(),
                    'lastName'  => $user->getLastName(),
                    'title' => 'Inscription réussie',
                    'message' => 'Vous vous êtes bien inscrit sur notre compte avec le nom '. $user->getFirstName(),
                ]);
            $mailer->send($email);
            return $this->redirectToRoute('home'); // redirection
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(), // passage du form vers la vue
        ]);
    }
}
