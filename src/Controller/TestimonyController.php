<?php

namespace App\Controller;

use App\Entity\Testimony;
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
    public function index(TestimonyRepository $testimonyRepository): Response
    {
        return $this->render('admin/testimony/list.html.twig', [
            'testimonies' => $testimonyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_testimony_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Création d'une nouvelle instance de l'entité Testimony
        $testimony = new Testimony();

        // Création du formulaire en utilisant TestimonyType et l'entité Testimony
        $form = $this->createForm(TestimonyType::class, $testimony);

        // Traitement du formulaire lorsqu'une requête POST est soumise
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Si le formulaire est soumis et valide, enregistrer les données
            $entityManager->persist($testimony);
            $entityManager->flush();
            // Rediriger vers une autre page après l'enregistrement réussi
            return $this->redirectToRoute('app_testimony_list', [], Response::HTTP_SEE_OTHER);
        }

        // Si la requête n'est pas une soumission POST ou si le formulaire n'est pas valide,
        // afficher la vue avec le formulaire
        // return $this->render('admin/testimony/new.html.twig',
        return $this->render('new.html.twig', [
            'testimony' => $testimony,
            //'form' => $form,
            'form' => $form->createView(), // Passer le formulaire à la vue
        ]);
    }

    #[Route('/{id}', name: 'app_testimony_show', methods: ['GET'])]
    public function show(Testimony $testimony): Response
    {
        return $this->render('admin/testimony/show.html.twig', [
            'testimony' => $testimony,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_testimony_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Testimony $testimony, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TestimonyType::class, $testimony);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_testimony_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/testimony/edit.html.twig', [
            'testimony' => $testimony,
            'form' => $form,
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
