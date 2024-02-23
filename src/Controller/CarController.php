<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarType;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/admin/car')]
class CarController extends AbstractController
{
    #[Route('/new', name: 'app_car_new', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $car = new Car();
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($car);
            $entityManager->flush();

            return $this->redirectToRoute('app_car_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/car/new.html.twig', [
            'car' => $car,
            'form' => $form,
        ]);
    }




    // #[Route('/getFilteredCars', name: 'app_getFilteredCars', methods: ['GET'])]
    // public function getFilteredCars(Request $request, CarRepository $carRepository): JsonResponse
    // {

    //     $minPrice = $request->query->get('minPrice');
    //     $maxPrice = $request->query->get('maxPrice');
    //     $minMileage = $request->query->get('minMileage');
    //     $maxMileage = $request->query->get('maxMileage');
    //     $minYear = $request->query->get('minYear');
    //     $maxYear = $request->query->get('maxYear');

    //     //     // Récupérer les données filtrées depuis la requête
    //     //$repoFielteredCarIds = $carRepository->findFilteredCarsIds($minPrice, $maxPrice, $minMileage, $maxMileage, $minYear, $maxYear,);
    //     $repoFielteredCarIds = $carRepository->findFilteredCarsIds($minPrice, $maxPrice);
    //     //     // Effectuez vos opérations de filtrage ici
    //     //     // Supposons que $filteredData contient les données filtrées
    //     //     // Par exemple, vous pouvez utiliser Doctrine pour récupérer les données filtrées depuis la base de données
    //     $filteredCarIds  = [];
    //     foreach ($repoFielteredCarIds as $filteredCarId) {
    //         array_push($filteredCarIds, $filteredCarId);
    //     }

    //     $allCardIds = [];
    //     foreach ($carRepository->findAll() as $car) {
    //         array_push($allCardIds, $car->getId());
    //     }
    //     // Renvoyer les données filtrées sous forme de réponse JSON
    //     return $this->json([
    //         'allCarIds' => $allCardIds,
    //         'filteredCarsIds' => $filteredCarIds,
    //     ]);
    // }


    #[Route('/', name: 'app_car_list', methods: ['GET'])]
    public function index(CarRepository $carRepository): Response
    {
        return $this->render('admin/car/list.html.twig', [
            'cars' => $carRepository->findAll(),
        ]);
    }


    #[Route('/{id}', name: 'app_car_show', methods: ['GET'])]
    public function show(Car $car): Response
    {
        return $this->render('admin/car/show.html.twig', [
            'car' => $car,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_car_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Car $car, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_car_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/car/edit.html.twig', [
            'car' => $car,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_car_delete', methods: ['POST'])]
    public function delete(Request $request, Car $car, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $car->getId(), $request->request->get('_token'))) {
            $entityManager->remove($car);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_car_list', [], Response::HTTP_SEE_OTHER);
    }
}
