<?php

namespace App\Controller;

use App\Entity\Oferta;
use App\Entity\Comercio;
use App\Form\ComercioType;
use App\Form\OfertaConsultaType;
use App\Form\ComercioConsultaPublicoType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PrincipalController extends AbstractController
{
    #[Route('/', name: 'principal')]
    public function index(): Response
    {
        return $this->render('principal/index.html.twig', [
            'controller_name' => 'Esta es la página principal',
        ]);
    }

    #[Route('/comercioBuscar', name: 'comercioBuscarPublico')]
    public function comercioBuscar(Request $request): Response
    {
        $comercios = "";

        return $this->render('principal/buscarComercio.html.twig', [
            'controller_name' => 'Esta es la página para buscar un Comercio',
            'comercios' => $comercios
        ]);
    }

    #[Route('/ayuda', name: 'ayudaPublico')]
    public function ayudaUsuarioPublico(): Response
    {
        return $this->render('principal/ayuda.html.twig', [
            'controller_name' => 'Esta es la página de ayuda para el Usuario Público',
        ]);
    }

    #[Route('/comercio/buscar', name: 'buscarComercio')]
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
                                                              ->andWhere('c.telefono_comercio LIKE :telefono')
                                                              ->andWhere('c.validez LIKE :validez')
                                                              ->orderBy('c.nombre_comercio', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_comercio.'%')
                                                              ->setParameter('direccion','%'.$direccion_comercio.'%')
                                                              ->setParameter('codigo_postal','%'.$codigo_postal.'%')
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
                                                              ->setParameter('codigo_postal','%'.$codigo_postal.'%')
                                                              ->setParameter('validez','sí')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_comercio)) && !empty($direccion_comercio) && empty($codigo_postal) && !empty($telefono_comercio)){
            //Buscar Comercio por nombre, dirección y teléfono
            $comerciosTemp = $em->getRepository(Comercio::class)->createQueryBuilder('c')
                                                              ->where('c.nombre_comercio LIKE :nombre')
                                                              ->andWhere('c.direccion_comercio LIKE :direccion')
                                                              ->andWhere('c.telefono_comercio LIKE :telefono')
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
                                                              ->andWhere('c.telefono_comercio LIKE :telefono')
                                                              ->andWhere('c.validez LIKE :validez')
                                                              ->orderBy('c.nombre_comercio', 'ASC')
                                                              ->setParameter('nombre','%'.$nombre_comercio.'%')
                                                              ->setParameter('codigo_postal','%'.$codigo_postal.'%')
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
                                                              ->andWhere('c.telefono_comercio LIKE :telefono')
                                                              ->andWhere('c.validez LIKE :validez')
                                                              ->orderBy('c.nombre_comercio', 'ASC')
                                                              ->setParameter('direccion','%'.$direccion_comercio.'%')
                                                              ->setParameter('codigo_postal','%'.$codigo_postal.'%')
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
                                                              ->setParameter('codigo_postal','%'.$codigo_postal.'%')
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
                                                              ->setParameter('codigo_postal','%'.$codigo_postal.'%')
                                                              ->setParameter('validez','sí')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif(!(empty($nombre_comercio)) && empty($direccion_comercio) && empty($codigo_postal) && !empty($telefono_comercio)){
            //Buscar Comercio por nombre y teléfono
            $comerciosTemp = $em->getRepository(Comercio::class)->createQueryBuilder('c')
                                                              ->where('c.nombre_comercio LIKE :nombre')
                                                              ->andWhere('c.telefono_comercio LIKE :telefono')
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
                                                              ->andWhere('c.telefono_comercio LIKE :telefono')
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
                                                              ->andWhere('c.telefono_comercio LIKE :telefono')
                                                              ->andWhere('c.validez LIKE :validez')
                                                              ->orderBy('c.nombre_comercio', 'ASC')
                                                              ->setParameter('codigo_postal','%'.$codigo_postal.'%')
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
                                                              ->setParameter('codigo_postal','%'.$codigo_postal.'%')
                                                              ->setParameter('validez','sí')
                                                              ->getQuery()
                                                              ->getResult();
        }

        elseif((empty($nombre_comercio)) && empty($direccion_comercio) && empty($codigo_postal) && !empty($telefono_comercio)){
            //Buscar Comercio por teléfono
            $comerciosTemp = $em->getRepository(Comercio::class)->createQueryBuilder('c')
                                                              ->where('c.telefono_comercio LIKE :telefono')
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
        }

        $comercios = $comerciosTemp;

        return $this->render('principal/comerciosEncontrados.html.twig', [
            'controller_name' => 'Esta es la página para buscar un Comercio',
            'comercios' => $comercios
        ]);
    }

    #[Route('/comercio/consultar/{id}', name: 'consultarComercio')]
    public function consultarComercio($id): Response
    {
        $em = $this->getDoctrine()->getManager();

        //Buscar el comercio a consultar
        $comercio = $em->getRepository(Comercio::class)->find($id);

        $form = $this->createForm(ComercioConsultaPublicoType::class, $comercio);

        return $this->render('principal/consultarComercio.html.twig', [
            'controller_name' => 'Datos del comercio',
            'formulario' => $form->createView(),
            'comercio' => $comercio
        ]);
    }

    #[Route('/oferta/buscar/{id}', name: 'buscarOferta')]
    public function buscarOferta(Request $request, $id): Response
    {
        $em = $this->getDoctrine()->getManager();

        $ofertas = "";

        //Buscar todas las ofertas del comercio seleccionado
        $ofertas = $em->getRepository(Oferta::class)->findBy(array('id_comercio' => $id, 'validez' => 'sí'));

        return $this->render('principal/buscarOferta.html.twig', [
            'controller_name' => 'Ofertas del comercio',
            'ofertas' => $ofertas,
            'id' => $id
        ]);
    }

    #[Route('/oferta/consultar/{id}', name: 'consultarOferta')]
    public function consultarOferta($id): Response
    {
        $em = $this->getDoctrine()->getManager();

        //Buscar la oferta a consultar
        $oferta = $em->getRepository(Oferta::class)->find($id);

        $form = $this->createForm(OfertaConsultaType::class, $oferta);

        return $this->render('principal/consultarOferta.html.twig', [
            'controller_name' => 'Datos de la oferta',
            'formulario' => $form->createView(),
            'oferta' => $oferta,
            'img_oferta' => $oferta->getImgOferta()
        ]);
    }
}
