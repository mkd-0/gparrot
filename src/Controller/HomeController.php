<?php

namespace App\Controller;

use App\Entity\Hour;
use App\Entity\Service;
use App\Entity\Testimony;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\TestimonyType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    // public function index(EntityManagerInterface $entityManager): Response
    // {
    //     $services = $entityManager->getRepository(Service::class)->findAll();
    //     $testimonies = $entityManager->getRepository(Testimony::class)->findAll();

    //     return $this->render('home/index.html.twig', [

    //         'services' => $services,
    //         'testimonies' => $testimonies
    //     ]);
    // }


    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {

        $hours = $entityManager->getRepository(Hour::class)->findAll();


        // Injection des données de l'entité Service & Testimony
        $services = $entityManager->getRepository(Service::class)->findAll();
        $testimonies = $entityManager->getRepository(Testimony::class)->findAll();


        // Injection du formulaire de création de Testimony

        // Etape 1 : Création d'une nouvelle instance de l'entité Testimony
        $testimony = new Testimony();

        // Etape 2 :  Création du formulaire en utilisant TestimonyType et l'entité Testimony
        $form = $this->createForm(TestimonyType::class, $testimony);


        // Etape 3 :  Traitement du formulaire lorsqu'une requête POST est soumise
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Si le formulaire est soumis et valide, enregistrer les données
            $entityManager->persist($testimony);
            $entityManager->flush();
            // Rediriger vers une autre page après l'enregistrement réussi
            return $this->redirectToRoute('app_testimony_list', [], Response::HTTP_SEE_OTHER);
        }


        // Si la requête n'est pas une soumission POST ou si le formulaire n'est pas valide,
        // afficher la vue avec le formulaire
        return $this->render('home/index.html.twig', [
            'testimony' => $testimony,
            //'form' => $form,
            'form' => $form->createView(), // Passer le formulaire à la vue

            //'injection des datas de Service & Testimony
            'services' => $services,
            'testimonies' => $testimonies,
            'hours' => $hours

        ]);
    }
}
