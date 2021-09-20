<?php

namespace App\Controller;

use App\Entity\Oferta;
use App\Form\OfertaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OfertaController extends AbstractController
{
    #[Route('/oferta', name: 'oferta')]
    public function index(Request $request)
    {
        $oferta = new Oferta();
        $form = $this->createForm(OfertaType::class, $oferta);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $oferta->setValidez(validez: 'pendiente');
            //$oferta->setIdOferta();
            //$oferta->setCif();
            //$oferta->setIdComercio();
            $em->persist($oferta);
            $em->flush();
            $this->addFlash(type: 'exito', message: 'El oferta se ha registrado correctamente');
            return $this->redirectToRoute(route: 'registro');
        }

        return $this->render('registro/index.html.twig', [
            'controller_name' => 'RegistroController',
            'formulario' => $form->createView()
        ]);
    }
}
