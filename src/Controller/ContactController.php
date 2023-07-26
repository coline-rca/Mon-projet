<?php

namespace App\Controller;

use DateTimeImmutable;
use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(Request $request, ManagerRegistry $doctrine, MailerInterface $mailer): Response
    {
        $contact = new Contact;

        $contactForm = $this->createForm(ContactType::class, $contact);

        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid()){

            $contact->setCreatedAt(new DateTimeImmutable("now"));

            $entityManager = $doctrine->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();

            #Envoi de l'email
            $email = (new TemplatedEmail())
                ->from($contact->getEmail())
                ->to('contact@monsite.com')
                ->subject($contact->getObject())
                ->htmlTemplate('contact/email.html.twig')
                ->context([
                    "contact" => $contact
                ])
            ;
            
            $mailer->send($email);
            $this->addFlash('contact_success','Votre email a bien été envoyé, votre demande est en cours de traitement.');

            return $this->redirectToRoute('index');
        }
        return $this->render('contact/contact.html.twig', [
            'contactForm' => $contactForm->createView(),
        ]);
    }
}
