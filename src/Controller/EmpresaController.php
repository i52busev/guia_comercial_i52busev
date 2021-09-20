<?php

namespace App\Controller;

use App\Entity\Empresa;
use App\Form\EmpresaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmpresaController extends AbstractController
{
    #[Route('/empresa_registro', name: 'registroEmpresa')]
    public function index(Request $request)
    {
        $empresa = new Empresa();
        $form = $this->createForm(EmpresaType::class, $empresa);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $empresa->setValidez(validez: 'pendiente');
            //$empresa->setIdEmpresa();
            //$empresa->setIdUsuario();
            $em->persist($empresa);
            $em->flush();
            $this->addFlash(type: 'exito', message: 'La empresa se ha registrado correctamente');
            return $this->redirectToRoute(route: 'empresa');
        }

        return $this->render('empresa/index.html.twig', [
            'controller_name' => 'EmpresaController',
            'formulario' => $form->createView()
        ]);
    }
}
