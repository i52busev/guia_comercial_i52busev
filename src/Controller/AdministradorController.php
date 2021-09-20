<?php

namespace App\Controller;

use App\Entity\Oferta;
use App\Entity\Cliente;
use App\Entity\Empresa;
use App\Entity\Usuario;
use App\Entity\Comercio;
use App\Form\PerfilType;
use App\Form\ClienteType;
use App\Entity\Empresario;
use App\Form\EmpresarioType;
use App\Entity\Administrador;
use App\Form\OfertaAdminType;
use App\Form\EmpresaAdminType;
use App\Form\UsuarioAdminType;
use App\Form\AdministradorType;
use App\Form\ComercioAdminType;
use App\Form\ValidarOfertaType;
use App\Form\OfertaConsultaType;
use App\Form\ValidarEmpresaType;
use App\Form\ValidarUsuarioType;
use App\Form\ModificarOfertaType;
use App\Form\ValidarComercioType;
use App\Form\ComercioConsultaType;
use App\Form\ModificarUsuarioType;
use App\Form\ModificarComercioType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdministradorController extends AbstractController
{
    #[Route('/administrador', name: 'administrador')]
    public function index(): Response
    {
        return $this->render('administrador/index.html.twig', [
            'controller_name' => 'Esta es la página principal de un Administrador',
        ]);
    }

    #[Route('/administrador/usuarioBuscar', name: 'usuarioBuscarAdmin')]
    public function usuarioBuscar(Request $request): Response
    {
        $usuarios = "";

        return $this->render('administrador/buscarUsuario.html.twig', [
            'controller_name' => 'Esta es la página para buscar un Usuario',
            'usuarios' => $usuarios
        ]);
    }

    #[Route('/administrador/empresaBuscar', name: 'empresaBuscarAdmin')]
    public function empresaBuscar(Request $request): Response
    {
        $empresas = "";

        return $this->render('administrador/buscarEmpresa.html.twig', [
            'controller_name' => 'Esta es la página para buscar una Empresa',
            'empresas' => $empresas
        ]);
    }

    #[Route('/administrador/comercioBuscar', name: 'comercioBuscarAdmin')]
    public function comercioBuscar(Request $request): Response
    {
        $comercios = "";

        return $this->render('administrador/buscarComercio.html.twig', [
            'controller_name' => 'Esta es la página para buscar un Comercio',
            'comercios' => $comercios
        ]);
    }

    #[Route('/administrador/ofertaBuscar', name: 'ofertaBuscarAdmin')]
    public function ofertaBuscar(Request $request): Response
    {
        $ofertas = "";

        return $this->render('administrador/buscarOferta.html.twig', [
            'controller_name' => 'Esta es la página para buscar una Oferta',
            'ofertas' => $ofertas
        ]);
    }

    #[Route('/administrador/ayuda_administrador', name: 'ayudaAdministrador')]
    public function ayudaAdministrador(): Response
    {
        return $this->render('administrador/ayuda.html.twig', [
            'controller_name' => 'Esta es la página de ayuda para el Administrador',
        ]);
    }
/*
    #[Route('/administrador/cs/crear', name: 'crearCopiaSeguridad')]
    public function crearCopiaSeguridad(): Response
    {
        return $this->render('administrador/crearCS.html.twig', [
            'controller_name' => 'Esta es la página para crear una copia de seguridad',
        ]);
    }

    #[Route('/administrador/cs/restaurar', name: 'restaurarCopiaSeguridad')]
    public function restaurarCopiaSeguridad(): Response
    {
        return $this->render('administrador/restaurarCS.html.twig', [
            'controller_name' => 'Esta es la página para restaurar una copia de seguridad',
        ]);
    }
*/
    #[Route('/administrador/usuario/buscar', name: 'buscarUsuario')]
    public function buscarUsuario(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $usuarios = "";
        $usuariosTemp = "";

        //Parámetros de búsqueda
        $email = $request->request->get('email');
        $nombre = $request->request->get('nombre');
        $apellidos = $request->request->get('apellidos');
        $telefono = $request->request->get('telefono');
        $validez = $request->request->get('validez');

        //Búsquedas según los parámetros introducidos
        if(!(empty($email)) && !empty($nombre) && !empty($apellidos) && !empty($telefono) && !empty($validez)){
            //Buscar Usuario por email, nombre, apellidos, teléfono y validez
            $usuariosTemp = $em->getRepository(Usuario::class)->createQueryBuilder('u')
                                                              ->where('u.email LIKE :email')
                                                              ->andWhere('u.nombre LIKE :nombre')
                                                              ->andWhere('u.apellidos LIKE :apellidos')
                                                              ->andWhere('u.telefono LIKE :telefono')
                                                              ->andWhere('u.validez LIKE :validez')
                                                              ->orderBy('u.apellidos', 'ASC')
                                                              ->setParameter('email','%'.$email.'%')
                                                              ->setParameter('nombre','%'.$nombre.'%')
                                                              ->setParameter('apellidos','%'.$apellidos.'%')
                                                              ->setParameter('telefono','%'.$telefono.'%')
                                                              ->setParameter('validez','%'.$validez.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($email)) && !empty($nombre) && !empty($apellidos) && !empty($telefono) && empty($validez)){
            //Buscar Usuario por email, nombre, apellidos y teléfono
            $usuariosTemp = $em->getRepository(Usuario::class)->createQueryBuilder('u')
                                                              ->where('u.email LIKE :email')
                                                              ->andWhere('u.nombre LIKE :nombre')
                                                              ->andWhere('u.apellidos LIKE :apellidos')
                                                              ->andWhere('u.telefono LIKE :telefono')
                                                              ->orderBy('u.apellidos', 'ASC')
                                                              ->setParameter('email','%'.$email.'%')
                                                              ->setParameter('nombre','%'.$nombre.'%')
                                                              ->setParameter('apellidos','%'.$apellidos.'%')
                                                              ->setParameter('telefono','%'.$telefono.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($email)) && !empty($nombre) && !empty($apellidos) && empty($telefono) && !empty($validez)){
            //Buscar Usuario por email, nombre, apellidos y validez
            $usuariosTemp = $em->getRepository(Usuario::class)->createQueryBuilder('u')
                                                              ->where('u.email LIKE :email')
                                                              ->andWhere('u.nombre LIKE :nombre')
                                                              ->andWhere('u.apellidos LIKE :apellidos')
                                                              ->andWhere('u.validez LIKE :validez')
                                                              ->orderBy('u.apellidos', 'ASC')
                                                              ->setParameter('email','%'.$email.'%')
                                                              ->setParameter('nombre','%'.$nombre.'%')
                                                              ->setParameter('apellidos','%'.$apellidos.'%')
                                                              ->setParameter('validez','%'.$validez.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($email)) && !empty($nombre) && !empty($apellidos) && empty($telefono) && empty($validez)){
            //Buscar Usuario por email, nombre y apellidos
            $usuariosTemp = $em->getRepository(Usuario::class)->createQueryBuilder('u')
                                                              ->where('u.email LIKE :email')
                                                              ->andWhere('u.nombre LIKE :nombre')
                                                              ->andWhere('u.apellidos LIKE :apellidos')
                                                              ->orderBy('u.apellidos', 'ASC')
                                                              ->setParameter('email','%'.$email.'%')
                                                              ->setParameter('nombre','%'.$nombre.'%')
                                                              ->setParameter('apellidos','%'.$apellidos.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($email)) && !empty($nombre) && empty($apellidos) && !empty($telefono) && !empty($validez)){
            //Buscar Usuario por email, nombre, teléfono y validez
            $usuariosTemp = $em->getRepository(Usuario::class)->createQueryBuilder('u')
                                                              ->where('u.email LIKE :email')
                                                              ->andWhere('u.nombre LIKE :nombre')
                                                              ->andWhere('u.telefono LIKE :telefono')
                                                              ->andWhere('u.validez LIKE :validez')
                                                              ->orderBy('u.apellidos', 'ASC')
                                                              ->setParameter('email','%'.$email.'%')
                                                              ->setParameter('nombre','%'.$nombre.'%')
                                                              ->setParameter('telefono','%'.$telefono.'%')
                                                              ->setParameter('validez','%'.$validez.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($email)) && !empty($nombre) && empty($apellidos) && !empty($telefono) && empty($validez)){
            //Buscar Usuario por email, nombre y teléfono
            $usuariosTemp = $em->getRepository(Usuario::class)->createQueryBuilder('u')
                                                              ->where('u.email LIKE :email')
                                                              ->andWhere('u.nombre LIKE :nombre')
                                                              ->andWhere('u.telefono LIKE :telefono')
                                                              ->orderBy('u.apellidos', 'ASC')
                                                              ->setParameter('email','%'.$email.'%')
                                                              ->setParameter('nombre','%'.$nombre.'%')
                                                              ->setParameter('telefono','%'.$telefono.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($email)) && !empty($nombre) && empty($apellidos) && empty($telefono) && !empty($validez)){
            //Buscar Usuario por email, nombre y validez
            $usuariosTemp = $em->getRepository(Usuario::class)->createQueryBuilder('u')
                                                              ->where('u.email LIKE :email')
                                                              ->andWhere('u.nombre LIKE :nombre')
                                                              ->andWhere('u.validez LIKE :validez')
                                                              ->orderBy('u.apellidos', 'ASC')
                                                              ->setParameter('email','%'.$email.'%')
                                                              ->setParameter('nombre','%'.$nombre.'%')
                                                              ->setParameter('validez','%'.$validez.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($email)) && !empty($nombre) && empty($apellidos) && empty($telefono) && empty($validez)){
            //Buscar Usuario por email y nombre
            $usuariosTemp = $em->getRepository(Usuario::class)->createQueryBuilder('u')
                                                              ->where('u.email LIKE :email')
                                                              ->andWhere('u.nombre LIKE :nombre')
                                                              ->orderBy('u.apellidos', 'ASC')
                                                              ->setParameter('email','%'.$email.'%')
                                                              ->setParameter('nombre','%'.$nombre.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($email)) && empty($nombre) && !empty($apellidos) && !empty($telefono) && !empty($validez)){
            //Buscar Usuario por email, apellidos, teléfono y validez
            $usuariosTemp = $em->getRepository(Usuario::class)->createQueryBuilder('u')
                                                              ->where('u.email LIKE :email')
                                                              ->andWhere('u.apellidos LIKE :apellidos')
                                                              ->andWhere('u.telefono LIKE :telefono')
                                                              ->andWhere('u.validez LIKE :validez')
                                                              ->orderBy('u.apellidos', 'ASC')
                                                              ->setParameter('email','%'.$email.'%')
                                                              ->setParameter('apellidos','%'.$apellidos.'%')
                                                              ->setParameter('telefono','%'.$telefono.'%')
                                                              ->setParameter('validez','%'.$validez.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($email)) && empty($nombre) && !empty($apellidos) && !empty($telefono) && empty($validez)){
            //Buscar Usuario por email, apellidos y teléfono
            $usuariosTemp = $em->getRepository(Usuario::class)->createQueryBuilder('u')
                                                              ->where('u.email LIKE :email')
                                                              ->andWhere('u.apellidos LIKE :apellidos')
                                                              ->andWhere('u.telefono LIKE :telefono')
                                                              ->orderBy('u.apellidos', 'ASC')
                                                              ->setParameter('email','%'.$email.'%')
                                                              ->setParameter('apellidos','%'.$apellidos.'%')
                                                              ->setParameter('telefono','%'.$telefono.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($email)) && empty($nombre) && !empty($apellidos) && empty($telefono) && !empty($validez)){
            //Buscar Usuario por email, apellidos y validez
            $usuariosTemp = $em->getRepository(Usuario::class)->createQueryBuilder('u')
                                                              ->where('u.email LIKE :email')
                                                              ->andWhere('u.apellidos LIKE :apellidos')
                                                              ->andWhere('u.validez LIKE :validez')
                                                              ->orderBy('u.apellidos', 'ASC')
                                                              ->setParameter('email','%'.$email.'%')
                                                              ->setParameter('apellidos','%'.$apellidos.'%')
                                                              ->setParameter('validez','%'.$validez.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($email)) && empty($nombre) && !empty($apellidos) && empty($telefono) && empty($validez)){
            //Buscar Usuario por email y apellidos
            $usuariosTemp = $em->getRepository(Usuario::class)->createQueryBuilder('u')
                                                              ->where('u.email LIKE :email')
                                                              ->andWhere('u.apellidos LIKE :apellidos')
                                                              ->orderBy('u.apellidos', 'ASC')
                                                              ->setParameter('email','%'.$email.'%')
                                                              ->setParameter('apellidos','%'.$apellidos.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($email)) && empty($nombre) && empty($apellidos) && !empty($telefono) && !empty($validez)){
            //Buscar Usuario por email, teléfono y validez
            $usuariosTemp = $em->getRepository(Usuario::class)->createQueryBuilder('u')
                                                              ->where('u.email LIKE :email')
                                                              ->andWhere('u.telefono LIKE :telefono')
                                                              ->andWhere('u.validez LIKE :validez')
                                                              ->orderBy('u.apellidos', 'ASC')
                                                              ->setParameter('email','%'.$email.'%')
                                                              ->setParameter('telefono','%'.$telefono.'%')
                                                              ->setParameter('validez','%'.$validez.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($email)) && empty($nombre) && empty($apellidos) && !empty($telefono) && empty($validez)){
            //Buscar Usuario por email y teléfono 
            $usuariosTemp = $em->getRepository(Usuario::class)->createQueryBuilder('u')
                                                              ->where('u.email LIKE :email')
                                                              ->andWhere('u.telefono LIKE :telefono')
                                                              ->orderBy('u.apellidos', 'ASC')
                                                              ->setParameter('email','%'.$email.'%')
                                                              ->setParameter('telefono','%'.$telefono.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($email)) && empty($nombre) && empty($apellidos) && empty($telefono) && !empty($validez)){
            //Buscar Usuario por email y validez
            $usuariosTemp = $em->getRepository(Usuario::class)->createQueryBuilder('u')
                                                              ->where('u.email LIKE :email')
                                                              ->andWhere('u.validez LIKE :validez')
                                                              ->orderBy('u.apellidos', 'ASC')
                                                              ->setParameter('email','%'.$email.'%')
                                                              ->setParameter('validez','%'.$validez.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($email)) && empty($nombre) && empty($apellidos) && empty($telefono) && empty($validez)){
            //Buscar Usuario por email
            $usuariosTemp = $em->getRepository(Usuario::class)->createQueryBuilder('u')
                                                              ->where('u.email LIKE :email')
                                                              ->orderBy('u.apellidos', 'ASC')
                                                              ->setParameter('email','%'.$email.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($email)) && !empty($nombre) && !empty($apellidos) && !empty($telefono) && !empty($validez)){
            //Buscar Usuario por nombre, apellidos, teléfono y validez
            $usuariosTemp = $em->getRepository(Usuario::class)->createQueryBuilder('u')
                                                              ->where('u.nombre LIKE :nombre')
                                                              ->andWhere('u.apellidos LIKE :apellidos')
                                                              ->andWhere('u.telefono LIKE :telefono')
                                                              ->andWhere('u.validez LIKE :validez')
                                                              ->orderBy('u.apellidos', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre.'%')
                                                              ->setParameter('apellidos','%'.$apellidos.'%')
                                                              ->setParameter('telefono','%'.$telefono.'%')
                                                              ->setParameter('validez','%'.$validez.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($email)) && !empty($nombre) && !empty($apellidos) && !empty($telefono) && empty($validez)){
            //Buscar Usuario por nombre, apellidos y teléfono
            $usuariosTemp = $em->getRepository(Usuario::class)->createQueryBuilder('u')
                                                              ->where('u.nombre LIKE :nombre')
                                                              ->andWhere('u.apellidos LIKE :apellidos')
                                                              ->andWhere('u.telefono LIKE :telefono')
                                                              ->orderBy('u.apellidos', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre.'%')
                                                              ->setParameter('apellidos','%'.$apellidos.'%')
                                                              ->setParameter('telefono','%'.$telefono.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($email)) && !empty($nombre) && !empty($apellidos) && empty($telefono) && !empty($validez)){
            //Buscar Usuario por nombre, apellidos y validez
            $usuariosTemp = $em->getRepository(Usuario::class)->createQueryBuilder('u')
                                                              ->where('u.nombre LIKE :nombre')
                                                              ->andWhere('u.apellidos LIKE :apellidos')
                                                              ->andWhere('u.validez LIKE :validez')
                                                              ->orderBy('u.apellidos', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre.'%')
                                                              ->setParameter('apellidos','%'.$apellidos.'%')
                                                              ->setParameter('validez','%'.$validez.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($email)) && !empty($nombre) && !empty($apellidos) && empty($telefono) && empty($validez)){
            //Buscar Usuario por nombre y apellidos
            $usuariosTemp = $em->getRepository(Usuario::class)->createQueryBuilder('u')
                                                              ->where('u.nombre LIKE :nombre')
                                                              ->andWhere('u.apellidos LIKE :apellidos')
                                                              ->orderBy('u.apellidos', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre.'%')
                                                              ->setParameter('apellidos','%'.$apellidos.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($email)) && !empty($nombre) && empty($apellidos) && !empty($telefono) && !empty($validez)){
            //Buscar Usuario por nombre, teléfono y validez
            $usuariosTemp = $em->getRepository(Usuario::class)->createQueryBuilder('u')
                                                              ->where('u.nombre LIKE :nombre')
                                                              ->andWhere('u.telefono LIKE :telefono')
                                                              ->andWhere('u.validez LIKE :validez')
                                                              ->orderBy('u.apellidos', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre.'%')
                                                              ->setParameter('telefono','%'.$telefono.'%')
                                                              ->setParameter('validez','%'.$validez.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($email)) && !empty($nombre) && empty($apellidos) && !empty($telefono) && empty($validez)){
            //Buscar Usuario por nombre y teléfono
            $usuariosTemp = $em->getRepository(Usuario::class)->createQueryBuilder('u')
                                                              ->where('u.nombre LIKE :nombre')
                                                              ->andWhere('u.telefono LIKE :telefono')
                                                              ->orderBy('u.apellidos', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre.'%')
                                                              ->setParameter('telefono','%'.$telefono.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($email)) && !empty($nombre) && empty($apellidos) && empty($telefono) && !empty($validez)){
            //Buscar Usuario por nombre y validez
            $usuariosTemp = $em->getRepository(Usuario::class)->createQueryBuilder('u')
                                                              ->where('u.nombre LIKE :nombre')
                                                              ->andWhere('u.validez LIKE :validez')
                                                              ->orderBy('u.apellidos', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre.'%')
                                                              ->setParameter('validez','%'.$validez.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($email)) && !empty($nombre) && empty($apellidos) && empty($telefono) && empty($validez)){
            //Buscar Usuario por nombre
            $usuariosTemp = $em->getRepository(Usuario::class)->createQueryBuilder('u')
                                                              ->where('u.nombre LIKE :nombre')
                                                              ->orderBy('u.apellidos', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($email)) && empty($nombre) && !empty($apellidos) && !empty($telefono) && !empty($validez)){
            //Buscar Usuario por apellidos, teléfono y validez
            $usuariosTemp = $em->getRepository(Usuario::class)->createQueryBuilder('u')
                                                              ->where('u.apellidos LIKE :apellidos')
                                                              ->andWhere('u.telefono LIKE :telefono')
                                                              ->andWhere('u.validez LIKE :validez')
                                                              ->orderBy('u.apellidos', 'ASC')
                                                              ->setParameter('apellidos','%'.$apellidos.'%')
                                                              ->setParameter('telefono','%'.$telefono.'%')
                                                              ->setParameter('validez','%'.$validez.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($email)) && empty($nombre) && !empty($apellidos) && !empty($telefono) && empty($validez)){
            //Buscar Usuario por apellidos y teléfono
            $usuariosTemp = $em->getRepository(Usuario::class)->createQueryBuilder('u')
                                                              ->where('u.apellidos LIKE :apellidos')
                                                              ->andWhere('u.telefono LIKE :telefono')
                                                              ->orderBy('u.apellidos', 'ASC')
                                                              ->setParameter('apellidos','%'.$apellidos.'%')
                                                              ->setParameter('telefono','%'.$telefono.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($email)) && empty($nombre) && !empty($apellidos) && empty($telefono) && !empty($validez)){
            //Buscar Usuario por apellidos y validez
            $usuariosTemp = $em->getRepository(Usuario::class)->createQueryBuilder('u')
                                                              ->where('u.apellidos LIKE :apellidos')
                                                              ->andWhere('u.validez LIKE :validez')
                                                              ->orderBy('u.apellidos', 'ASC')
                                                              ->setParameter('apellidos','%'.$apellidos.'%')
                                                              ->setParameter('validez','%'.$validez.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($email)) && empty($nombre) && !empty($apellidos) && empty($telefono) && empty($validez)){
            //Buscar Usuario por apellidos
            $usuariosTemp = $em->getRepository(Usuario::class)->createQueryBuilder('u')
                                                              ->andWhere('u.apellidos LIKE :apellidos')
                                                              ->orderBy('u.apellidos', 'ASC')
                                                              ->setParameter('apellidos','%'.$apellidos.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($email)) && empty($nombre) && empty($apellidos) && !empty($telefono) && !empty($validez)){
            //Buscar Usuario por teléfono y validez
            $usuariosTemp = $em->getRepository(Usuario::class)->createQueryBuilder('u')
                                                              ->where('u.telefono LIKE :telefono')
                                                              ->andWhere('u.validez LIKE :validez')
                                                              ->orderBy('u.apellidos', 'ASC')
                                                              ->setParameter('telefono','%'.$telefono.'%')
                                                              ->setParameter('validez','%'.$validez.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($email)) && empty($nombre) && empty($apellidos) && !empty($telefono) && empty($validez)){
            //Buscar Usuario por teléfono
            $usuariosTemp = $em->getRepository(Usuario::class)->createQueryBuilder('u')
                                                              ->andWhere('u.telefono LIKE :telefono')
                                                              ->orderBy('u.apellidos', 'ASC')
                                                              ->setParameter('telefono','%'.$telefono.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($email)) && empty($nombre) && empty($apellidos) && empty($telefono) && !empty($validez)){
            //Buscar Usuario por validez
            $usuariosTemp = $em->getRepository(Usuario::class)->createQueryBuilder('u')
                                                              ->where('u.validez LIKE :validez')
                                                              ->orderBy('u.apellidos', 'ASC')
                                                              ->setParameter('validez','%'.$validez.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        else {
            //Buscar todos los usuarios
            $usuariosTemp = $em->getRepository(Usuario::class)->findBy(array(), array('apellidos' => 'ASC'));
        }

        $usuarios = $usuariosTemp;

        return $this->render('administrador/usuariosEncontrados.html.twig', [
            'controller_name' => 'Buscar un Usuario',
            'usuarios' => $usuarios
        ]);
    }

    #[Route('/administrador/usuario/consultar/{id}', name: 'consultarUsuario')]
    public function consultarUsuario($id): Response
    {
        $em = $this->getDoctrine()->getManager();

        //Buscar el usuario a consultar
        $usuario = $em->getRepository(Usuario::class)->find($id);
        $form = $this->createForm(PerfilType::class, $usuario);

        return $this->render('administrador/consultarUsuario.html.twig', [
            'controller_name' => 'Datos del usuario',
            'formulario' => $form->createView(),
        ]);
    }

    #[Route('/administrador/usuario/modificar/{id}', name: 'modificarUsuario')]
    public function modificarUsuario(Request $request, $id): Response
    {
        $usuario = new Usuario();
        $em = $this->getDoctrine()->getManager();

        //Buscar el usuario a modificar
        $usuario = $em->getRepository(Usuario::class)->find($id);
        $form = $this->createForm(ModificarUsuarioType::class, $usuario);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $usuario->setValidez(validez: 'pendiente');

            //Se actualiza el usuario en la base de datos
            $em->persist($usuario);
            $em->flush();

            return $this->redirectToRoute(route: 'buscarUsuario');
        }

        return $this->render('administrador/modificarUsuario.html.twig', [
            'controller_name' => '',
            'formulario' => $form->createView()
        ]);
    }

    #[Route('/administrador/usuario/eliminar/{id}', name: 'eliminarUsuario')]
    public function eliminarUsuario(Request $request, $id): Response
    {
        $usuario = new Usuario();
        $em = $this->getDoctrine()->getManager();

        //Buscar el usuario a eliminar
        $usuario = $em->getRepository(Usuario::class)->find($id);
        $form = $this->createForm(ValidarUsuarioType::class, $usuario);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            //Se elimina la tupla del tipo de usuario
            if ($usuario->esCliente()) {
                $cliente = new Cliente();
                $cliente = $em->getRepository(Cliente::class)->findOneBy(array('id_usuario' => $id));

                //Eliminar la tupla del cliente
                $em->remove($cliente);
                $em->flush();
            }

            if ($usuario->esEmpresario()) {

                $empresario = new Empresario();
                $empresario = $em->getRepository(Empresario::class)->findOneBy(array('id_usuario' => $id));

                //Buscar las empresas del empresario
                $empresas = $em->getRepository(Empresa::class)->findBy(array('id_usuario' => $empresario->getId()));

                //Buscar los comercios de cada empresa
                $comercios = array();
                for($i = 0; $i < sizeof($empresas); $i++) {
                    $auxComercios = $em->getRepository(Comercio::class)->findBy(array('id_empresa' => $empresas[$i]->getId()));
                    if ($auxComercios !== null) {
                        for ($j = 0; $j < sizeof($auxComercios); $j++) {
                            array_push($comercios,$auxComercios[$j]);
                        }
                    }
                }

                //Buscar las ofertas de cada comercio
                $ofertas = array();
                for($i = 0; $i < sizeof($comercios); $i++) {
                    $aux = $em->getRepository(Oferta::class)->findBy(array('id_comercio' => $comercios[$i]->getId()));
                    if($aux !== null) {
                        for ($j = 0; $j < sizeof($aux); $j++) {
                            array_push($ofertas,$aux[$j]);
                        }
                    }
                }

                //Eliminar las ofertas
                for($i = 0; $i < sizeof($ofertas); $i++) {
                    $em->remove($ofertas[$i]);
                    $em->flush();
                }

                //Eliminar los comercios
                for($i = 0; $i < sizeof($comercios); $i++) {
                    $em->remove($comercios[$i]);
                    $em->flush();
                }

                //Eliminar las empresas
                for($i = 0; $i < sizeof($empresas); $i++) {
                    $em->remove($empresas[$i]);
                    $em->flush();
                }

                //Eliminar la tupla del empresario
                $em->remove($empresario);
                $em->flush();
            }

            if ($usuario->esAdministrador()) {
                $administrador = new Administrador();
                $administrador = $em->getRepository(Administrador::class)->findOneBy(array('id_usuario' => $id));

                //Eliminar la tupla del administrador
                $em->remove($administrador);
                $em->flush();
            }

            //Se elimina el usuario de la base de datos
            $em->remove($usuario);
            $em->flush();

            return $this->redirectToRoute(route: 'buscarUsuario');
        }

        return $this->render('administrador/eliminarUsuario.html.twig', [
            'controller_name' => '',
            'formulario' => $form->createView()
        ]);
    }

    #[Route('/administrador/usuario/validar/{id}', name: 'validarUsuario')]
    public function validarUsuario(Request $request, $id): Response
    {
        $usuario = new Usuario();
        $em = $this->getDoctrine()->getManager();

        //Buscar el usuario a validar
        $usuario = $em->getRepository(Usuario::class)->find($id);
        $form = $this->createForm(ValidarUsuarioType::class, $usuario);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $usuario->setValidez(validez: 'sí');

            //Se actualiza el usuario en la base de datos
            $em->persist($usuario);
            $em->flush();

            return $this->redirectToRoute(route: 'buscarUsuario');
        }

        return $this->render('administrador/validarUsuario.html.twig', [
            'controller_name' => '',
            'formulario' => $form->createView()
        ]);
    }

    #[Route('/administrador/usuario/rechazar/{id}', name: 'rechazarUsuario')]
    public function rechazarUsuario(Request $request, $id): Response
    {
        $usuario = new Usuario();
        $em = $this->getDoctrine()->getManager();

        //Buscar el usuario a validar
        $usuario = $em->getRepository(Usuario::class)->find($id);
        $form = $this->createForm(ValidarUsuarioType::class, $usuario);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $usuario->setValidez(validez: 'no');

            //Se actualiza el usuario en la base de datos
            $em->persist($usuario);
            $em->flush();

            return $this->redirectToRoute(route: 'buscarUsuario');
        }

        return $this->render('administrador/rechazarUsuario.html.twig', [
            'controller_name' => '',
            'formulario' => $form->createView(),
        ]);
    }

    #[Route('/administrador/usuario/registrar', name: 'registrarUsuarioAdmin')]
    public function registrarUsuarioAdmin(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $usuario = new Usuario();
        $cliente = new Cliente();
        $empresario = new Empresario();
        $administrador = new Administrador();
        $form = $this->createForm(UsuarioAdminType::class, $usuario);
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
            return $this->redirectToRoute(route: 'administrador');
        }

        return $this->render('administrador/registrarUsuario.html.twig', [
            'controller_name' => '',
            'formulario' => $form->createView(),
            'formC' => $formC->createView(),
            'formE' => $formE->createView(),
            'formA' => $formA->createView()
        ]);
    }

    #[Route('/administrador/empresa/buscar', name: 'buscarEmpresaAdmin')]
    public function buscarEmpresa(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $empresas = "";
        $empresasTemp = "";

        //Parámetros de búsqueda
        $nombre_empresa = $request->request->get('nombre_empresa');
        $direccion_empresa = $request->request->get('direccion_empresa');
        $localidad_empresa = $request->request->get('localidad_empresa');
        $provincia_empresa = $request->request->get('provincia_empresa');
        $cp_empresa = $request->request->get('cp_empresa');
        $telefono_empresa = $request->request->get('telefono_empresa');

        //Búsquedas según los parámetros introducidos
        if(!(empty($nombre_empresa)) && !empty($direccion_empresa) && !empty($localidad_empresa) && !empty($provincia_empresa) && !empty($cp_empresa) && !empty($telefono_empresa)){
            //Buscar Empresa por nombre, dirección, localidad, provincia, código postal y teléfono
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.nombre_empresa LIKE :nombre')
                                                              ->andWhere('e.direccion_empresa LIKE :direccion')
                                                              ->andWhere('e.localidad_empresa LIKE :localidad')
                                                              ->andWhere('e.provincia_empresa LIKE :provincia')
                                                              ->andWhere('e.cp_empresa LIKE :cp')
                                                              ->andWhere('e.telefono_empresa LIKE :telefono')
                                                              ->orderBy('e.nombre_empresa', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_empresa.'%')
                                                              ->setParameter('direccion','%'.$direccion_empresa.'%')
                                                              ->setParameter('localidad','%'.$localidad_empresa.'%')
                                                              ->setParameter('provincia','%'.$provincia_empresa.'%')
                                                              ->setParameter('cp','%'.$cp_empresa.'%')
                                                              ->setParameter('telefono','%'.$telefono_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_empresa)) && !empty($direccion_empresa) && !empty($localidad_empresa) && !empty($provincia_empresa) && !empty($cp_empresa) && empty($telefono_empresa)){
            //Buscar Empresa por nombre, dirección, localidad, provincia y código postal
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.nombre_empresa LIKE :nombre')
                                                              ->andWhere('e.direccion_empresa LIKE :direccion')
                                                              ->andWhere('e.localidad_empresa LIKE :localidad')
                                                              ->andWhere('e.provincia_empresa LIKE :provincia')
                                                              ->andWhere('e.cp_empresa LIKE :cp')
                                                              ->orderBy('e.nombre_empresa', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_empresa.'%')
                                                              ->setParameter('direccion','%'.$direccion_empresa.'%')
                                                              ->setParameter('localidad','%'.$localidad_empresa.'%')
                                                              ->setParameter('provincia','%'.$provincia_empresa.'%')
                                                              ->setParameter('cp','%'.$cp_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_empresa)) && !empty($direccion_empresa) && !empty($localidad_empresa) && !empty($provincia_empresa) && empty($cp_empresa) && !empty($telefono_empresa)){
            //Buscar Empresa por nombre, dirección, localidad, provincia y teléfono
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.nombre_empresa LIKE :nombre')
                                                              ->andWhere('e.direccion_empresa LIKE :direccion')
                                                              ->andWhere('e.localidad_empresa LIKE :localidad')
                                                              ->andWhere('e.provincia_empresa LIKE :provincia')
                                                              ->andWhere('e.telefono_empresa LIKE :telefono')
                                                              ->orderBy('e.nombre_empresa', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_empresa.'%')
                                                              ->setParameter('direccion','%'.$direccion_empresa.'%')
                                                              ->setParameter('localidad','%'.$localidad_empresa.'%')
                                                              ->setParameter('provincia','%'.$provincia_empresa.'%')
                                                              ->setParameter('telefono','%'.$telefono_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_empresa)) && !empty($direccion_empresa) && !empty($localidad_empresa) && empty($provincia_empresa) && !empty($cp_empresa) && !empty($telefono_empresa)){
            //Buscar Empresa por nombre, dirección, localidad, código postal y teléfono
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.nombre_empresa LIKE :nombre')
                                                              ->andWhere('e.direccion_empresa LIKE :direccion')
                                                              ->andWhere('e.localidad_empresa LIKE :localidad')
                                                              ->andWhere('e.cp_empresa LIKE :cp')
                                                              ->andWhere('e.telefono_empresa LIKE :telefono')
                                                              ->orderBy('e.nombre_empresa', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_empresa.'%')
                                                              ->setParameter('direccion','%'.$direccion_empresa.'%')
                                                              ->setParameter('localidad','%'.$localidad_empresa.'%')
                                                              ->setParameter('cp','%'.$cp_empresa.'%')
                                                              ->setParameter('telefono','%'.$telefono_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_empresa)) && !empty($direccion_empresa) && empty($localidad_empresa) && !empty($provincia_empresa) && !empty($cp_empresa) && !empty($telefono_empresa)){
            //Buscar Empresa por nombre, dirección, provincia, código postal y teléfono
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.nombre_empresa LIKE :nombre')
                                                              ->andWhere('e.direccion_empresa LIKE :direccion')
                                                              ->andWhere('e.provincia_empresa LIKE :provincia')
                                                              ->andWhere('e.cp_empresa LIKE :cp')
                                                              ->andWhere('e.telefono_empresa LIKE :telefono')
                                                              ->orderBy('e.nombre_empresa', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_empresa.'%')
                                                              ->setParameter('direccion','%'.$direccion_empresa.'%')
                                                              ->setParameter('provincia','%'.$provincia_empresa.'%')
                                                              ->setParameter('cp','%'.$cp_empresa.'%')
                                                              ->setParameter('telefono','%'.$telefono_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_empresa)) && empty($direccion_empresa) && !empty($localidad_empresa) && !empty($provincia_empresa) && !empty($cp_empresa) && !empty($telefono_empresa)){
            //Buscar Empresa por nombre, localidad, provincia, código postal y teléfono
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.nombre_empresa LIKE :nombre')
                                                              ->andWhere('e.localidad_empresa LIKE :localidad')
                                                              ->andWhere('e.provincia_empresa LIKE :provincia')
                                                              ->andWhere('e.cp_empresa LIKE :cp')
                                                              ->andWhere('e.telefono_empresa LIKE :telefono')
                                                              ->orderBy('e.nombre_empresa', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_empresa.'%')
                                                              ->setParameter('localidad','%'.$localidad_empresa.'%')
                                                              ->setParameter('provincia','%'.$provincia_empresa.'%')
                                                              ->setParameter('cp','%'.$cp_empresa.'%')
                                                              ->setParameter('telefono','%'.$telefono_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_empresa)) && !empty($direccion_empresa) && !empty($localidad_empresa) && !empty($provincia_empresa) && !empty($cp_empresa) && !empty($telefono_empresa)){
            //Buscar Empresa por nombre, dirección, localidad, provincia, código postal y teléfono
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.direccion_empresa LIKE :direccion')
                                                              ->andWhere('e.localidad_empresa LIKE :localidad')
                                                              ->andWhere('e.provincia_empresa LIKE :provincia')
                                                              ->andWhere('e.cp_empresa LIKE :cp')
                                                              ->andWhere('e.telefono_empresa LIKE :telefono')
                                                              ->orderBy('e.localidad_empresa', 'ASC')
                                                              ->setParameter('direccion','%'.$direccion_empresa.'%')
                                                              ->setParameter('localidad','%'.$localidad_empresa.'%')
                                                              ->setParameter('provincia','%'.$provincia_empresa.'%')
                                                              ->setParameter('cp','%'.$cp_empresa.'%')
                                                              ->setParameter('telefono','%'.$telefono_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_empresa)) && !empty($direccion_empresa) && !empty($localidad_empresa) && !empty($provincia_empresa) && empty($cp_empresa) && empty($telefono_empresa)){
            //Buscar Empresa por nombre, dirección, localidad y provincia
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.nombre_empresa LIKE :nombre')
                                                              ->andWhere('e.direccion_empresa LIKE :direccion')
                                                              ->andWhere('e.localidad_empresa LIKE :localidad')
                                                              ->andWhere('e.provincia_empresa LIKE :provincia')
                                                              ->orderBy('e.nombre_empresa', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_empresa.'%')
                                                              ->setParameter('direccion','%'.$direccion_empresa.'%')
                                                              ->setParameter('localidad','%'.$localidad_empresa.'%')
                                                              ->setParameter('provincia','%'.$provincia_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_empresa)) && !empty($direccion_empresa) && !empty($localidad_empresa) && empty($provincia_empresa) && !empty($cp_empresa) && empty($telefono_empresa)){
            //Buscar Empresa por nombre, dirección, localidad, y código postal 
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.nombre_empresa LIKE :nombre')
                                                              ->andWhere('e.direccion_empresa LIKE :direccion')
                                                              ->andWhere('e.localidad_empresa LIKE :localidad')
                                                              ->andWhere('e.cp_empresa LIKE :cp')
                                                              ->orderBy('e.nombre_empresa', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_empresa.'%')
                                                              ->setParameter('direccion','%'.$direccion_empresa.'%')
                                                              ->setParameter('localidad','%'.$localidad_empresa.'%')
                                                              ->setParameter('cp','%'.$cp_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_empresa)) && !empty($direccion_empresa) && empty($localidad_empresa) && !empty($provincia_empresa) && !empty($cp_empresa) && empty($telefono_empresa)){
            //Buscar Empresa por nombre, dirección, provincia y código postal
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.nombre_empresa LIKE :nombre')
                                                              ->andWhere('e.direccion_empresa LIKE :direccion')
                                                              ->andWhere('e.provincia_empresa LIKE :provincia')
                                                              ->andWhere('e.cp_empresa LIKE :cp')
                                                              ->orderBy('e.nombre_empresa', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_empresa.'%')
                                                              ->setParameter('direccion','%'.$direccion_empresa.'%')
                                                              ->setParameter('provincia','%'.$provincia_empresa.'%')
                                                              ->setParameter('cp','%'.$cp_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_empresa)) && empty($direccion_empresa) && !empty($localidad_empresa) && !empty($provincia_empresa) && !empty($cp_empresa) && empty($telefono_empresa)){
            //Buscar Empresa por nombre, localidad, provincia y código postal
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.nombre_empresa LIKE :nombre')
                                                              ->andWhere('e.localidad_empresa LIKE :localidad')
                                                              ->andWhere('e.provincia_empresa LIKE :provincia')
                                                              ->andWhere('e.cp_empresa LIKE :cp')
                                                              ->orderBy('e.nombre_empresa', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_empresa.'%')
                                                              ->setParameter('localidad','%'.$localidad_empresa.'%')
                                                              ->setParameter('provincia','%'.$provincia_empresa.'%')
                                                              ->setParameter('cp','%'.$cp_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        if((empty($nombre_empresa)) && !empty($direccion_empresa) && !empty($localidad_empresa) && !empty($provincia_empresa) && !empty($cp_empresa) && empty($telefono_empresa)){
            //Buscar Empresa por dirección, localidad, provincia y código postal
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.direccion_empresa LIKE :direccion')
                                                              ->andWhere('e.localidad_empresa LIKE :localidad')
                                                              ->andWhere('e.provincia_empresa LIKE :provincia')
                                                              ->andWhere('e.cp_empresa LIKE :cp')
                                                              ->orderBy('e.localidad_empresa', 'ASC')
                                                              ->setParameter('direccion','%'.$direccion_empresa.'%')
                                                              ->setParameter('localidad','%'.$localidad_empresa.'%')
                                                              ->setParameter('provincia','%'.$provincia_empresa.'%')
                                                              ->setParameter('cp','%'.$cp_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_empresa)) && !empty($direccion_empresa) && !empty($localidad_empresa) && empty($provincia_empresa) && empty($cp_empresa) && !empty($telefono_empresa)){
            //Buscar Empresa por nombre, dirección, localidad y teléfono
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.nombre_empresa LIKE :nombre')
                                                              ->andWhere('e.direccion_empresa LIKE :direccion')
                                                              ->andWhere('e.localidad_empresa LIKE :localidad')
                                                              ->andWhere('e.telefono_empresa LIKE :telefono')
                                                              ->orderBy('e.nombre_empresa', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_empresa.'%')
                                                              ->setParameter('direccion','%'.$direccion_empresa.'%')
                                                              ->setParameter('localidad','%'.$localidad_empresa.'%')
                                                              ->setParameter('telefono','%'.$telefono_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_empresa)) && !empty($direccion_empresa) && empty($localidad_empresa) && !empty($provincia_empresa) && empty($cp_empresa) && !empty($telefono_empresa)){
            //Buscar Empresa por nombre, dirección, provincia y teléfono
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.nombre_empresa LIKE :nombre')
                                                              ->andWhere('e.direccion_empresa LIKE :direccion')
                                                              ->andWhere('e.provincia_empresa LIKE :provincia')
                                                              ->andWhere('e.telefono_empresa LIKE :telefono')
                                                              ->orderBy('e.nombre_empresa', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_empresa.'%')
                                                              ->setParameter('direccion','%'.$direccion_empresa.'%')
                                                              ->setParameter('provincia','%'.$provincia_empresa.'%')
                                                              ->setParameter('telefono','%'.$telefono_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_empresa)) && empty($direccion_empresa) && !empty($localidad_empresa) && !empty($provincia_empresa) && empty($cp_empresa) && !empty($telefono_empresa)){
            //Buscar Empresa por nombre, localidad, provincia y teléfono
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.nombre_empresa LIKE :nombre')
                                                              ->andWhere('e.localidad_empresa LIKE :localidad')
                                                              ->andWhere('e.provincia_empresa LIKE :provincia')
                                                              ->andWhere('e.telefono_empresa LIKE :telefono')
                                                              ->orderBy('e.nombre_empresa', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_empresa.'%')
                                                              ->setParameter('localidad','%'.$localidad_empresa.'%')
                                                              ->setParameter('provincia','%'.$provincia_empresa.'%')
                                                              ->setParameter('telefono','%'.$telefono_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_empresa)) && !empty($direccion_empresa) && !empty($localidad_empresa) && !empty($provincia_empresa) && empty($cp_empresa) && !empty($telefono_empresa)){
            //Buscar Empresa por dirección, localidad, provincia y teléfono
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.direccion_empresa LIKE :direccion')
                                                              ->andWhere('e.localidad_empresa LIKE :localidad')
                                                              ->andWhere('e.provincia_empresa LIKE :provincia')
                                                              ->andWhere('e.cp_empresa LIKE :cp')
                                                              ->andWhere('e.telefono_empresa LIKE :telefono')
                                                              ->orderBy('e.localidad_empresa', 'ASC')
                                                              ->setParameter('direccion','%'.$direccion_empresa.'%')
                                                              ->setParameter('localidad','%'.$localidad_empresa.'%')
                                                              ->setParameter('provincia','%'.$provincia_empresa.'%')
                                                              ->setParameter('telefono','%'.$telefono_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_empresa)) && !empty($direccion_empresa) && empty($localidad_empresa) && empty($provincia_empresa) && !empty($cp_empresa) && !empty($telefono_empresa)){
            //Buscar Empresa por nombre, dirección, código postal y teléfono
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.nombre_empresa LIKE :nombre')
                                                              ->andWhere('e.direccion_empresa LIKE :direccion')
                                                              ->andWhere('e.cp_empresa LIKE :cp')
                                                              ->andWhere('e.telefono_empresa LIKE :telefono')
                                                              ->orderBy('e.nombre_empresa', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_empresa.'%')
                                                              ->setParameter('direccion','%'.$direccion_empresa.'%')
                                                              ->setParameter('cp','%'.$cp_empresa.'%')
                                                              ->setParameter('telefono','%'.$telefono_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_empresa)) && empty($direccion_empresa) && !empty($localidad_empresa) && empty($provincia_empresa) && !empty($cp_empresa) && !empty($telefono_empresa)){
            //Buscar Empresa por nombre, localidad, código postal y teléfono
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.nombre_empresa LIKE :nombre')
                                                              ->andWhere('e.localidad_empresa LIKE :localidad')
                                                              ->andWhere('e.cp_empresa LIKE :cp')
                                                              ->andWhere('e.telefono_empresa LIKE :telefono')
                                                              ->orderBy('e.nombre_empresa', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_empresa.'%')
                                                              ->setParameter('localidad','%'.$localidad_empresa.'%')
                                                              ->setParameter('cp','%'.$cp_empresa.'%')
                                                              ->setParameter('telefono','%'.$telefono_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_empresa)) && !empty($direccion_empresa) && !empty($localidad_empresa) && empty($provincia_empresa) && !empty($cp_empresa) && !empty($telefono_empresa)){
            //Buscar Empresa por dirección, localidad, código postal y teléfono
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.direccion_empresa LIKE :direccion')
                                                              ->andWhere('e.localidad_empresa LIKE :localidad')
                                                              ->andWhere('e.cp_empresa LIKE :cp')
                                                              ->andWhere('e.telefono_empresa LIKE :telefono')
                                                              ->orderBy('e.localidad_empresa', 'ASC')
                                                              ->setParameter('direccion','%'.$direccion_empresa.'%')
                                                              ->setParameter('localidad','%'.$localidad_empresa.'%')
                                                              ->setParameter('cp','%'.$cp_empresa.'%')
                                                              ->setParameter('telefono','%'.$telefono_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_empresa)) && empty($direccion_empresa) && empty($localidad_empresa) && !empty($provincia_empresa) && !empty($cp_empresa) && !empty($telefono_empresa)){
            //Buscar Empresa por nombre, provincia, código postal y teléfono
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.nombre_empresa LIKE :nombre')
                                                              ->andWhere('e.provincia_empresa LIKE :provincia')
                                                              ->andWhere('e.cp_empresa LIKE :cp')
                                                              ->andWhere('e.telefono_empresa LIKE :telefono')
                                                              ->orderBy('e.nombre_empresa', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_empresa.'%')
                                                              ->setParameter('provincia','%'.$provincia_empresa.'%')
                                                              ->setParameter('cp','%'.$cp_empresa.'%')
                                                              ->setParameter('telefono','%'.$telefono_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_empresa)) && !empty($direccion_empresa) && empty($localidad_empresa) && !empty($provincia_empresa) && !empty($cp_empresa) && !empty($telefono_empresa)){
            //Buscar Empresa por dirección, provincia, código postal y teléfono
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.direccion_empresa LIKE :direccion')
                                                              ->andWhere('e.provincia_empresa LIKE :provincia')
                                                              ->andWhere('e.cp_empresa LIKE :cp')
                                                              ->andWhere('e.telefono_empresa LIKE :telefono')
                                                              ->orderBy('e.telefono_empresa', 'ASC')
                                                              ->setParameter('direccion','%'.$direccion_empresa.'%')
                                                              ->setParameter('provincia','%'.$provincia_empresa.'%')
                                                              ->setParameter('cp','%'.$cp_empresa.'%')
                                                              ->setParameter('telefono','%'.$telefono_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_empresa)) && empty($direccion_empresa) && !empty($localidad_empresa) && !empty($provincia_empresa) && !empty($cp_empresa) && !empty($telefono_empresa)){
            //Buscar Empresa por localidad, provincia, código postal y teléfono
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.localidad_empresa LIKE :localidad')
                                                              ->andWhere('e.provincia_empresa LIKE :provincia')
                                                              ->andWhere('e.cp_empresa LIKE :cp')
                                                              ->andWhere('e.telefono_empresa LIKE :telefono')
                                                              ->orderBy('e.localidad_empresa', 'ASC')
                                                              ->setParameter('localidad','%'.$localidad_empresa.'%')
                                                              ->setParameter('provincia','%'.$provincia_empresa.'%')
                                                              ->setParameter('cp','%'.$cp_empresa.'%')
                                                              ->setParameter('telefono','%'.$telefono_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_empresa)) && !empty($direccion_empresa) && !empty($localidad_empresa) && empty($provincia_empresa) && empty($cp_empresa) && empty($telefono_empresa)){
            //Buscar Empresa por nombre, dirección y localidad
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.nombre_empresa LIKE :nombre')
                                                              ->andWhere('e.direccion_empresa LIKE :direccion')
                                                              ->andWhere('e.localidad_empresa LIKE :localidad')
                                                              ->orderBy('e.nombre_empresa', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_empresa.'%')
                                                              ->setParameter('direccion','%'.$direccion_empresa.'%')
                                                              ->setParameter('localidad','%'.$localidad_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_empresa)) && !empty($direccion_empresa) && empty($localidad_empresa) && !empty($provincia_empresa) && empty($cp_empresa) && empty($telefono_empresa)){
            //Buscar Empresa por nombre, dirección y provincia
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.nombre_empresa LIKE :nombre')
                                                              ->andWhere('e.direccion_empresa LIKE :direccion')
                                                              ->andWhere('e.provincia_empresa LIKE :provincia')
                                                              ->orderBy('e.nombre_empresa', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_empresa.'%')
                                                              ->setParameter('direccion','%'.$direccion_empresa.'%')
                                                              ->setParameter('provincia','%'.$provincia_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_empresa)) && empty($direccion_empresa) && !empty($localidad_empresa) && !empty($provincia_empresa) && empty($cp_empresa) && empty($telefono_empresa)){
            //Buscar Empresa por nombre, localidad y provincia
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.nombre_empresa LIKE :nombre')
                                                              ->andWhere('e.localidad_empresa LIKE :localidad')
                                                              ->andWhere('e.provincia_empresa LIKE :provincia')
                                                              ->orderBy('e.nombre_empresa', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_empresa.'%')
                                                              ->setParameter('localidad','%'.$localidad_empresa.'%')
                                                              ->setParameter('provincia','%'.$provincia_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_empresa)) && !empty($direccion_empresa) && !empty($localidad_empresa) && !empty($provincia_empresa) && empty($cp_empresa) && empty($telefono_empresa)){
            //Buscar Empresa por dirección, localidad y provincia
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.direccion_empresa LIKE :direccion')
                                                              ->andWhere('e.localidad_empresa LIKE :localidad')
                                                              ->andWhere('e.provincia_empresa LIKE :provincia')
                                                              ->orderBy('e.localidad_empresa', 'ASC')
                                                              ->setParameter('direccion','%'.$direccion_empresa.'%')
                                                              ->setParameter('localidad','%'.$localidad_empresa.'%')
                                                              ->setParameter('provincia','%'.$provincia_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_empresa)) && !empty($direccion_empresa) && empty($localidad_empresa) && empty($provincia_empresa) && empty($cp_empresa) && !empty($telefono_empresa)){
            //Buscar Empresa por nombre, dirección y teléfono
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.nombre_empresa LIKE :nombre')
                                                              ->andWhere('e.direccion_empresa LIKE :direccion')
                                                              ->andWhere('e.telefono_empresa LIKE :telefono')
                                                              ->orderBy('e.nombre_empresa', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_empresa.'%')
                                                              ->setParameter('direccion','%'.$direccion_empresa.'%')
                                                              ->setParameter('telefono','%'.$telefono_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_empresa)) && empty($direccion_empresa) && !empty($localidad_empresa) && empty($provincia_empresa) && empty($cp_empresa) && !empty($telefono_empresa)){
            //Buscar Empresa por nombre, localidad y teléfono
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.nombre_empresa LIKE :nombre')
                                                              ->andWhere('e.localidad_empresa LIKE :localidad')
                                                              ->andWhere('e.telefono_empresa LIKE :telefono')
                                                              ->orderBy('e.nombre_empresa', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_empresa.'%')
                                                              ->setParameter('localidad','%'.$localidad_empresa.'%')
                                                              ->setParameter('telefono','%'.$telefono_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_empresa)) && !empty($direccion_empresa) && !empty($localidad_empresa) && empty($provincia_empresa) && empty($cp_empresa) && !empty($telefono_empresa)){
            //Buscar Empresa por dirección, localidad y teléfono
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.direccion_empresa LIKE :direccion')
                                                              ->andWhere('e.localidad_empresa LIKE :localidad')
                                                              ->andWhere('e.telefono_empresa LIKE :telefono')
                                                              ->orderBy('e.localidad_empresa', 'ASC')
                                                              ->setParameter('direccion','%'.$direccion_empresa.'%')
                                                              ->setParameter('localidad','%'.$localidad_empresa.'%')
                                                              ->setParameter('telefono','%'.$telefono_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_empresa)) && empty($direccion_empresa) && empty($localidad_empresa) && empty($provincia_empresa) && !empty($cp_empresa) && !empty($telefono_empresa)){
            //Buscar Empresa por nombre, código postal y teléfono
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.nombre_empresa LIKE :nombre')
                                                              ->andWhere('e.cp_empresa LIKE :cp')
                                                              ->andWhere('e.telefono_empresa LIKE :telefono')
                                                              ->orderBy('e.nombre_empresa', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_empresa.'%')
                                                              ->setParameter('cp','%'.$cp_empresa.'%')
                                                              ->setParameter('telefono','%'.$telefono_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_empresa)) && !empty($direccion_empresa) && empty($localidad_empresa) && empty($provincia_empresa) && !empty($cp_empresa) && !empty($telefono_empresa)){
            //Buscar Empresa por dirección, código postal y teléfono
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.direccion_empresa LIKE :direccion')
                                                              ->andWhere('e.cp_empresa LIKE :cp')
                                                              ->andWhere('e.telefono_empresa LIKE :telefono')
                                                              ->orderBy('e.telefono_empresa', 'ASC')
                                                              ->setParameter('direccion','%'.$direccion_empresa.'%')
                                                              ->setParameter('cp','%'.$cp_empresa.'%')
                                                              ->setParameter('telefono','%'.$telefono_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_empresa)) && empty($direccion_empresa) && empty($localidad_empresa) && !empty($provincia_empresa) && !empty($cp_empresa) && !empty($telefono_empresa)){
            //Buscar Empresa por provincia, código postal y teléfono
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.provincia_empresa LIKE :provincia')
                                                              ->andWhere('e.cp_empresa LIKE :cp')
                                                              ->andWhere('e.telefono_empresa LIKE :telefono')
                                                              ->orderBy('e.telefono_empresa', 'ASC')
                                                              ->setParameter('provincia','%'.$provincia_empresa.'%')
                                                              ->setParameter('cp','%'.$cp_empresa.'%')
                                                              ->setParameter('telefono','%'.$telefono_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_empresa)) && empty($direccion_empresa) && !empty($localidad_empresa) && empty($provincia_empresa) && !empty($cp_empresa) && empty($telefono_empresa)){
            //Buscar Empresa por nombre, localidad y código postal
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.nombre_empresa LIKE :nombre')
                                                              ->andWhere('e.localidad_empresa LIKE :localidad')
                                                              ->andWhere('e.cp_empresa LIKE :cp')
                                                              ->orderBy('e.nombre_empresa', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_empresa.'%')
                                                              ->setParameter('localidad','%'.$localidad_empresa.'%')
                                                              ->setParameter('cp','%'.$cp_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_empresa)) && !empty($direccion_empresa) && empty($localidad_empresa) && !empty($provincia_empresa) && empty($cp_empresa) && !empty($telefono_empresa)){
            //Buscar Empresa por dirección, provincia y teléfono
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.direccion_empresa LIKE :direccion')
                                                              ->andWhere('e.provincia_empresa LIKE :provincia')
                                                              ->andWhere('e.telefono_empresa LIKE :telefono')
                                                              ->orderBy('e.telefono_empresa', 'ASC')
                                                              ->setParameter('direccion','%'.$direccion_empresa.'%')
                                                              ->setParameter('provincia','%'.$provincia_empresa.'%')
                                                              ->setParameter('telefono','%'.$telefono_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_empresa)) && empty($direccion_empresa) && !empty($localidad_empresa) && empty($provincia_empresa) && !empty($cp_empresa) && !empty($telefono_empresa)){
            //Buscar Empresa por localidad, código postal y teléfono
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.localidad_empresa LIKE :localidad')
                                                              ->andWhere('e.cp_empresa LIKE :cp')
                                                              ->andWhere('e.telefono_empresa LIKE :telefono')
                                                              ->orderBy('e.telefono_empresa', 'ASC')
                                                              ->setParameter('localidad','%'.$localidad_empresa.'%')
                                                              ->setParameter('cp','%'.$cp_empresa.'%')
                                                              ->setParameter('telefono','%'.$telefono_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_empresa)) && empty($direccion_empresa) && !empty($localidad_empresa) && !empty($provincia_empresa) && empty($cp_empresa) && !empty($telefono_empresa)){
            //Buscar Empresa por localidad, provincia y teléfono
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.localidad_empresa LIKE :localidad')
                                                              ->andWhere('e.provincia_empresa LIKE :provincia')
                                                              ->andWhere('e.telefono_empresa LIKE :telefono')
                                                              ->orderBy('e.localidad_empresa', 'ASC')
                                                              ->setParameter('localidad','%'.$localidad_empresa.'%')
                                                              ->setParameter('provincia','%'.$provincia_empresa.'%')
                                                              ->setParameter('telefono','%'.$telefono_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_empresa)) && empty($direccion_empresa) && !empty($localidad_empresa) && !empty($provincia_empresa) && !empty($cp_empresa) && empty($telefono_empresa)){
            //Buscar Empresa por localidad, provincia y código postal
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.localidad_empresa LIKE :localidad')
                                                              ->andWhere('e.provincia_empresa LIKE :provincia')
                                                              ->andWhere('e.cp_empresa LIKE :cp')
                                                              ->orderBy('e.localidad_empresa', 'ASC')
                                                              ->setParameter('localidad','%'.$localidad_empresa.'%')
                                                              ->setParameter('provincia','%'.$provincia_empresa.'%')
                                                              ->setParameter('cp','%'.$cp_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_empresa)) && !empty($direccion_empresa) && empty($localidad_empresa) && empty($provincia_empresa) && !empty($cp_empresa) && empty($telefono_empresa)){
            //Buscar Empresa por nombre, dirección y código postal
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.nombre_empresa LIKE :nombre')
                                                              ->andWhere('e.direccion_empresa LIKE :direccion')
                                                              ->andWhere('e.cp_empresa LIKE :cp')
                                                              ->orderBy('e.nombre_empresa', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_empresa.'%')
                                                              ->setParameter('direccion','%'.$direccion_empresa.'%')
                                                              ->setParameter('cp','%'.$cp_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_empresa)) && empty($direccion_empresa) && empty($localidad_empresa) && !empty($provincia_empresa) && empty($cp_empresa) && !empty($telefono_empresa)){
            //Buscar Empresa por nombre, provincia y teléfono
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.nombre_empresa LIKE :nombre')
                                                              ->andWhere('e.provincia_empresa LIKE :provincia')
                                                              ->andWhere('e.telefono_empresa LIKE :telefono')
                                                              ->orderBy('e.nombre_empresa', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_empresa.'%')
                                                              ->setParameter('provincia','%'.$provincia_empresa.'%')
                                                              ->setParameter('telefono','%'.$telefono_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_empresa)) && !empty($direccion_empresa) && empty($localidad_empresa) && !empty($provincia_empresa) && !empty($cp_empresa) && empty($telefono_empresa)){
            //Buscar Empresa por dirección, provincia y código postal
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.direccion_empresa LIKE :direccion')
                                                              ->andWhere('e.provincia_empresa LIKE :provincia')
                                                              ->andWhere('e.cp_empresa LIKE :cp')
                                                              ->orderBy('e.nombre_empresa', 'ASC')
                                                              ->setParameter('direccion','%'.$direccion_empresa.'%')
                                                              ->setParameter('provincia','%'.$provincia_empresa.'%')
                                                              ->setParameter('cp','%'.$cp_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_empresa)) && empty($direccion_empresa) && empty($localidad_empresa) && !empty($provincia_empresa) && !empty($cp_empresa) && empty($telefono_empresa)){
            //Buscar Empresa por nombre, provincia y código postal
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.nombre_empresa LIKE :nombre')
                                                              ->andWhere('e.provincia_empresa LIKE :provincia')
                                                              ->andWhere('e.cp_empresa LIKE :cp')
                                                              ->orderBy('e.nombre_empresa', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_empresa.'%')
                                                              ->setParameter('provincia','%'.$provincia_empresa.'%')
                                                              ->setParameter('cp','%'.$cp_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_empresa)) && !empty($direccion_empresa) && !empty($localidad_empresa) && empty($provincia_empresa) && !empty($cp_empresa) && empty($telefono_empresa)){
            //Buscar Empresa por dirección, localidad y código postal
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.direccion_empresa LIKE :direccion')
                                                              ->andWhere('e.localidad_empresa LIKE :localidad')
                                                              ->andWhere('e.cp_empresa LIKE :cp')
                                                              ->orderBy('e.localidad_empresa', 'ASC')
                                                              ->setParameter('direccion','%'.$direccion_empresa.'%')
                                                              ->setParameter('localidad','%'.$localidad_empresa.'%')
                                                              ->setParameter('cp','%'.$cp_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_empresa)) && !empty($direccion_empresa) && empty($localidad_empresa) && empty($provincia_empresa) && empty($cp_empresa) && empty($telefono_empresa)){
            //Buscar Empresa por nombre y dirección
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.nombre_empresa LIKE :nombre')
                                                              ->andWhere('e.direccion_empresa LIKE :direccion')
                                                              ->orderBy('e.nombre_empresa', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_empresa.'%')
                                                              ->setParameter('direccion','%'.$direccion_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_empresa)) && empty($direccion_empresa) && !empty($localidad_empresa) && empty($provincia_empresa) && empty($cp_empresa) && empty($telefono_empresa)){
            //Buscar Empresa por nombre y localidad
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.nombre_empresa LIKE :nombre')
                                                              ->andWhere('e.localidad_empresa LIKE :localidad')
                                                              ->orderBy('e.nombre_empresa', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_empresa.'%')
                                                              ->setParameter('localidad','%'.$localidad_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_empresa)) && empty($direccion_empresa) && empty($localidad_empresa) && !empty($provincia_empresa) && empty($cp_empresa) && empty($telefono_empresa)){
            //Buscar Empresa por nombre y provincia
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.nombre_empresa LIKE :nombre')
                                                              ->andWhere('e.provincia_empresa LIKE :provincia')
                                                              ->orderBy('e.nombre_empresa', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_empresa.'%')
                                                              ->setParameter('provincia','%'.$provincia_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_empresa)) && empty($direccion_empresa) && empty($localidad_empresa) && empty($provincia_empresa) && !empty($cp_empresa) && empty($telefono_empresa)){
            //Buscar Empresa por nombre y código postal
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.nombre_empresa LIKE :nombre')
                                                              ->andWhere('e.cp_empresa LIKE :cp')
                                                              ->orderBy('e.nombre_empresa', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_empresa.'%')
                                                              ->setParameter('cp','%'.$cp_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_empresa)) && empty($direccion_empresa) && empty($localidad_empresa) && empty($provincia_empresa) && empty($cp_empresa) && !empty($telefono_empresa)){
            //Buscar Empresa por nombre y teléfono
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.nombre_empresa LIKE :nombre')
                                                              ->andWhere('e.telefono_empresa LIKE :telefono')
                                                              ->orderBy('e.nombre_empresa', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_empresa.'%')
                                                              ->setParameter('telefono','%'.$telefono_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_empresa)) && !empty($direccion_empresa) && !empty($localidad_empresa) && empty($provincia_empresa) && empty($cp_empresa) && empty($telefono_empresa)){
            //Buscar Empresa por dirección y localidad
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.direccion_empresa LIKE :direccion')
                                                              ->andWhere('e.localidad_empresa LIKE :localidad')
                                                              ->orderBy('e.localidad_empresa', 'ASC')
                                                              ->setParameter('direccion','%'.$direccion_empresa.'%')
                                                              ->setParameter('localidad','%'.$localidad_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_empresa)) && !empty($direccion_empresa) && empty($localidad_empresa) && !empty($provincia_empresa) && empty($cp_empresa) && empty($telefono_empresa)){
            //Buscar Empresa por dirección y provincia
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.direccion_empresa LIKE :direccion')
                                                              ->andWhere('e.provincia_empresa LIKE :provincia')
                                                              ->orderBy('e.nombre_empresa', 'ASC')
                                                              ->setParameter('direccion','%'.$direccion_empresa.'%')
                                                              ->setParameter('provincia','%'.$provincia_empresa.'%')
                                                              ->getResult();
        }

        elseif((empty($nombre_empresa)) && !empty($direccion_empresa) && empty($localidad_empresa) && empty($provincia_empresa) && !empty($cp_empresa) && empty($telefono_empresa)){
            //Buscar Empresa por dirección y código postal
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.direccion_empresa LIKE :direccion')
                                                              ->andWhere('e.cp_empresa LIKE :cp')
                                                              ->orderBy('e.nombre_empresa', 'ASC')
                                                              ->setParameter('direccion','%'.$direccion_empresa.'%')
                                                              ->setParameter('cp','%'.$cp_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_empresa)) && !empty($direccion_empresa) && empty($localidad_empresa) && empty($provincia_empresa) && empty($cp_empresa) && !empty($telefono_empresa)){
            //Buscar Empresa por dirección y teléfono
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.direccion_empresa LIKE :direccion')
                                                              ->andWhere('e.telefono_empresa LIKE :telefono')
                                                              ->orderBy('e.telefono_empresa', 'ASC')
                                                              ->setParameter('direccion','%'.$direccion_empresa.'%')
                                                              ->setParameter('telefono','%'.$telefono_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_empresa)) && empty($direccion_empresa) && !empty($localidad_empresa) && !empty($provincia_empresa) && empty($cp_empresa) && empty($telefono_empresa)){
            //Buscar Empresa por localidad y provincia
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.localidad_empresa LIKE :localidad')
                                                              ->andWhere('e.provincia_empresa LIKE :provincia')
                                                              ->orderBy('e.localidad_empresa', 'ASC')
                                                              ->setParameter('localidad','%'.$localidad_empresa.'%')
                                                              ->setParameter('provincia','%'.$provincia_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_empresa)) && empty($direccion_empresa) && !empty($localidad_empresa) && empty($provincia_empresa) && !empty($cp_empresa) && empty($telefono_empresa)){
            //Buscar Empresa por localidad y código postal
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.localidad_empresa LIKE :localidad')
                                                              ->andWhere('e.cp_empresa LIKE :cp')
                                                              ->orderBy('e.localidad_empresa', 'ASC')
                                                              ->setParameter('localidad','%'.$localidad_empresa.'%')
                                                              ->setParameter('cp','%'.$cp_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_empresa)) && empty($direccion_empresa) && !empty($localidad_empresa) && empty($provincia_empresa) && empty($cp_empresa) && !empty($telefono_empresa)){
            //Buscar Empresa por localidad y teléfono
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.localidad_empresa LIKE :localidad')
                                                              ->andWhere('e.telefono_empresa LIKE :telefono')
                                                              ->orderBy('e.localidad_empresa', 'ASC')
                                                              ->setParameter('localidad','%'.$localidad_empresa.'%')
                                                              ->setParameter('telefono','%'.$telefono_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_empresa)) && empty($direccion_empresa) && empty($localidad_empresa) && !empty($provincia_empresa) && !empty($cp_empresa) && empty($telefono_empresa)){
            //Buscar Empresa por provincia y código postal
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.provincia_empresa LIKE :provincia')
                                                              ->andWhere('e.cp_empresa LIKE :cp')
                                                              ->orderBy('e.nombre_empresa', 'ASC')
                                                              ->setParameter('provincia','%'.$provincia_empresa.'%')
                                                              ->setParameter('cp','%'.$cp_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_empresa)) && empty($direccion_empresa) && empty($localidad_empresa) && !empty($provincia_empresa) && empty($cp_empresa) && !empty($telefono_empresa)){
            //Buscar Empresa por provincia y teléfono
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.provincia_empresa LIKE :provincia')
                                                              ->andWhere('e.telefono_empresa LIKE :telefono')
                                                              ->orderBy('e.telefono_empresa', 'ASC')
                                                              ->setParameter('provincia','%'.$provincia_empresa.'%')
                                                              ->setParameter('telefono','%'.$telefono_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_empresa)) && empty($direccion_empresa) && empty($localidad_empresa) && empty($provincia_empresa) && !empty($cp_empresa) && !empty($telefono_empresa)){
            //Buscar Empresa por código postal y teléfono
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.cp_empresa LIKE :cp')
                                                              ->andWhere('e.telefono_empresa LIKE :telefono')
                                                              ->orderBy('e.telefono_empresa', 'ASC')
                                                              ->setParameter('cp','%'.$cp_empresa.'%')
                                                              ->setParameter('telefono','%'.$telefono_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_empresa)) && empty($direccion_empresa) && empty($localidad_empresa) && empty($provincia_empresa) && empty($cp_empresa) && empty($telefono_empresa)){
            //Buscar Empresa por nombre
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.nombre_empresa LIKE :nombre')
                                                              ->orderBy('e.nombre_empresa', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_empresa)) && !empty($direccion_empresa) && empty($localidad_empresa) && empty($provincia_empresa) && empty($cp_empresa) && empty($telefono_empresa)){
            //Buscar Empresa por dirección
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.direccion_empresa LIKE :direccion')
                                                              ->orderBy('e.nombre_empresa', 'ASC')
                                                              ->setParameter('direccion','%'.$direccion_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_empresa)) && empty($direccion_empresa) && !empty($localidad_empresa) && empty($provincia_empresa) && empty($cp_empresa) && empty($telefono_empresa)){
            //Buscar Empresa por localidad
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.localidad_empresa LIKE :localidad')
                                                              ->orderBy('e.nombre_empresa', 'ASC')
                                                              ->setParameter('localidad','%'.$localidad_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_empresa)) && empty($direccion_empresa) && empty($localidad_empresa) && !empty($provincia_empresa) && empty($cp_empresa) && empty($telefono_empresa)){
            //Buscar Empresa por provincia
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.provincia_empresa LIKE :provincia')
                                                              ->orderBy('e.nombre_empresa', 'ASC')
                                                              ->setParameter('provincia','%'.$provincia_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_empresa)) && empty($direccion_empresa) && empty($localidad_empresa) && empty($provincia_empresa) && !empty($cp_empresa) && empty($telefono_empresa)){
            //Buscar Empresa por código postal
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.cp_empresa LIKE :cp')
                                                              ->orderBy('e.nombre_empresa', 'ASC')
                                                              ->setParameter('cp','%'.$cp_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_empresa)) && empty($direccion_empresa) && empty($localidad_empresa) && empty($provincia_empresa) && empty($cp_empresa) && !empty($telefono_empresa)){
            //Buscar Empresa por teléfono
            $empresasTemp = $em->getRepository(Empresa::class)->createQueryBuilder('e')
                                                              ->where('e.telefono_empresa LIKE :telefono')
                                                              ->orderBy('e.nombre_empresa', 'ASC')
                                                              ->setParameter('telefono','%'.$telefono_empresa.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        else {
            //Buscar todas las empresas
            $empresasTemp = $em->getRepository(Empresa::class)->findBy(array(), array('nombre_empresa' => 'ASC'));
        }

        $empresas = $empresasTemp;

        return $this->render('administrador/empresasEncontradas.html.twig', [
            'controller_name' => 'Esta es la página para buscar una Empresa',
            'empresas' => $empresas
        ]);
    }

    #[Route('/administrador/empresa/consultar/{id}', name: 'consultarEmpresaAdmin')]
    public function consultarEmpresa($id): Response
    {
        $em = $this->getDoctrine()->getManager();

        //Buscar la empresa a consultar
        $empresa = $em->getRepository(Empresa::class)->find($id);
        $empresario = $em->getRepository(Empresario::class)->findOneBy(array('id' => $empresa->getIdEmpresario()));
        $form = $this->createForm(ValidarEmpresaType::class, $empresa, ['empresario' => $empresario->getId(),]);

        return $this->render('administrador/consultarEmpresa.html.twig', [
            'controller_name' => 'Datos de la empresa',
            'formulario' => $form->createView(),
            'empresa'=> $empresa,
            'logotipo' => $empresa->getLogotipo()
        ]);
    }

    #[Route('/administrador/empresa/modificar/{id}', name: 'modificarEmpresaAdmin')]
    public function modificarEmpresa(Request $request, $id): Response
    {
        $empresa = new Empresa();
        $em = $this->getDoctrine()->getManager();

        //Buscar la empresa a modificar
        $empresa = $em->getRepository(Empresa::class)->find($id);
        $form = $this->createForm(EmpresaAdminType::class, $empresa);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $empresa->setValidez(validez: 'pendiente');

            //Obtener el campo del ID de usuario del formulario
            $empresario = $form->get('id_usuario')->getData();
            if ($empresario) {
                $empresa->setIdEmpresario($empresario);
            }

            //Se actualiza la empresa en la base de datos
            $em->persist($empresa);
            $em->flush();

            return $this->redirectToRoute(route: 'buscarEmpresaAdmin');
        }

        return $this->render('administrador/modificarEmpresa.html.twig', [
            'controller_name' => '',
            'formulario' => $form->createView(),
            'logotipo' => $empresa->getLogotipo()
        ]);
    }

    #[Route('/administrador/empresa/eliminar/{id}', name: 'eliminarEmpresaAdmin')]
    public function eliminarEmpresa(Request $request, $id): Response
    {
        $empresa = new Empresa();
        $em = $this->getDoctrine()->getManager();

        //Buscar la empresa a eliminar
        $empresa = $em->getRepository(Empresa::class)->find($id);
        $empresario = $em->getRepository(Empresario::class)->findOneBy(array('id' => $empresa->getIdEmpresario()));
        $form = $this->createForm(ValidarEmpresaType::class, $empresa, ['empresario' => $empresario->getId(),]);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            //Buscar los comercios de la empresa
            $comercios = $em->getRepository(Comercio::class)->findBy(array('id_empresa' => $id));

            //Buscar las ofertas de cada comercio
            $ofertas = array();
            for($i = 0; $i < sizeof($comercios); $i++) {
                $aux = $em->getRepository(Oferta::class)->findBy(array('id_comercio' => $comercios[$i]->getId()));
                if($aux !== null) {
                    for ($j = 0; $j < sizeof($aux); $j++) {
                        array_push($ofertas,$aux[$j]);
                    }
                }
            }

            //Eliminar las ofertas
            for($i = 0; $i < sizeof($ofertas); $i++) {
                $em->remove($ofertas[$i]);
                $em->flush();
            }

            //Eliminar los comercios
            for($i = 0; $i < sizeof($comercios); $i++) {
                $em->remove($comercios[$i]);
                $em->flush();
            }

            //Se elimina la empresa de la base de datos
            $em->remove($empresa);
            $em->flush();

            return $this->redirectToRoute(route: 'buscarEmpresaAdmin');
        }

        return $this->render('administrador/eliminarEmpresa.html.twig', [
            'controller_name' => '',
            'formulario' => $form->createView(),
            'logotipo' => $empresa->getLogotipo()
        ]);
    }

    #[Route('/administrador/empresa/validar/{id}', name: 'validarEmpresa')]
    public function validarEmpresa(Request $request, $id): Response
    {
        $empresa = new Empresa();
        $em = $this->getDoctrine()->getManager();

        //Buscar la empresa a validar
        $empresa = $em->getRepository(Empresa::class)->find($id);
        $empresario = $em->getRepository(Empresario::class)->findOneBy(array('id' => $empresa->getIdEmpresario()));
        $form = $this->createForm(ValidarEmpresaType::class, $empresa, ['empresario' => $empresario->getId(),]);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $empresa->setValidez(validez: 'sí');

            //Se actualiza la empresa en la base de datos
            $em->persist($empresa);
            $em->flush();

            return $this->redirectToRoute(route: 'buscarEmpresaAdmin');
        }

        return $this->render('administrador/validarEmpresa.html.twig', [
            'controller_name' => '',
            'formulario' => $form->createView(),
            'logotipo' => $empresa->getLogotipo()
        ]);
    }

    #[Route('/administrador/empresa/rechazar/{id}', name: 'rechazarEmpresa')]
    public function rechazarEmpresa(Request $request, $id): Response
    {
        $empresa = new Empresa();
        $em = $this->getDoctrine()->getManager();

        //Buscar la empresa a validar
        $empresa = $em->getRepository(Empresa::class)->find($id);
        $empresario = $em->getRepository(Empresario::class)->findOneBy(array('id' => $empresa->getIdEmpresario()));
        $form = $this->createForm(ValidarEmpresaType::class, $empresa, ['empresario' => $empresario->getId(),]);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $empresa->setValidez(validez: 'no');

            //Se actualiza la empresa en la base de datos
            $em->persist($empresa);
            $em->flush();

            return $this->redirectToRoute(route: 'buscarEmpresaAdmin');
        }

        return $this->render('administrador/rechazarEmpresa.html.twig', [
            'controller_name' => '',
            'formulario' => $form->createView(),
            'logotipo' => $empresa->getLogotipo()
        ]);
    }

    #[Route('/administrador/empresa/registrar', name: 'registrarEmpresaAdmin')]
    public function registrarEmpresa(Request $request): Response
    {
        $empresa = new Empresa();
        $empresario = new Empresario();

        $form = $this->createForm(EmpresaAdminType::class, $empresa);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            /** @var UploadedFile $logotipo */
            $logotipo = $form->get('logotipo')->getData();

            //La imagen es un atributo opcional. Si se ha subido un archivo al formulario, se procesa
            if ($logotipo) {
                $originalFilename = pathinfo($logotipo->getClientOriginalName(), PATHINFO_FILENAME);

                //Se necesita para incluir el nombre del archivo como parte de la ruta de manera segura
                $slugger = new AsciiSlugger();
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$logotipo->guessExtension();

                //Obtener la ruta para guardar en la base de datos
                $newFilenameRoute = '\uploads\images\\'.$newFilename;

                //Mover el archivo a la carpeta donde se almacenan las imágenes
                try {
                    $logotipo->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    throw new \Exception('Ha ocurrido un error');
                }

                //Se actualiza el atributo de la imagen para almacenar la ruta en la que se guarda la imagen, en lugar de guardar la imagen en la base de datos
                $empresa->setLogotipo($newFilenameRoute);
            }

            $em = $this->getDoctrine()->getManager();
            $empresa->setValidez(validez: 'pendiente');

            //Obtener el campo del ID de usuario del formulario
            $empresario = $form->get('id_usuario')->getData();
            if ($empresario) {
                $empresa->setIdEmpresario($empresario);
            }

            //Se guarda la empresa en la base de datos
            $em->persist($empresa);
            $em->flush();
            $this->addFlash(type: 'exito', message: 'La empresa se ha registrado correctamente');
            return $this->redirectToRoute(route: 'administrador');
        }

        return $this->render('administrador/registrarEmpresa.html.twig', [
            'controller_name' => '',
            'formulario' => $form->createView()
        ]);
    }

    #[Route('/administrador/comercio/buscar', name: 'buscarComercioAdmin')]
    public function buscarComercio(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $comercios = "";
        $comerciosTemp = "";

        //Parámetros de búsqueda
        $nombre_comercio = $request->request->get('nombre_comercio');
        $direccion_comercio = $request->request->get('direccion_comercio');
        $codigo_postal = $request->request->get('codigo_postal');
        $telefono_comercio = $request->request->get('telefono_comercio');

        //Búsquedas según los parámetros introducidos
        if(!(empty($nombre_comercio)) && !empty($direccion_comercio) && !empty($codigo_postal) && !empty($telefono_comercio)){
            //Buscar Comercio por nombre, dirección, código postal y teléfono
            $comerciosTemp = $em->getRepository(Comercio::class)->createQueryBuilder('c')
                                                              ->where('c.nombre_comercio LIKE :nombre')
                                                              ->andWhere('c.direccion_comercio LIKE :direccion')
                                                              ->andWhere('c.codigo_postal LIKE :codigo_postal')
                                                              ->andWhere('c.telefono_empresa LIKE :telefono')
                                                              ->orderBy('c.nombre_comercio', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_comercio.'%')
                                                              ->setParameter('direccion','%'.$direccion_comercio.'%')
                                                              ->setParameter('cp','%'.$codigo_postal.'%')
                                                              ->setParameter('telefono','%'.$telefono_comercio.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_comercio)) && !empty($direccion_comercio) && !empty($codigo_postal) && empty($telefono_comercio)){
            //Buscar Comercio por nombre, dirección y código postal
            $comerciosTemp = $em->getRepository(Comercio::class)->createQueryBuilder('c')
                                                              ->where('c.nombre_comercio LIKE :nombre')
                                                              ->andWhere('c.direccion_comercio LIKE :direccion')
                                                              ->andWhere('c.codigo_postal LIKE :codigo_postal')
                                                              ->orderBy('c.nombre_comercio', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_comercio.'%')
                                                              ->setParameter('direccion','%'.$direccion_comercio.'%')
                                                              ->setParameter('cp','%'.$codigo_postal.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_comercio)) && !empty($direccion_comercio) && empty($codigo_postal) && !empty($telefono_comercio)){
            //Buscar Comercio por nombre, dirección y teléfono
            $comerciosTemp = $em->getRepository(Comercio::class)->createQueryBuilder('c')
                                                              ->where('c.nombre_comercio LIKE :nombre')
                                                              ->andWhere('c.direccion_comercio LIKE :direccion')
                                                              ->andWhere('c.telefono_empresa LIKE :telefono')
                                                              ->orderBy('c.nombre_comercio', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_comercio.'%')
                                                              ->setParameter('direccion','%'.$direccion_comercio.'%')
                                                              ->setParameter('telefono','%'.$telefono_comercio.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_comercio)) && empty($direccion_comercio) && !empty($codigo_postal) && !empty($telefono_comercio)){
            //Buscar Comercio por nombre, código postal y teléfono
            $comerciosTemp = $em->getRepository(Comercio::class)->createQueryBuilder('c')
                                                              ->where('c.nombre_comercio LIKE :nombre')
                                                              ->andWhere('c.codigo_postal LIKE :codigo_postal')
                                                              ->andWhere('c.telefono_empresa LIKE :telefono')
                                                              ->orderBy('c.nombre_comercio', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_comercio.'%')
                                                              ->setParameter('cp','%'.$codigo_postal.'%')
                                                              ->setParameter('telefono','%'.$telefono_comercio.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_comercio)) && !empty($direccion_comercio) && !empty($codigo_postal) && !empty($telefono_comercio)){
            //Buscar Comercio por dirección, código postal y teléfono
            $comerciosTemp = $em->getRepository(Comercio::class)->createQueryBuilder('c')
                                                              ->where('c.direccion_comercio LIKE :direccion')
                                                              ->andWhere('c.codigo_postal LIKE :codigo_postal')
                                                              ->andWhere('c.telefono_empresa LIKE :telefono')
                                                              ->orderBy('c.nombre_comercio', 'ASC')
                                                              ->setParameter('direccion','%'.$direccion_comercio.'%')
                                                              ->setParameter('cp','%'.$codigo_postal.'%')
                                                              ->setParameter('telefono','%'.$telefono_comercio.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_comercio)) && !empty($direccion_comercio) && empty($codigo_postal) && empty($telefono_comercio)){
            //Buscar Comercio por nombre y dirección
            $comerciosTemp = $em->getRepository(Comercio::class)->createQueryBuilder('c')
                                                              ->where('c.nombre_comercio LIKE :nombre')
                                                              ->andWhere('c.direccion_comercio LIKE :direccion')
                                                              ->orderBy('c.nombre_comercio', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_comercio.'%')
                                                              ->setParameter('direccion','%'.$direccion_comercio.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_comercio)) && empty($direccion_comercio) && !empty($codigo_postal) && empty($telefono_comercio)){
            //Buscar Comercio por nombre y código postal
            $comerciosTemp = $em->getRepository(Comercio::class)->createQueryBuilder('c')
                                                              ->where('c.nombre_comercio LIKE :nombre')
                                                              ->andWhere('c.codigo_postal LIKE :codigo_postal')
                                                              ->orderBy('c.nombre_comercio', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_comercio.'%')
                                                              ->setParameter('cp','%'.$codigo_postal.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_comercio)) && !empty($direccion_comercio) && !empty($codigo_postal) && empty($telefono_comercio)){
            //Buscar Comercio por dirección y código postal
            $comerciosTemp = $em->getRepository(Comercio::class)->createQueryBuilder('c')
                                                              ->andWhere('c.direccion_comercio LIKE :direccion')
                                                              ->andWhere('c.codigo_postal LIKE :codigo_postal')
                                                              ->andWhere('c.telefono_empresa LIKE :telefono')
                                                              ->orderBy('c.nombre_comercio', 'ASC')
                                                              ->setParameter('direccion','%'.$direccion_comercio.'%')
                                                              ->setParameter('cp','%'.$codigo_postal.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_comercio)) && empty($direccion_comercio) && empty($codigo_postal) && !empty($telefono_comercio)){
            //Buscar Comercio por nombre y teléfono
            $comerciosTemp = $em->getRepository(Comercio::class)->createQueryBuilder('c')
                                                              ->where('c.nombre_comercio LIKE :nombre')
                                                              ->andWhere('c.telefono_empresa LIKE :telefono')
                                                              ->orderBy('c.nombre_comercio', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_comercio.'%')
                                                              ->setParameter('telefono','%'.$telefono_comercio.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_comercio)) && !empty($direccion_comercio) && empty($codigo_postal) && !empty($telefono_comercio)){
            //Buscar Comercio por dirección y teléfono
            $comerciosTemp = $em->getRepository(Comercio::class)->createQueryBuilder('c')
                                                              ->andWhere('c.direccion_comercio LIKE :direccion')
                                                              ->andWhere('c.telefono_empresa LIKE :telefono')
                                                              ->orderBy('c.nombre_comercio', 'ASC')
                                                              ->setParameter('direccion','%'.$direccion_comercio.'%')
                                                              ->setParameter('telefono','%'.$telefono_comercio.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_comercio)) && empty($direccion_comercio) && !empty($codigo_postal) && !empty($telefono_comercio)){
            //Buscar Comercio por código postal y teléfono
            $comerciosTemp = $em->getRepository(Comercio::class)->createQueryBuilder('c')
                                                              ->andWhere('c.codigo_postal LIKE :codigo_postal')
                                                              ->andWhere('c.telefono_empresa LIKE :telefono')
                                                              ->orderBy('c.nombre_comercio', 'ASC')
                                                              ->setParameter('cp','%'.$codigo_postal.'%')
                                                              ->setParameter('telefono','%'.$telefono_comercio.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_comercio)) && empty($direccion_comercio) && empty($codigo_postal) && empty($telefono_comercio)){
            //Buscar Comercio por nombre
            $comerciosTemp = $em->getRepository(Comercio::class)->createQueryBuilder('c')
                                                              ->where('c.nombre_comercio LIKE :nombre')
                                                              ->orderBy('c.nombre_comercio', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_comercio.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_comercio)) && !empty($direccion_comercio) && empty($codigo_postal) && empty($telefono_comercio)){
            //Buscar Comercio por dirección
            $comerciosTemp = $em->getRepository(Comercio::class)->createQueryBuilder('c')
                                                              ->andWhere('c.direccion_comercio LIKE :direccion')
                                                              ->orderBy('c.nombre_comercio', 'ASC')
                                                              ->setParameter('direccion','%'.$direccion_comercio.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_comercio)) && empty($direccion_comercio) && !empty($codigo_postal) && empty($telefono_comercio)){
            //Buscar Comercio por código postal
            $comerciosTemp = $em->getRepository(Comercio::class)->createQueryBuilder('c')
                                                              ->andWhere('c.codigo_postal LIKE :codigo_postal')
                                                              ->orderBy('c.nombre_comercio', 'ASC')
                                                              ->setParameter('cp','%'.$codigo_postal.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_comercio)) && empty($direccion_comercio) && empty($codigo_postal) && !empty($telefono_comercio)){
            //Buscar Comercio por teléfono
            $comerciosTemp = $em->getRepository(Comercio::class)->createQueryBuilder('c')
                                                              ->andWhere('c.telefono_empresa LIKE :telefono')
                                                              ->orderBy('c.nombre_comercio', 'ASC')
                                                              ->setParameter('telefono','%'.$telefono_comercio.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        else {
            //Buscar todos los comercios
            $comerciosTemp = $em->getRepository(Comercio::class)->findBy(array(), array('nombre_comercio' => 'ASC'));
        }

        $comercios = $comerciosTemp;

        return $this->render('administrador/comerciosEncontrados.html.twig', [
            'controller_name' => 'Esta es la página para buscar un Comercio',
            'comercios' => $comercios
        ]);
    }

    #[Route('/administrador/empresa/comercio/buscar/{id}', name: 'buscarComercioEmpresaAdmin')]
    public function buscarComercioEmpresa(Request $request, $id): Response
    {
        $em = $this->getDoctrine()->getManager();

        //Buscar todos los comercios de la empresa
        $comercios = $em->getRepository(Comercio::class)->findBy(array('id_empresa' => $id), array('nombre_comercio' => 'ASC'));

        return $this->render('administrador/buscarComercioEmpresa.html.twig', [
            'controller_name' => 'Comercios de la empresa',
            'comercios' => $comercios
        ]);
    }

    #[Route('/administrador/comercio/consultar/{id}', name: 'consultarComercioAdmin')]
    public function consultarComercio($id): Response
    {
        $em = $this->getDoctrine()->getManager();

        //Buscar el comercio a consultar
        $comercio = $em->getRepository(Comercio::class)->find($id);
        $form = $this->createForm(ComercioConsultaType::class, $comercio);

        return $this->render('administrador/consultarComercio.html.twig', [
            'controller_name' => 'Datos del comercio',
            'formulario' => $form->createView(),
            'comercio' => $comercio
        ]);
    }

    #[Route('/administrador/comercio/modificar/{id}', name: 'modificarComercioAdmin')]
    public function modificarComercio(Request $request, $id): Response
    {
        $comercio = new Comercio();
        $em = $this->getDoctrine()->getManager();

        //Buscar el comercio a modificar
        $comercio = $em->getRepository(Comercio::class)->find($id);
        $form = $this->createForm(ModificarComercioType::class, $comercio);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $comercio->setValidez(validez: 'pendiente');

            //Se actualiza el comercio en la base de datos
            $em->persist($comercio);
            $em->flush();

            return $this->redirectToRoute(route: 'buscarComercioAdmin');
        }

        return $this->render('administrador/modificarComercio.html.twig', [
            'controller_name' => '',
            'formulario' => $form->createView()
        ]);
    }

    #[Route('/administrador/comercio/eliminar/{id}', name: 'eliminarComercioAdmin')]
    public function eliminarComercio(Request $request, $id): Response
    {
        $comercio = new Comercio();
        $em = $this->getDoctrine()->getManager();

        //Buscar el comercio a eliminar
        $comercio = $em->getRepository(Comercio::class)->find($id);
        $form = $this->createForm(ValidarComercioType::class, $comercio);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            //Buscar las ofertas del comercio
            $ofertas = $em->getRepository(Oferta::class)->findBy(array('id_comercio' => $id));

            //Eliminar las ofertas
            for($i = 0; $i < sizeof($ofertas); $i++) {
                $em->remove($ofertas[$i]);
                $em->flush();
            }

            //Se elimina el comercio de la base de datos
            $em->remove($comercio);
            $em->flush();

            return $this->redirectToRoute(route: 'buscarComercioAdmin');
        }

        return $this->render('administrador/eliminarComercio.html.twig', [
            'controller_name' => '',
            'formulario' => $form->createView()
        ]);
    }

    #[Route('/administrador/comercio/validar/{id}', name: 'validarComercio')]
    public function validarComercio(Request $request, $id): Response
    {
        $comercio = new Comercio();
        $em = $this->getDoctrine()->getManager();

        //Buscar el comercio a validar
        $comercio = $em->getRepository(Comercio::class)->find($id);
        $form = $this->createForm(ValidarComercioType::class, $comercio);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $comercio->setValidez(validez: 'sí');

            //Se actualiza el comercio en la base de datos
            $em->persist($comercio);
            $em->flush();

            return $this->redirectToRoute(route: 'buscarComercioAdmin');
        }

        return $this->render('administrador/validarComercio.html.twig', [
            'controller_name' => '',
            'formulario' => $form->createView()
        ]);
    }

    #[Route('/administrador/comercio/rechazar/{id}', name: 'rechazarComercio')]
    public function rechazarComercio(Request $request, $id): Response
    {
        $comercio = new Comercio();
        $em = $this->getDoctrine()->getManager();

        //Buscar el comercio a validar
        $comercio = $em->getRepository(Comercio::class)->find($id);
        $form = $this->createForm(ValidarComercioType::class, $comercio);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $comercio->setValidez(validez: 'no');

            //Se actualiza el comercio en la base de datos
            $em->persist($comercio);
            $em->flush();

            return $this->redirectToRoute(route: 'buscarComercioAdmin');
        }

        return $this->render('administrador/rechazarComercio.html.twig', [
            'controller_name' => '',
            'formulario' => $form->createView(),
        ]);
    }

    #[Route('/administrador/comercio/registrar', name: 'registrarComercioAdmin')]
    public function registrarComercio(Request $request): Response
    {
        $comercio = new Comercio();
        $empresa = new Empresa();
        $form = $this->createForm(ComercioAdminType::class, $comercio);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $empresa = $em->getRepository(Empresa::class)->findOneBy(array('id' => $comercio->getIdEmpresa()));
            $comercio->setValidez(validez: 'pendiente');
            $comercio->setCif($empresa->getCif());

            //Se guarda el comercio en la base de datos
            $em->persist($comercio);
            $em->flush();
            $this->addFlash(type: 'exito', message: 'El comercio se ha registrado correctamente');
            return $this->redirectToRoute(route: 'administrador');
        }

        return $this->render('administrador/registrarComercio.html.twig', [
            'controller_name' => '',
            'formulario' => $form->createView()
        ]);
    }

    #[Route('/administrador/oferta/buscar', name: 'buscarOfertaAdmin')]
    public function buscarOferta(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $ofertas = "";
        $ofertasTemp = "";

        //Parámetros de búsqueda
        $fecha_inicio = $request->request->get('fecha_inicio');
        $fecha_fin = $request->request->get('fecha_fin');
        $descripcion = $request->request->get('descripcion');

        //Búsquedas según los parámetros introducidos
        if(!(empty($fecha_inicio)) && !empty($fecha_fin) && !empty($descripcion)){
            //Buscar Oferta por fecha inicio, fecha fin y descripcion
            $ofertasTemp = $em->getRepository(Oferta::class)->createQueryBuilder('o')
                                                              ->where('o.fecha_inicio LIKE :fInicio')
                                                              ->andWhere('o.fecha_fin LIKE :fFin')
                                                              ->andWhere('o.descripcion LIKE :descripcion')
                                                              ->orderBy('o.fecha_inicio', 'ASC')
                                                              ->setParameter('fInicio','%'.$fecha_inicio.'%')
                                                              ->setParameter('fFin','%'.$fecha_fin.'%')
                                                              ->setParameter('descripcion','%'.$descripcion.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($fecha_inicio)) && !empty($fecha_fin) && empty($descripcion)){
            //Buscar Oferta por fecha inicio y fecha fin
            $ofertasTemp = $em->getRepository(Oferta::class)->createQueryBuilder('o')
                                                              ->where('o.fecha_inicio LIKE :fInicio')
                                                              ->andWhere('o.fecha_fin LIKE :fFin')
                                                              ->orderBy('o.fecha_inicio', 'ASC')
                                                              ->setParameter('fInicio','%'.$fecha_inicio.'%')
                                                              ->setParameter('fFin','%'.$fecha_fin.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($fecha_inicio)) && empty($fecha_fin) && !empty($descripcion)){
            //Buscar Oferta por fecha inicio y descripcion
            $ofertasTemp = $em->getRepository(Oferta::class)->createQueryBuilder('o')
                                                              ->where('o.fecha_inicio LIKE :fInicio')
                                                              ->andWhere('o.descripcion LIKE :descripcion')
                                                              ->orderBy('o.fecha_inicio', 'ASC')
                                                              ->setParameter('fInicio','%'.$fecha_inicio.'%')
                                                              ->setParameter('descripcion','%'.$descripcion.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($fecha_inicio)) && !empty($fecha_fin) && !empty($descripcion)){
            //Buscar Oferta por fecha fin y descripcion
            $ofertasTemp = $em->getRepository(Oferta::class)->createQueryBuilder('o')
                                                              ->andWhere('o.fecha_fin LIKE :fFin')
                                                              ->andWhere('o.descripcion LIKE :descripcion')
                                                              ->orderBy('o.fecha_inicio', 'ASC')
                                                              ->setParameter('fFin','%'.$fecha_fin.'%')
                                                              ->setParameter('descripcion','%'.$descripcion.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($fecha_inicio)) && empty($fecha_fin) && empty($descripcion)){
            //Buscar Oferta por fecha inicio
            $ofertasTemp = $em->getRepository(Oferta::class)->createQueryBuilder('o')
                                                              ->where('o.fecha_inicio LIKE :fInicio')
                                                              ->orderBy('o.fecha_inicio', 'ASC')
                                                              ->setParameter('fInicio','%'.$fecha_inicio.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($fecha_inicio)) && !empty($fecha_fin) && empty($descripcion)){
            //Buscar Oferta por fecha fin
            $ofertasTemp = $em->getRepository(Oferta::class)->createQueryBuilder('o')
                                                              ->andWhere('o.fecha_fin LIKE :fFin')
                                                              ->andWhere('o.descripcion LIKE :descripcion')
                                                              ->orderBy('o.fecha_inicio', 'ASC')
                                                              ->setParameter('fFin','%'.$fecha_fin.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($fecha_inicio)) && empty($fecha_fin) && !empty($descripcion)){
            //Buscar Oferta por descripcion
            $ofertasTemp = $em->getRepository(Oferta::class)->createQueryBuilder('o')
                                                              ->andWhere('o.descripcion LIKE :descripcion')
                                                              ->orderBy('o.fecha_inicio', 'ASC')
                                                              ->setParameter('descripcion','%'.$descripcion.'%')
                                                              ->getQuery()
                                                              ->getResult();
        }

        else {
            //Buscar todas las ofertas
            $ofertasTemp = $em->getRepository(Oferta::class)->findBy(array(), array('fecha_inicio' => 'ASC'));
        }

        $ofertas = $ofertasTemp;

        return $this->render('administrador/ofertasEncontradas.html.twig', [
            'controller_name' => 'Esta es la página para buscar una Oferta',
            'ofertas' => $ofertas
        ]);
    }

    #[Route('administrador/comercio/oferta/buscar/{id}', name: 'buscarOfertaComercioAdmin')]
    public function buscarOfertaComercio(Request $request, $id): Response
    {
        $em = $this->getDoctrine()->getManager();

        $ofertas = "";

        //Buscar todas las ofertas del comercio seleccionado
        $ofertas = $em->getRepository(Oferta::class)->findBy(array('id_comercio' => $id));

        return $this->render('administrador/buscarOfertaComercio.html.twig', [
            'controller_name' => 'Ofertas del comercio',
            'ofertas' => $ofertas,
            'id' => $id
        ]);
    }

    #[Route('/administrador/oferta/consultar/{id}', name: 'consultarOfertaAdmin')]
    public function consultarOferta($id): Response
    {
        $em = $this->getDoctrine()->getManager();

        //Buscar la oferta a consultar
        $oferta = $em->getRepository(Oferta::class)->find($id);

        $form = $this->createForm(OfertaConsultaType::class, $oferta);

        return $this->render('administrador/consultarOferta.html.twig', [
            'controller_name' => 'Datos de la oferta',
            'formulario' => $form->createView(),
            'img_oferta' => $oferta->getImgOferta()
        ]);
    }

    #[Route('administrador/comercio/oferta/consultar/{id}', name: 'consultarOfertaComercioAdmin')]
    public function consultarOfertaComercio($id): Response
    {
        $em = $this->getDoctrine()->getManager();

        //Buscar la oferta a consultar
        $oferta = $em->getRepository(Oferta::class)->find($id);

        $form = $this->createForm(OfertaConsultaType::class, $oferta);

        return $this->render('administrador/consultarOfertaComercio.html.twig', [
            'controller_name' => 'Datos de la oferta',
            'formulario' => $form->createView(),
            'oferta' => $oferta,
            'img_oferta' => $oferta->getImgOferta()
        ]);
    }

    #[Route('/administrador/oferta/modificar/{id}', name: 'modificarOfertaAdmin')]
    public function modificarOferta(Request $request, $id): Response
    {
        $oferta = new Oferta();
        $em = $this->getDoctrine()->getManager();

        //Buscar la oferta a modificar
        $oferta = $em->getRepository(Oferta::class)->find($id);
        $form = $this->createForm(ModificarOfertaType::class, $oferta);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $oferta->setValidez(validez: 'pendiente');

            //Se actualiza la oferta en la base de datos
            $em->persist($oferta);
            $em->flush();

            return $this->redirectToRoute(route: 'buscarOfertaAdmin');
        }

        return $this->render('administrador/modificarOferta.html.twig', [
            'controller_name' => '',
            'formulario' => $form->createView(),
            'img_oferta' => $oferta->getImgOferta()
        ]);
    }

    #[Route('/administrador/oferta/eliminar/{id}', name: 'eliminarOfertaAdmin')]
    public function eliminarOferta(Request $request, $id): Response
    {
        $oferta = new Oferta();
        $em = $this->getDoctrine()->getManager();

        //Buscar la oferta a eliminar
        $oferta = $em->getRepository(Oferta::class)->find($id);
        $form = $this->createForm(ValidarOfertaType::class, $oferta);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            //Se elimina la oferta de la base de datos
            $em->remove($oferta);
            $em->flush();

            return $this->redirectToRoute(route: 'buscarOfertaAdmin');
        }

        return $this->render('administrador/eliminarOferta.html.twig', [
            'controller_name' => '',
            'formulario' => $form->createView(),
            'img_oferta' => $oferta->getImgOferta()
        ]);
    }

    #[Route('/administrador/oferta/validar/{id}', name: 'validarOferta')]
    public function validarOferta(Request $request, $id): Response
    {
        $oferta = new Oferta();
        $em = $this->getDoctrine()->getManager();

        //Buscar la oferta a validar
        $oferta = $em->getRepository(Oferta::class)->find($id);
        $form = $this->createForm(ValidarOfertaType::class, $oferta);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $oferta->setValidez(validez: 'sí');

            //Se actualiza la oferta en la base de datos
            $em->persist($oferta);
            $em->flush();

            return $this->redirectToRoute(route: 'buscarOfertaAdmin');
        }

        return $this->render('administrador/validarOferta.html.twig', [
            'controller_name' => '',
            'formulario' => $form->createView(),
            'img_oferta' => $oferta->getImgOferta()
        ]);
    }

    #[Route('/administrador/oferta/rechazar/{id}', name: 'rechazarOferta')]
    public function rechazarOferta(Request $request, $id): Response
    {
        $oferta = new Oferta();
        $em = $this->getDoctrine()->getManager();

        //Buscar la oferta a validar
        $oferta = $em->getRepository(Oferta::class)->find($id);
        $form = $this->createForm(ValidarOfertaType::class, $oferta);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $oferta->setValidez(validez: 'no');

            //Se actualiza la oferta en la base de datos
            $em->persist($oferta);
            $em->flush();

            return $this->redirectToRoute(route: 'buscarOfertaAdmin');
        }

        return $this->render('administrador/rechazarOferta.html.twig', [
            'controller_name' => '',
            'formulario' => $form->createView(),
            'img_oferta' => $oferta->getImgOferta()
        ]);
    }

    #[Route('/administrador/oferta/registrar', name: 'registrarOfertaAdmin')]
    public function registrarOferta(Request $request): Response
    {
        $oferta = new Oferta();
        $form = $this->createForm(OfertaAdminType::class, $oferta);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            
            /** @var UploadedFile $img_oferta */
            $img_oferta = $form->get('img_oferta')->getData();

            //La imagen es un atributo opcional. Si se ha subido un archivo al formulario, se procesa
            if ($img_oferta) {
                $originalFilename = pathinfo($img_oferta->getClientOriginalName(), PATHINFO_FILENAME);

                //Se necesita para incluir el nombre del archivo como parte de la ruta de manera segura
                $slugger = new AsciiSlugger();
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$img_oferta->guessExtension();

                //Obtener la ruta para guardar en la base de datos
                $newFilenameRoute = '\uploads\images\\'.$newFilename;

                //Mover el archivo a la carpeta donde se almacenan las imágenes
                try {
                    $img_oferta->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    throw new \Exception('Ha ocurrido un error');
                }

                //Se actualiza el atributo de la imagen para almacenar la ruta en la que se guarda la imagen, en lugar de guardar la imagen en la base de datos
                $oferta->setImgOferta($newFilenameRoute);
            }

            $em = $this->getDoctrine()->getManager();
            $oferta->setValidez(validez: 'pendiente');
            $em->persist($oferta);
            $em->flush();
            $this->addFlash(type: 'exito', message: 'La oferta se ha registrado correctamente');
            return $this->redirectToRoute(route: 'administrador');
        }

        return $this->render('administrador/registrarOferta.html.twig', [
            'controller_name' => '',
            'formulario' => $form->createView()
        ]);
    }

    #[Route('/administrador/perfil', name: 'verPerfilAdmin')]
    public function verPerfil(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $usuario = $em->getRepository(Usuario::class)->find($this->getUser()->getId());

        $form = $this->createForm(PerfilType::class, $usuario);

        return $this->render('administrador/verPerfil.html.twig', [
            'controller_name' => 'Perfil del usuario',
            'formulario' => $form->createView()
        ]);
    }

    #[Route('/administrador/perfil/editar', name: 'editarPerfilAdmin')]
    public function editarPerfil(Request $request): Response
    {
        $usuario = new Usuario();
        $em = $this->getDoctrine()->getManager();

        //Obtener los datos del usuario
        $usuario = $em->getRepository(Usuario::class)->find($this->getUser()->getId());
        $form = $this->createForm(ModificarUsuarioType::class, $usuario);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $usuario->setValidez(validez: 'pendiente');

            //Se actualiza el usuario en la base de datos
            $em->persist($usuario);
            $em->flush();

            return $this->redirectToRoute(route: 'administrador');
        }

        return $this->render('administrador/editarPerfil.html.twig', [
            'controller_name' => '',
            'formulario' => $form->createView()
        ]);
    }

    #[Route('/administrador/perfil/borrar', name: 'borrarPerfilAdmin')]
    public function borrarPerfil(Request $request): Response
    {
        $usuario = new Usuario();
        $em = $this->getDoctrine()->getManager();

        //Obtener los datos del usuario
        $usuario = $em->getRepository(Usuario::class)->find($this->getUser()->getId());
        $form = $this->createForm(ValidarUsuarioType::class, $usuario);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            //Se cambia la validez del usuario a eliminado, puesto que no se puede eliminar la información y cerrar la sesión de un usuario que no existe
            $usuario->setValidez(validez: 'eliminado');

            $em->persist($usuario);
            $em->flush();

            //Se cierra la sesión
            return $this->redirectToRoute(route: 'app_logout');
        }

        return $this->render('administrador/borrarPerfil.html.twig', [
            'controller_name' => 'Esta es la página para borrar el perfil. CUIDADO',
            'formulario' => $form->createView()
        ]);
    }
}
