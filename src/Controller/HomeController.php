<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home.index')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/home', name: 'home.home', methods:['GET'])]
    public function home(): Response
    {
        return new Response ('<h1>Bonjour</h1>');
    }

    #[Route('/AfficherInfo', name: 'home.afficherInfo', methods:['GET'])]
    public function afficherInfo(): Response
    {
        $name = "thierry";
        return $this->render('home/afficher.html.twig', [
            'name' => $name
        ]);
    }
}
