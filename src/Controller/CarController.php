<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarType;
use App\Entity\Hour;
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
        $hours = $entityManager->getRepository(Hour::class)->findAll();
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
            'hours' => $hours,
        ]);
    }


    #[Route('/', name: 'app_car_list', methods: ['GET'])]
    public function index(CarRepository $carRepository, EntityManagerInterface $entityManager): Response
    {
        $hours = $entityManager->getRepository(Hour::class)->findAll();
        return $this->render('admin/car/list.html.twig', [
            'cars' => $carRepository->findAll(),
            'hours' => $hours,
        ]);
    }


    #[Route('/{id}', name: 'app_car_show', methods: ['GET'])]
    public function show(Car $car, EntityManagerInterface $entityManager): Response
    {
        $hours = $entityManager->getRepository(Hour::class)->findAll();
        return $this->render('admin/car/show.html.twig', [
            'car' => $car,
            'hours' => $hours,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_car_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Car $car, EntityManagerInterface $entityManager): Response
    {
        $hours = $entityManager->getRepository(Hour::class)->findAll();
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_car_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/car/edit.html.twig', [
            'car' => $car,
            'form' => $form,
            'hours' => $hours,
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
