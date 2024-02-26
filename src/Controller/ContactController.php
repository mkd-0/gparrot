<?php

namespace App\Controller;

use App\Entity\Hour;
use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;


class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, EntityManagerInterface $manager, MailerInterface $mailer): Response
    {
        $hours = $manager->getRepository(Hour::class)->findAll();



        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();

            $manager->persist($contact);
            $manager->flush($contact);


            $email = (new Email())
                ->from('soula216@gmail.com')
                ->to('admin@parrot.fr')
                ->subject('Time for Symfony Mailer!')
                ->text('Sending emails is fun again!');

            $mailer->send($email);


            $this->addFlash(
                'success',
                'Votre message a bien été envoyé !'
            );

            return $this->redirectToRoute('app_contact');
        }


        return $this->render('home/contact.html.twig', [
            'form' => $form->createView(),
            'hours' => $hours
        ]);
    }
}
