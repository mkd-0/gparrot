<?php

namespace App\Controller;

use App\Entity\Car;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test', methods: ['GET'])]
    public function findCarByPrice(Request $request, EntityManagerInterface $entityManager, CarRepository $carRepository): Response
    {

        $carRepository = $entityManager->getRepository(Car::class)->findAll();

        return $this->render('/test.html.twig', [
            'cars' => $carRepository
        ]);
    }

    // #[Route('/loadcar', name: 'loadcar', methods: ['GET'])]
    // public function index(Request $request, EntityManagerInterface $entityManager, CarRepository $carRepository): Response
    // {
    //     $minPrice = $request->query->get('minPrice');
    //     $maxPrice = $request->query->get('maxPrice');
    //     $minMileage = $request->query->get('minMileage');
    //     $maxMileage = $request->query->get('maxMileage');

    //     // Utiliser un repository pour récupérer les annonces de voitures filtrées
    //     // $carRepository = $entityManager->getRepository(Car::class)->findAll();
    //     //$findByPriceRange = $carRepository->findByPriceRange($minPrice, $maxPrice);
    //     $query = $entityManager->getRepository(Car::class);
    //     $cars = $query->findByPriceRange($minPrice, $maxPrice, $minMileage, $maxMileage);

    //     return $this->render('/filterajax.html.twig', [
    //         'cars' => $cars
    //     ]);
    //}
}
