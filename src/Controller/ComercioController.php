<?php

namespace App\Controller;

use App\Entity\Comercio;
use App\Form\ComercioType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ComercioController extends AbstractController
{
    #[Route('/comercio', name: 'comercio')]
    public function index(Request $request)
    {
        $comercio = new Comercio();
        $form = $this->createForm(ComercioType::class, $comercio);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $comercio->setValidez(validez: 'pendiente');
            //$comercio->setIdComercio();
            //$comercio->setIdEmpresa();
            $em->persist($comercio);
            $em->flush();
            $this->addFlash(type: 'exito', message: 'El comercio se ha registrado correctamente');
            return $this->redirectToRoute(route: 'registro');
        }

        return $this->render('registro/index.html.twig', [
            'controller_name' => 'ComercioController',
            'formulario' => $form->createView()
        ]);
    }
}
