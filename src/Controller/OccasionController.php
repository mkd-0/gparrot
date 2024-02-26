<?php

namespace App\Controller;

use App\Entity\Hour;
use App\Entity\Car;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class OccasionController extends AbstractController
{
    #[Route('/occasion', name: 'app_occasion')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $hours = $entityManager->getRepository(Hour::class)->findAll();

        $cars = $entityManager->getRepository(Car::class)->findAll();

        return $this->render('occasions/occasion.html.twig', [
            'cars' => $cars,
            'hours' => $hours
        ]);
    }

    #[Route('/occasion/car/{id}', name: 'app_car_show', methods: ['GET'])]
    public function show(Car $car, EntityManagerInterface $entityManager): Response
    {
        $hours = $entityManager->getRepository(Hour::class)->findAll();


        return $this->render('occasions/show.html.twig', [
            'car' => $car,
            'hours' => $hours,
        ]);
    }





    #[Route('/loadcar', name: 'loadcar', methods: ['GET'])]
    public function loadcar(Request $request, EntityManagerInterface $entityManager, CarRepository $carRepository): Response
    {
        $minPrice = $request->query->get('minPrice');
        $maxPrice = $request->query->get('maxPrice');
        $minMileage = $request->query->get('minMileage');
        $maxMileage = $request->query->get('maxMileage');
        $minYear = $request->query->get('minYear');
        $maxYear = $request->query->get('maxYear');

        $query = $entityManager->getRepository(Car::class);
        $cars = $query->findByPriceRange($minPrice, $maxPrice, $minMileage, $maxMileage, $minYear, $maxYear);

        return $this->render('/filterajax.html.twig', [
            'cars' => $cars
        ]);
    }
}
