<?php

namespace App\Controller;

use App\Entity\Cliente;
use App\Entity\Usuario;
use App\Form\ClienteType;
use App\Form\UsuarioType;
//use Symfony\Component\HttpFoundation\Response;
use App\Entity\Empresario;
use App\Form\EmpresarioType;
use App\Entity\Administrador;
use App\Form\AdministradorType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistroController extends AbstractController
{
    #[Route('/registro', name: 'registro')]
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $usuario = new Usuario();
        $cliente = new Cliente();
        $empresario = new Empresario();
        $administrador = new Administrador();
        $form = $this->createForm(UsuarioType::class, $usuario);
        $formC = $this->createForm(ClienteType::class, $cliente);
        $formE = $this->createForm(EmpresarioType::class, $empresario);
        $formA = $this->createForm(AdministradorType::class, $administrador);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();

            //Se añade la información que el usuario no puede modificar
            $usuario->setValidez(validez: 'pendiente');
            $usuario->setFechaAlta(\DateTime::createFromFormat('Y-m-d h:i:s',date('Y-m-d h:i:s')));

            //Se codifica la contraseña
            $usuario->setPassword($passwordEncoder->encodePassword($usuario,$form['password']->getData()));

            //Se guarda el usuario en la base de datos
            $em->persist($usuario);
            $em->flush();

            //Se crea la tupla del tipo de usuario según el tipo elegido en el formulario
            if ($usuario->esCliente()) {
                $formC->handleRequest($request);
                $em = $this->getDoctrine()->getManager();
                $cliente->setIdUsuario($usuario);
                $em->persist($cliente);
                $em->flush();
            }

            if ($usuario->esEmpresario()) {
                $formE->handleRequest($request);
                $em = $this->getDoctrine()->getManager();
                $empresario->setIdUsuario($usuario);
                $em->persist($empresario);
                $em->flush();
            }

            if ($usuario->esAdministrador()) {
                $formA->handleRequest($request);
                $em = $this->getDoctrine()->getManager();
                $administrador->setIdUsuario($usuario);
                $em->persist($administrador);
                $em->flush();
            }

            $this->addFlash(type: 'exito', message: 'El usuario se ha registrado correctamente');
            return $this->redirectToRoute(route: 'principal');
        }

        return $this->render('registro/index.html.twig', [
            'controller_name' => 'RegistroController',
            'formulario' => $form->createView(),
            'formC' => $formC->createView(),
            'formE' => $formE->createView()
        ]);
    }
}
