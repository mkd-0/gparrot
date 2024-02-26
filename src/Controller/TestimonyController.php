<?php

namespace App\Controller;

use App\Entity\Testimony;
use App\Entity\Hour;
use App\Form\TestimonyType;
use App\Repository\TestimonyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/testimony')]
class TestimonyController extends AbstractController
{
    #[Route('/', name: 'app_testimony_list', methods: ['GET'])]
    public function index(TestimonyRepository $testimonyRepository, EntityManagerInterface $entityManager): Response
    {
        $hours = $entityManager->getRepository(Hour::class)->findAll();
        return $this->render('admin/testimony/list.html.twig', [
            'testimonies' => $testimonyRepository->findAll(),
            'hours' => $hours,
        ]);
    }

    #[Route('/new', name: 'app_testimony_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $hours = $entityManager->getRepository(Hour::class)->findAll();
        // add new instance of entity Testimony
        $testimony = new Testimony();

        // Create formulaire by TestimonyType and Testimony entity
        // Verification il user = admin

        $form = $this->createForm(TestimonyType::class, $testimony, [

            'hours' => $hours,
        ]);

        // Load form when request POST is submit
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // If form is submit and ok, register the data
            $entityManager->persist($testimony);
            $entityManager->flush();
            // Redirect to another route before saved is good
            return $this->redirectToRoute('app_testimony_list', [], Response::HTTP_SEE_OTHER[]);
        }


        // If the form request isnot a submit POST or form isnot good 
        // show form
        return $this->render('admin/testimony/new.html.twig', [
            'testimony' => $testimony,
            'form' => $form->createView(), // give form to vue
        ]);
    }

    #[Route('/{id}', name: 'app_testimony_show', methods: ['GET'])]
    public function show(Testimony $testimony, EntityManagerInterface $entityManager): Response
    {
        $hours = $entityManager->getRepository(Hour::class)->findAll();
        return $this->render('admin/testimony/show.html.twig', [
            'testimony' => $testimony,
            'hours' => $hours,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_testimony_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Testimony $testimony, EntityManagerInterface $entityManager): Response
    {
        $hours = $entityManager->getRepository(Hour::class)->findAll();
        $form = $this->createForm(TestimonyType::class, $testimony);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_testimony_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/testimony/edit.html.twig', [
            'testimony' => $testimony,
            'form' => $form,
            'hours' => $hours,
        ]);
    }

    #[Route('/{id}', name: 'app_testimony_delete', methods: ['POST'])]
    public function delete(Request $request, Testimony $testimony, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $testimony->getId(), $request->request->get('_token'))) {
            $entityManager->remove($testimony);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_testimony_list', [], Response::HTTP_SEE_OTHER);
    }
}
