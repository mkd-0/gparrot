<?php

namespace App\Controller;

use App\Entity\Service;
use App\Entity\Testimony;
// use App\Controller\TestimonyType;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\TestimonyType;
//use App\Controller\Request;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $services = $entityManager->getRepository(Service::class)->findAll();
        $testimonies = $entityManager->getRepository(Testimony::class)->findAll();

        return $this->render('home/index.html.twig', [

            'services' => $services,
            'testimonies' => $testimonies
        ]);
    }
}
