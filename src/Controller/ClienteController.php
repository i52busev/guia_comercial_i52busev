<?php

namespace App\Controller;

use App\Entity\Oferta;
use App\Entity\Cliente;
use App\Entity\Usuario;
use App\Entity\Comercio;
use App\Form\PerfilType;
use App\Form\ComercioType;
use App\Entity\ClienteComercio;
use App\Form\OfertaConsultaType;
use App\Form\ValidarUsuarioType;
use App\Form\ModificarUsuarioType;
use App\Form\ComercioConsultaPublicoType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClienteController extends AbstractController
{
    #[Route('/cliente', name: 'cliente')]
    public function index(): Response
    {
        return $this->render('cliente/index.html.twig', [
            'controller_name' => 'Esta es la página principal de un Cliente',
        ]);
    }

    #[Route('/cliente/comercioBuscar', name: 'comercioBuscarCli')]
    public function comercioBuscar(Request $request): Response
    {
        $comercios = "";

        return $this->render('cliente/buscarComercio.html.twig', [
            'controller_name' => 'Esta es la página para buscar un Comercio',
            'comercios' => $comercios
        ]);
    }

    #[Route('/ayuda_cliente', name: 'ayudaCliente')]
    public function ayudaUsuarioCliente(): Response
    {
        return $this->render('cliente/ayuda.html.twig', [
            'controller_name' => 'Esta es la página de ayuda para el Usuario Cliente',
        ]);
    }

    #[Route('/cliente/comercio/buscar', name: 'buscarComercioCli')]
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
                                                              ->andWhere('c.validez LIKE :validez')
                                                              ->orderBy('c.nombre_comercio', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_comercio.'%')
                                                              ->setParameter('direccion','%'.$direccion_comercio.'%')
                                                              ->setParameter('cp','%'.$codigo_postal.'%')
                                                              ->setParameter('telefono','%'.$telefono_comercio.'%')
                                                              ->setParameter('validez','sí')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_comercio)) && !empty($direccion_comercio) && !empty($codigo_postal) && empty($telefono_comercio)){
            //Buscar Comercio por nombre, dirección y código postal
            $comerciosTemp = $em->getRepository(Comercio::class)->createQueryBuilder('c')
                                                              ->where('c.nombre_comercio LIKE :nombre')
                                                              ->andWhere('c.direccion_comercio LIKE :direccion')
                                                              ->andWhere('c.codigo_postal LIKE :codigo_postal')
                                                              ->andWhere('c.validez LIKE :validez')
                                                              ->orderBy('c.nombre_comercio', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_comercio.'%')
                                                              ->setParameter('direccion','%'.$direccion_comercio.'%')
                                                              ->setParameter('cp','%'.$codigo_postal.'%')
                                                              ->setParameter('validez','sí')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_comercio)) && !empty($direccion_comercio) && empty($codigo_postal) && !empty($telefono_comercio)){
            //Buscar Comercio por nombre, dirección y teléfono
            $comerciosTemp = $em->getRepository(Comercio::class)->createQueryBuilder('c')
                                                              ->where('c.nombre_comercio LIKE :nombre')
                                                              ->andWhere('c.direccion_comercio LIKE :direccion')
                                                              ->andWhere('c.telefono_empresa LIKE :telefono')
                                                              ->andWhere('c.validez LIKE :validez')
                                                              ->orderBy('c.nombre_comercio', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_comercio.'%')
                                                              ->setParameter('direccion','%'.$direccion_comercio.'%')
                                                              ->setParameter('telefono','%'.$telefono_comercio.'%')
                                                              ->setParameter('validez','sí')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_comercio)) && empty($direccion_comercio) && !empty($codigo_postal) && !empty($telefono_comercio)){
            //Buscar Comercio por nombre, código postal y teléfono
            $comerciosTemp = $em->getRepository(Comercio::class)->createQueryBuilder('c')
                                                              ->where('c.nombre_comercio LIKE :nombre')
                                                              ->andWhere('c.codigo_postal LIKE :codigo_postal')
                                                              ->andWhere('c.telefono_empresa LIKE :telefono')
                                                              ->andWhere('c.validez LIKE :validez')
                                                              ->orderBy('c.nombre_comercio', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_comercio.'%')
                                                              ->setParameter('cp','%'.$codigo_postal.'%')
                                                              ->setParameter('telefono','%'.$telefono_comercio.'%')
                                                              ->setParameter('validez','sí')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_comercio)) && !empty($direccion_comercio) && !empty($codigo_postal) && !empty($telefono_comercio)){
            //Buscar Comercio por dirección, código postal y teléfono
            $comerciosTemp = $em->getRepository(Comercio::class)->createQueryBuilder('c')
                                                              ->where('c.direccion_comercio LIKE :direccion')
                                                              ->andWhere('c.codigo_postal LIKE :codigo_postal')
                                                              ->andWhere('c.telefono_empresa LIKE :telefono')
                                                              ->andWhere('c.validez LIKE :validez')
                                                              ->orderBy('c.nombre_comercio', 'ASC')
                                                              ->setParameter('direccion','%'.$direccion_comercio.'%')
                                                              ->setParameter('cp','%'.$codigo_postal.'%')
                                                              ->setParameter('telefono','%'.$telefono_comercio.'%')
                                                              ->setParameter('validez','sí')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_comercio)) && !empty($direccion_comercio) && empty($codigo_postal) && empty($telefono_comercio)){
            //Buscar Comercio por nombre y dirección
            $comerciosTemp = $em->getRepository(Comercio::class)->createQueryBuilder('c')
                                                              ->where('c.nombre_comercio LIKE :nombre')
                                                              ->andWhere('c.direccion_comercio LIKE :direccion')
                                                              ->andWhere('c.validez LIKE :validez')
                                                              ->orderBy('c.nombre_comercio', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_comercio.'%')
                                                              ->setParameter('direccion','%'.$direccion_comercio.'%')
                                                              ->setParameter('validez','sí')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_comercio)) && empty($direccion_comercio) && !empty($codigo_postal) && empty($telefono_comercio)){
            //Buscar Comercio por nombre y código postal
            $comerciosTemp = $em->getRepository(Comercio::class)->createQueryBuilder('c')
                                                              ->where('c.nombre_comercio LIKE :nombre')
                                                              ->andWhere('c.codigo_postal LIKE :codigo_postal')
                                                              ->andWhere('c.validez LIKE :validez')
                                                              ->orderBy('c.nombre_comercio', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_comercio.'%')
                                                              ->setParameter('cp','%'.$codigo_postal.'%')
                                                              ->setParameter('validez','sí')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_comercio)) && !empty($direccion_comercio) && !empty($codigo_postal) && empty($telefono_comercio)){
            //Buscar Comercio por dirección y código postal
            $comerciosTemp = $em->getRepository(Comercio::class)->createQueryBuilder('c')
                                                              ->where('c.direccion_comercio LIKE :direccion')
                                                              ->andWhere('c.codigo_postal LIKE :codigo_postal')
                                                              ->andWhere('c.validez LIKE :validez')
                                                              ->orderBy('c.nombre_comercio', 'ASC')
                                                              ->setParameter('direccion','%'.$direccion_comercio.'%')
                                                              ->setParameter('cp','%'.$codigo_postal.'%')
                                                              ->setParameter('validez','sí')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_comercio)) && empty($direccion_comercio) && empty($codigo_postal) && !empty($telefono_comercio)){
            //Buscar Comercio por nombre y teléfono
            $comerciosTemp = $em->getRepository(Comercio::class)->createQueryBuilder('c')
                                                              ->where('c.nombre_comercio LIKE :nombre')
                                                              ->andWhere('c.telefono_empresa LIKE :telefono')
                                                              ->andWhere('c.validez LIKE :validez')
                                                              ->orderBy('c.nombre_comercio', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_comercio.'%')
                                                              ->setParameter('telefono','%'.$telefono_comercio.'%')
                                                              ->setParameter('validez','sí')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_comercio)) && !empty($direccion_comercio) && empty($codigo_postal) && !empty($telefono_comercio)){
            //Buscar Comercio por dirección y teléfono
            $comerciosTemp = $em->getRepository(Comercio::class)->createQueryBuilder('c')
                                                              ->where('c.direccion_comercio LIKE :direccion')
                                                              ->andWhere('c.telefono_empresa LIKE :telefono')
                                                              ->andWhere('c.validez LIKE :validez')
                                                              ->orderBy('c.nombre_comercio', 'ASC')
                                                              ->setParameter('direccion','%'.$direccion_comercio.'%')
                                                              ->setParameter('telefono','%'.$telefono_comercio.'%')
                                                              ->setParameter('validez','sí')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_comercio)) && empty($direccion_comercio) && !empty($codigo_postal) && !empty($telefono_comercio)){
            //Buscar Comercio por código postal y teléfono
            $comerciosTemp = $em->getRepository(Comercio::class)->createQueryBuilder('c')
                                                              ->where('c.codigo_postal LIKE :codigo_postal')
                                                              ->andWhere('c.telefono_empresa LIKE :telefono')
                                                              ->andWhere('c.validez LIKE :validez')
                                                              ->orderBy('c.nombre_comercio', 'ASC')
                                                              ->setParameter('cp','%'.$codigo_postal.'%')
                                                              ->setParameter('telefono','%'.$telefono_comercio.'%')
                                                              ->setParameter('validez','sí')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_comercio)) && empty($direccion_comercio) && empty($codigo_postal) && empty($telefono_comercio)){
            //Buscar Comercio por nombre
            $comerciosTemp = $em->getRepository(Comercio::class)->createQueryBuilder('c')
                                                              ->where('c.nombre_comercio LIKE :nombre')
                                                              ->andWhere('c.validez LIKE :validez')
                                                              ->orderBy('c.nombre_comercio', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_comercio.'%')
                                                              ->setParameter('validez','sí')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_comercio)) && !empty($direccion_comercio) && empty($codigo_postal) && empty($telefono_comercio)){
            //Buscar Comercio por dirección
            $comerciosTemp = $em->getRepository(Comercio::class)->createQueryBuilder('c')
                                                              ->where('c.direccion_comercio LIKE :direccion')
                                                              ->andWhere('c.validez LIKE :validez')
                                                              ->orderBy('c.nombre_comercio', 'ASC')
                                                              ->setParameter('direccion','%'.$direccion_comercio.'%')
                                                              ->setParameter('validez','sí')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_comercio)) && empty($direccion_comercio) && !empty($codigo_postal) && empty($telefono_comercio)){
            //Buscar Comercio por código postal
            $comerciosTemp = $em->getRepository(Comercio::class)->createQueryBuilder('c')
                                                              ->where('c.codigo_postal LIKE :codigo_postal')
                                                              ->andWhere('c.validez LIKE :validez')
                                                              ->orderBy('c.nombre_comercio', 'ASC')
                                                              ->setParameter('cp','%'.$codigo_postal.'%')
                                                              ->setParameter('validez','sí')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_comercio)) && empty($direccion_comercio) && empty($codigo_postal) && !empty($telefono_comercio)){
            //Buscar Comercio por teléfono
            $comerciosTemp = $em->getRepository(Comercio::class)->createQueryBuilder('c')
                                                              ->where('c.telefono_empresa LIKE :telefono')
                                                              ->andWhere('c.validez LIKE :validez')
                                                              ->orderBy('c.nombre_comercio', 'ASC')
                                                              ->setParameter('telefono','%'.$telefono_comercio.'%')
                                                              ->setParameter('validez','sí')
                                                              ->getQuery()
                                                              ->getResult();
        }

        else {
            //Buscar todos los comercios
            $comerciosTemp = $em->getRepository(Comercio::class)->findBy(array('validez' => 'sí'), array('nombre_comercio' => 'ASC'));
            //$comerciosTemp = $em->getRepository(Comercio::class)->buscarComercios();
        }

        $comercios = $comerciosTemp;

        return $this->render('cliente/comerciosEncontrados.html.twig', [
            'controller_name' => 'Esta es la página para buscar un Comercio',
            'comercios' => $comercios
        ]);
    }

    #[Route('/cliente/comercio/consultar/{id}', name: 'consultarComercioCli')]
    public function consultarComercio($id): Response
    {
        $em = $this->getDoctrine()->getManager();

        //Buscar el comercio a consultar
        $comercio = $em->getRepository(Comercio::class)->find($id);

        $form = $this->createForm(ComercioConsultaPublicoType::class, $comercio);

        return $this->render('cliente/consultarComercio.html.twig', [
            'controller_name' => 'Datos del comercio',
            'formulario' => $form->createView(),
            'comercio' => $comercio
        ]);
    }

    #[Route('/cliente/oferta/buscar/{id}', name: 'buscarOfertaCli')]
    public function buscarOferta(Request $request, $id): Response
    {
        $em = $this->getDoctrine()->getManager();

        $ofertas = "";

        //Buscar todas las ofertas del comercio seleccionado
        $ofertas = $em->getRepository(Oferta::class)->findBy(array('id_comercio' => $id, 'validez' => 'sí'));

        return $this->render('cliente/buscarOferta.html.twig', [
            'controller_name' => 'Ofertas del comercio',
            'ofertas' => $ofertas,
            'id' => $id
        ]);
    }

    #[Route('/cliente/oferta/consultar/{id}', name: 'consultarOfertaCli')]
    public function consultarOferta($id): Response
    {
        $em = $this->getDoctrine()->getManager();

        //Buscar la oferta a consultar
        $oferta = $em->getRepository(Oferta::class)->find($id);

        $form = $this->createForm(OfertaConsultaType::class, $oferta);

        return $this->render('cliente/consultarOferta.html.twig', [
            'controller_name' => 'Datos de la oferta',
            'formulario' => $form->createView(),
            'oferta' => $oferta,
            'img_oferta' => $oferta->getImgOferta()
        ]);
    }

    #[Route('/cliente/mis-ofertas', name: 'clienteOfertas')]
    public function clienteOfertas(): Response
    {
        $em = $this->getDoctrine()->getManager();

        //Buscar solicitudes de notificaciones que pertenecen al usuario actual
        $cliente = $em->getRepository(Cliente::class)->findOneBy(array('id_usuario' => $this->getUser()->getId()));
        $notificaciones = $em->getRepository(ClienteComercio::class)->findBy(array('id_usuario' => $cliente->getId()));

        //Buscar todos los comercios en los que el usuario tiene activadas las notificaciones
        $comercios = array();
        for($i = 0; $i < sizeof($notificaciones); $i++) {
           $aux = $em->getRepository(Comercio::class)->findBy(array('id' => $notificaciones[$i]->getIdComercio()));
           if($aux !== null) {
               for ($j = 0; $j < sizeof($aux); $j++) {
                   array_push($comercios,$aux[$j]);
               }
           }
        }

        //Buscar todas las ofertas de los comercios en los que el usuario tiene activadas las notificaciones
        $ofertas = array();
        for($i = 0; $i < sizeof($comercios); $i++) {
            $auxOfertas = $em->getRepository(Oferta::class)->findBy(array('id_comercio' => $comercios[$i]->getId(), 'validez' => 'sí'));
            if($aux !== null) {
                for ($j = 0; $j < sizeof($auxOfertas); $j++) {
                    array_push($ofertas,$auxOfertas[$j]);
                }
            }
        }

        return $this->render('cliente/ofertas.html.twig', [
            'controller_name' => 'Esta página muestra las Ofertas de comercios en los que se tienen las notificaciones activadas',
            'ofertas' => $ofertas
        ]);
    }

    #[Route('/cliente/notificaciones', name: 'clienteNotificaciones')]
    public function notificaciones(): Response
    {
        $em = $this->getDoctrine()->getManager();

        //Buscar las solicitudes de notificaciones que pertenecen al usuario actual
        $cliente = $em->getRepository(Cliente::class)->findOneBy(array('id_usuario' => $this->getUser()->getId()));
        $notificaciones = $em->getRepository(ClienteComercio::class)->findBy(array('id_usuario' => $cliente->getId()));

        //Buscar todos los comercios en los que el usuario tiene activadas las notificaciones
        $comercios = array();
        for($i = 0; $i < sizeof($notificaciones); $i++) {
           $aux = $em->getRepository(Comercio::class)->findBy(array('id' => $notificaciones[$i]->getIdComercio()));
           if($aux !== null) {
               for ($j = 0; $j < sizeof($aux); $j++) {
                   array_push($comercios,$aux[$j]);
               }
           }
        }

        return $this->render('cliente/notificaciones.html.twig', [
            'controller_name' => 'Esta página muestra los comercios en los que se tienen las notificaciones activadas',
            'comercios' => $comercios
        ]);
    }

    #[Route('/cliente/notificaciones/activar/{id}', name: 'clienteNotificacionesActivar')]
    public function activarNotificaciones($id): Response
    {
        $notificacion = new ClienteComercio();
        $em = $this->getDoctrine()->getManager();

        //Datos de la solicitud de notificaciones
        $cliente = $em->getRepository(Cliente::class)->findOneBy(array('id_usuario' => $this->getUser()->getId()));
        $notificacion->setIdUsuario($cliente);

        $comercio = $em->getRepository(Comercio::class)->find($id);
        $notificacion->setCif($comercio);
        $notificacion->setIdComercio($comercio);

        //Si no existe una solicitud de notificaciones para el comercio, se guarda en la base de datos
        $notifActiva = $em->getRepository(ClienteComercio::class)->findOneBy(array('id_usuario' => $cliente->getId(), 'id_comercio' => $comercio->getId()));
        if ($notifActiva === null) {
            $em->persist($notificacion);
            $em->flush();
        }
        return $this->redirectToRoute(route: 'clienteNotificaciones');

    }

    #[Route('/cliente/notificaciones/desactivar/{id}', name: 'clienteNotificacionesDesactivar')]
    public function desactivarNotificaciones($id): Response
    {
        $em = $this->getDoctrine()->getManager();

        //Datos de la solicitud de notificaciones
        $cliente = $em->getRepository(Cliente::class)->findOneBy(array('id_usuario' => $this->getUser()->getId()));
        $comercio = $em->getRepository(Comercio::class)->find($id);

        //Buscar la solicitud de notificaciones a eliminar
        $notificacion = $em->getRepository(ClienteComercio::class)->findOneBy(array('id_usuario' => $cliente->getId(), 'id_comercio' => $comercio->getId()));

        //Si existe la solicitud de notificaciones para el comercio, se elimina de la base de datos
        if ($notificacion !== null) {
            $em->remove($notificacion);
            $em->flush();
        }

        return $this->redirectToRoute(route: 'clienteNotificaciones');
    }

    #[Route('/cliente/perfil', name: 'verPerfilCli')]
    public function verPerfil(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $usuario = $em->getRepository(Usuario::class)->find($this->getUser()->getId());

        $form = $this->createForm(PerfilType::class, $usuario);

        return $this->render('cliente/verPerfil.html.twig', [
            'controller_name' => 'Perfil del Usuario',
            'formulario' => $form->createView()
        ]);
    }

    #[Route('/cliente/perfil/editar', name: 'editarPerfilCli')]
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

            return $this->redirectToRoute(route: 'cliente');
        }

        return $this->render('cliente/editarPerfil.html.twig', [
            'controller_name' => '',
            'formulario' => $form->createView()
        ]);
    }

    #[Route('/cliente/perfil/borrar', name: 'borrarPerfilCli')]
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

        return $this->render('cliente/borrarPerfil.html.twig', [
            'controller_name' => 'Esta es la página para borrar el perfil. CUIDADO',
            'formulario' => $form->createView()
        ]);
    }
}
