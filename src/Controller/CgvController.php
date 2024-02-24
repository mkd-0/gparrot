<?php

namespace App\Controller;


use App\Entity\Hour;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;



class CgvController extends AbstractController
{
    #[Route('/cgv', name: 'app_cgv')]
    public function index(EntityManagerInterface $entityManager): Response
    {

        $hours = $entityManager->getRepository(Hour::class)->findAll();

        return $this->render('/cgv.html.twig', [
            'hours' => $hours,
        ]);
    }
}
