<?php

namespace App\Controller;

use App\Entity\Hour;
use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, EntityManagerInterface $manager): Response
    {
        $hours = $manager->getRepository(Hour::class)->findAll();



        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();

            $manager->persist($contact);
            $manager->flush($contact);


            $this->addFlash(
                'success',
                'Votre message a bien été envoyé !'
            );



            return $this->redirectToRoute('app_home');
        }


        return $this->render('home/contact.html.twig', [
            'form' => $form->createView(),
            'hours' => $hours
        ]);
    }
}
