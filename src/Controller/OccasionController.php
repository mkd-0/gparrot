<?php

namespace App\Controller;

use App\Entity\Car;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OccasionController extends AbstractController
{
    #[Route('/occasion', name: 'app_occasion')]
    public function index(EntityManagerInterface $entityManager): Response
    {

        $cars = $entityManager->getRepository(Car::class)->findAll();


        return $this->render('occasions/occasion.html.twig', [
            'cars' => $cars

        ]);
    }
}
