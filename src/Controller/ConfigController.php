<?php

namespace App\Controller;

use App\Repository\HourRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConfigController extends AbstractController
{
    #[Route('/admin', name: 'app_config')]
    public function index(HourRepository $hourRepository): Response
    {

        $hours = $hourRepository->findAll();

        return $this->render('admin/config.html.twig', [
            'controller_name' => 'ConfigController',
            'hours' => $hours,
        ]);
    }
}
