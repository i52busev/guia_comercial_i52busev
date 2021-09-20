<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsuarioController extends AbstractController
{
    #[Route('/usuario', name: 'usuario')]
    public function index(): Response
    {
        return $this->render('usuario/index.html.twig', [
            'controller_name' => 'Esta es la página principal de un usuario',
        ]);
    }
}
