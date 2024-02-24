<?php

namespace App\Controller;

use App\Entity\Hour;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;



class FooterController extends AbstractController
{
    #[Route('/footer', name: 'footer_content')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $hours = $entityManager->getRepository(Hour::class)->findAll();

        return $this->render('_partials/_footer.html.twig', [
            'hours' => $hours,
        ]);
    }
}
