<?php

namespace App\Controller;

use App\Entity\Hour;
use App\Form\HourType;
use App\Repository\HourRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/hour')]
class HourController extends AbstractController
{
    #[Route('/', name: 'app_hour_list', methods: ['GET'])]
    public function index(HourRepository $hourRepository, EntityManagerInterface $entityManager): Response
    {

        return $this->render('admin/hour/list.html.twig', [
            'hours' => $hourRepository->findAll(),

        ]);
    }

    #[Route('/new', name: 'app_hour_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $hours = $entityManager->getRepository(Hour::class)->findAll();
        $hour = new Hour();
        $form = $this->createForm(HourType::class, $hour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($hour);
            $entityManager->flush();

            return $this->redirectToRoute('app_hour_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/hour/new.html.twig', [
            'hour' => $hour,
            'form' => $form,
            'hours' => $hours,

        ]);
    }

    #[Route('/{id}', name: 'app_hour_show', methods: ['GET'])]
    public function show(Hour $hour, EntityManagerInterface $entityManager): Response
    {
        $hours = $entityManager->getRepository(Hour::class)->findAll();
        return $this->render('admin/hour/show.html.twig', [
            'hour' => $hour,
            'hours' => $hours,
        ]);
    }



    #[Route('/{id}/edit', name: 'app_hour_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Hour $hour, EntityManagerInterface $entityManager): Response
    {
        $hours = $entityManager->getRepository(Hour::class)->findAll();
        $form = $this->createForm(HourType::class, $hour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_hour_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/hour/edit.html.twig', [
            'hour' => $hour,
            'form' => $form,
            'hours' => $hours,
        ]);
    }

    #[Route('/{id}', name: 'app_hour_delete', methods: ['POST'])]
    public function delete(Request $request, Hour $hour, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $hour->getId(), $request->request->get('_token'))) {
            $entityManager->remove($hour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_hour_list', [], Response::HTTP_SEE_OTHER);
    }
}
