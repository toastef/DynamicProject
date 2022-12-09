<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * Méthode pour envoi de mail donnée hardcodée
     * @param MailerInterface $mailer
     * @return Response
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    #[Route('/contact', name: 'app_contact')]
    public function contact(MailerInterface $mailer): Response
    {
        $email = new Email();
        $email  ->from('stef@gmail.com')
                ->to('admin@iepscf.be')
                ->cc('john@gmail.com')
                ->subject('Demande de distanciel')
                ->text('Je vous accorde le distanciel avec plaisir')
                ->html('<h2>Suite a votre demande <h2>
                            <h3>Merci</h3>' );
        $mailer->send($email);
        return $this->redirectToRoute('home');
    }

    #[Route('/email', name:'app_email')]
    public function email(MailerInterface $mailer , Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $email = new Email();
            $email  ->from($contact->getEmail())
                    ->to('info@iepscf.be')
                    ->subject($contact->getSubject())
                    //->text($contact->getMessage())
                    ->html(
                        '
                        <p>'.$contact->getMessage().'</p>
                        <p><small>'. $contact->getFirstName().'</small></p>'
                    );
            $mailer->send($email);
            $this->addFlash('success', 'Votre mail a bien été envoyé');
            return $this->redirectToRoute('home');
        }
        return $this->renderForm('contact/contact.html.twig', [
            'form' => $form,
        ]);
    }


    #[Route('/template', name:'app_template')]
    public function template(MailerInterface $mailer , Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $email = (new TemplatedEmail())
                ->from($contact->getEmail())
                ->to('admin@infor.be')
                ->subject($contact->getSubject())
                ->htmlTemplate('contact/email-css-external.html.twig')
                ->context([
                    'firstName' => $contact->getFirstName(),
                    'lastName'  => $contact->getLastName(),
                    'message'   =>$contact->getMessage(),
                    'title'     =>$contact->getSubject(),
                ]);
            $mailer->send($email);
            $this->addFlash('success', 'Votre mail a bien été envoyé');
            return $this->redirectToRoute('home');
        }
        return $this->renderForm('contact/contact.html.twig', [
            'form' => $form,
        ]);
    }
}
