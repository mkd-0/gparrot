<?php

namespace App\Controller;

use App\Entity\Energy;
use App\Form\EnergyType;
use App\Repository\EnergyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/energy')]
class EnergyController extends AbstractController
{
    #[Route('/', name: 'app_energy_list', methods: ['GET'])]
    public function index(EnergyRepository $energyRepository): Response
    {
        return $this->render('admin/energy/list.html.twig', [
            'energies' => $energyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_energy_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $energy = new Energy();
        $form = $this->createForm(EnergyType::class, $energy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($energy);
            $entityManager->flush();

            return $this->redirectToRoute('app_energy_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/energy/new.html.twig', [
            'energy' => $energy,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_energy_show', methods: ['GET'])]
    public function show(Energy $energy): Response
    {
        return $this->render('admin/energy/show.html.twig', [
            'energy' => $energy,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_energy_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Energy $energy, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EnergyType::class, $energy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_energy_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/energy/edit.html.twig', [
            'energy' => $energy,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_energy_delete', methods: ['POST'])]
    public function delete(Request $request, Energy $energy, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $energy->getId(), $request->request->get('_token'))) {
            $entityManager->remove($energy);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin/app_energy_list', [], Response::HTTP_SEE_OTHER);
    }
}
