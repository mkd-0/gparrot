<?php

namespace App\Controller;

use App\Entity\Service;
use App\Entity\Hour;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/admin/service')]
class ServiceController extends AbstractController
{
    #[Route('/', name: 'app_service_list', methods: ['GET'])]
    public function index(ServiceRepository $serviceRepository, EntityManagerInterface $entityManager): Response
    {
        $hours = $entityManager->getRepository(Hour::class)->findAll();
        return $this->render('admin/service/list.html.twig', [
            'services' => $serviceRepository->findAll(),
            'hours' => $hours,
        ]);
    }


    #[Route('/new', name: 'app_service_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $hours = $entityManager->getRepository(Hour::class)->findAll();
        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($service);
            $entityManager->flush();

            return $this->redirectToRoute('app_service_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/service/new.html.twig', [
            'service' => $service,
            'form' => $form,
            'hours' => $hours,
        ]);
    }

    #[Route('/{id}', name: 'app_service_show', methods: ['GET'])]
    public function show(Service $service, EntityManagerInterface $entityManager): Response
    {
        $hours = $entityManager->getRepository(Hour::class)->findAll();
        return $this->render('admin/service/show.html.twig', [
            'service' => $service,
            'hours' => $hours,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_service_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Service $service, EntityManagerInterface $entityManager): Response
    {
        $hours = $entityManager->getRepository(Hour::class)->findAll();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_service_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/service/edit.html.twig', [
            'service' => $service,
            'form' => $form,
            'hours' => $hours,
        ]);
    }

    #[Route('/{id}', name: 'app_service_delete', methods: ['POST'])]
    public function delete(Request $request, Service $service, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $service->getId(), $request->request->get('_token'))) {
            $entityManager->remove($service);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_service_list', [], Response::HTTP_SEE_OTHER);
    }
}
