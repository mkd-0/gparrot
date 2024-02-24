<?php

namespace App\Controller;

use App\Entity\Hour;
use App\Entity\Model;
use App\Form\ModelType;
use App\Repository\ModelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/model')]
class ModelController extends AbstractController
{
    #[Route('/', name: 'app_model_list', methods: ['GET'])]
    public function index(ModelRepository $modelRepository, EntityManagerInterface $entityManager): Response
    {
        $hours = $entityManager->getRepository(Hour::class)->findAll();
        return $this->render('admin/model/list.html.twig', [
            'models' => $modelRepository->findAll(),
            'hours' => $hours,

        ]);
    }

    #[Route('/new', name: 'app_model_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $hours = $entityManager->getRepository(Hour::class)->findAll();
        $model = new Model();
        $form = $this->createForm(ModelType::class, $model);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($model);
            $entityManager->flush();

            return $this->redirectToRoute('app_model_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/model/new.html.twig', [
            'model' => $model,
            'form' => $form,
            'hours' => $hours,

        ]);
    }

    #[Route('/{id}', name: 'app_model_show', methods: ['GET'])]
    public function show(Model $model, EntityManagerInterface $entityManager): Response
    {
        $hours = $entityManager->getRepository(Hour::class)->findAll();
        return $this->render('admin/model/show.html.twig', [
            'model' => $model,
            'hours' => $hours,

        ]);
    }

    #[Route('/{id}/edit', name: 'app_model_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Model $model, EntityManagerInterface $entityManager): Response
    {
        $hours = $entityManager->getRepository(Hour::class)->findAll();
        $form = $this->createForm(ModelType::class, $model);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_model_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/model/edit.html.twig', [
            'model' => $model,
            'form' => $form,
            'hours' => $hours,

        ]);
    }

    #[Route('/{id}', name: 'app_model_delete', methods: ['POST'])]
    public function delete(Request $request, Model $model, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $model->getId(), $request->request->get('_token'))) {
            $entityManager->remove($model);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_model_list', [], Response::HTTP_SEE_OTHER);
    }
}
