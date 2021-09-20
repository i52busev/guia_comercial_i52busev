<?php

namespace App\Controller;

use App\Entity\Oferta;
use App\Entity\Empresa;
use App\Entity\Usuario;
use App\Entity\Comercio;
use App\Form\OfertaType;
use App\Form\PerfilType;
use App\Form\EmpresaType;
use App\Entity\Empresario;
use App\Form\ComercioType;
use App\Form\ValidarOfertaType;
use App\Form\OfertaConsultaType;
use App\Form\ValidarEmpresaType;
use App\Form\ValidarUsuarioType;
use App\Form\ValidarComercioType;
use App\Form\ModificarUsuarioType;
use App\Form\ComercioConsultaPublicoType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\DependencyInjection\Loader\Configurator\security;
use Symfony\Component\String\Slugger\SluggerInterface;
use \Symfony\Contracts\Translation\LocaleAwareInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;

class EmpresarioController extends AbstractController
{
    #[Route('/empresario', name: 'empresario')]
    public function index(): Response
    {
        return $this->render('empresario/index.html.twig', [
            'controller_name' => 'Esta es la página principal de un Empresario',
        ]);
    }

    #[Route('/empresario/comercioBuscar', name: 'comercioBuscarEmp')]
    public function comercioBuscar(Request $request): Response
    {
        $comercios = "";

        return $this->render('empresario/buscarComercio.html.twig', [
            'controller_name' => 'Esta es la página para buscar un Comercio',
            'comercios' => $comercios
        ]);
    }

    #[Route('/empresario/empresaBuscar', name: 'empresaBuscarEmp')]
    public function empresaBuscar(Request $request): Response
    {
        $empresas = "";

        return $this->render('empresario/buscarEmpresa.html.twig', [
            'controller_name' => 'Esta es la página para buscar una Empresa',
            'empresas' => $empresas
        ]);
    }

    #[Route('/ayuda_empresario', name: 'ayudaEmpresario')]
    public function ayudaUsuarioEmpresario(): Response
    {
        return $this->render('empresario/ayuda.html.twig', [
            'controller_name' => 'Esta es la página de ayuda para el Usuario Empresario',
        ]);
    }

    #[Route('/empresario/empresa/buscar', name: 'buscarEmpresaEmp')]
    public function buscarEmpresa(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $empresas = "";
        $empresasTemp = "";

        $empresario = new Empresario();
        $empresario = $em->getRepository(Empresario::class)->findOneBy(array('id_usuario' => $this->getUser()->getId()));

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

        elseif((empty($nombre_empresa)) && !empty($direccion_empresa) && !empty($localidad_empresa) && !empty($provincia_empresa) && !empty($cp_empresa) && empty($telefono_empresa)){
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
            //Buscar todas las empresas que pertenecen al usuario actual
            $empresasTemp = $em->getRepository(Empresa::class)->findBy(array('id_usuario' => $empresario->getId()), array('nombre_empresa' => 'ASC'));
        }

        $empresas = $empresasTemp;

        return $this->render('empresario/empresasEncontradas.html.twig', [
            'controller_name' => 'Esta es la página para buscar una Empresa',
            'empresas' => $empresas
        ]);
    }

    #[Route('/empresario/empresa/consultar/{id}', name: 'consultarEmpresaEmp')]
    public function consultarEmpresa($id): Response
    {
        $em = $this->getDoctrine()->getManager();

        //Buscar la empresa a consultar
        $empresa = $em->getRepository(Empresa::class)->find($id);
        $form = $this->createForm(EmpresaType::class, $empresa);

        return $this->render('empresario/consultarEmpresa.html.twig', [
            'controller_name' => 'Datos de la empresa',
            'formulario' => $form->createView(),
            'empresa'=> $empresa,
            'logotipo' => $empresa->getLogotipo()
        ]);
    }

    #[Route('/empresario/empresa/modificar/{id}', name: 'modificarEmpresaEmp')]
    public function modificarEmpresa(Request $request, $id): Response
    {
        $empresa = new Empresa();
        $em = $this->getDoctrine()->getManager();

        //Buscar la empresa a modificar
        $empresa = $em->getRepository(Empresa::class)->find($id);
        $form = $this->createForm(EmpresaType::class, $empresa);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $empresa->setValidez(validez: 'pendiente');

            //Se actualiza la empresa en la base de datos
            $em->persist($empresa);
            $em->flush();

            return $this->redirectToRoute(route: 'buscarEmpresaEmp');
        }

        return $this->render('empresario/modificarEmpresa.html.twig', [
            'controller_name' => '',
            'formulario' => $form->createView(),
            'logotipo' => $empresa->getLogotipo()
        ]);
    }

    #[Route('/empresario/empresa/eliminar/{id}', name: 'eliminarEmpresaEmp')]
    public function eliminarEmpresa(Request $request, $id): Response
    {
        $empresa = new Empresa();
        $em = $this->getDoctrine()->getManager();

        //Buscar la empresa a eliminar
        $empresa = $em->getRepository(Empresa::class)->find($id);
        $form = $this->createForm(ValidarEmpresaType::class, $empresa);

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

            return $this->redirectToRoute(route: 'buscarEmpresaEmp');
        }

        return $this->render('empresario/eliminarEmpresa.html.twig', [
            'controller_name' => '',
            'formulario' => $form->createView(),
            'logotipo' => $empresa->getLogotipo()
        ]);
    }

    #[Route('/empresario/empresa/registrar', name: 'registrarEmpresaEmp')]
    public function registrarEmpresa(Request $request): Response
    {
        $empresa = new Empresa();
        $empresario = new Empresario();
        $form = $this->createForm(EmpresaType::class, $empresa);
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
            
            //Se obtiene el usuario empresario actual
            $empresario = $em->getRepository(Empresario::class)->findOneBy(array('id_usuario' => $this->getUser()->getId()));
            $empresa->setIdEmpresario($empresario);
            
            //Se guarda la empresa en la base de datos
            $em->persist($empresa);
            $em->flush();
            $this->addFlash(type: 'exito', message: 'La empresa se ha registrado correctamente');
            return $this->redirectToRoute(route: 'empresario');
        }

        return $this->render('empresario/registrarEmpresa.html.twig', [
            'controller_name' => '',
            'formulario' => $form->createView()
        ]);
    }

    #[Route('/empresario/comercio/buscar', name: 'buscarComercioEmp')]
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
            $comerciosTemp = $em->getRepository(Comercio::class)->findBy(array('validez' => 'sí'), array('nombre_comercio' => 'ASC',));
        }

        $comercios = $comerciosTemp;

        return $this->render('empresario/comerciosEncontrados.html.twig', [
            'controller_name' => 'Esta es la página para buscar un Comercio',
            'comercios' => $comercios
        ]);
    }

    #[Route('/empresario/comercio/emp/buscar', name: 'buscarComercioEmpresarioEmp')]
    public function buscarComercioEmpresario(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();

        $comercios = "";

        //Buscar las empresas del usuario actual
        $empresario = new Empresario();
        $empresario = $em->getRepository(Empresario::class)->findOneBy(array('id_usuario' => $this->getUser()->getId()));
        $empresas = $em->getRepository(Empresa::class)->findBy(array('id_usuario' => $empresario->getId()));
        
        //Buscar todos los comercios de cada empresa
        $comercios = array();
        for($i = 0; $i < sizeof($empresas); $i++) {
            $aux = $em->getRepository(Comercio::class)->findBy(array('id_empresa' => $empresas[$i]->getId()));
            if($aux !== null) {
                for ($j = 0; $j < sizeof($aux); $j++) {
                    array_push($comercios,$aux[$j]);
                }
            }
        }

        return $this->render('empresario/buscarComercioEmpresario.html.twig', [
            'controller_name' => 'Mis Comercios',
            'comercios' => $comercios
        ]);
    }

    #[Route('/empresario/empresa/comercio/buscar/{id}', name: 'buscarComercioEmpresaEmp')]
    public function buscarComercioEmpresa(Request $request, $id): Response
    {
        $em = $this->getDoctrine()->getManager();

        //Buscar todos los comercios de la empresa
        $comercios = $em->getRepository(Comercio::class)->findBy(array('id_empresa' => $id), array('nombre_comercio' => 'ASC'));

        return $this->render('empresario/buscarComercioEmpresa.html.twig', [
            'controller_name' => 'Comercios de la empresa',
            'comercios' => $comercios
        ]);
    }

    #[Route('/empresario/comercio/consultar/{id}', name: 'consultarComercioEmp')]
    public function consultarComercio($id): Response
    {
        $em = $this->getDoctrine()->getManager();

        //Buscar el comercio a consultar
        $comercio = $em->getRepository(Comercio::class)->find($id);
        $form = $this->createForm(ComercioConsultaPublicoType::class, $comercio);

        return $this->render('empresario/consultarComercio.html.twig', [
            'controller_name' => 'Datos del comercio',
            'formulario' => $form->createView(),
            'comercio' => $comercio
        ]);
    }

    #[Route('/empresario/comercio/emp/consultar/{id}', name: 'consultarComercioEmpresarioEmp')]
    public function consultarComercioEmpresario($id): Response
    {
        $em = $this->getDoctrine()->getManager();

        //Buscar el comercio a consultar
        $comercio = $em->getRepository(Comercio::class)->find($id);

        //Se envía información del usuario actual al formulario de registro para filtrar las empresas que pertenecen al empresario
        $empresario = $em->getRepository(Empresario::class)->findOneBy(array('id_usuario' => $this->getUser()->getId()));
        $form = $this->createForm(ComercioType::class, $comercio, ['empresario' => $empresario->getId(),]);

        return $this->render('empresario/consultarComercioEmpresario.html.twig', [
            'controller_name' => 'Datos del comercio',
            'formulario' => $form->createView(),
            'comercio' => $comercio
        ]);
    }

    #[Route('/empresario/comercio/modificar/{id}', name: 'modificarComercioEmp')]
    public function modificarComercio(Request $request, $id): Response
    {
        $comercio = new Comercio();
        $empresa = new Empresa();
        $em = $this->getDoctrine()->getManager();

        //Buscar el comercio a modificar
        $comercio = $em->getRepository(Comercio::class)->find($id);

        //Se envía información del usuario actual al formulario de registro para filtrar las empresas que pertenecen al empresario
        $empresario = $em->getRepository(Empresario::class)->findOneBy(array('id_usuario' => $this->getUser()->getId()));
        $form = $this->createForm(ComercioType::class, $comercio, ['empresario' => $empresario->getId(),]);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $comercio->setValidez(validez: 'pendiente');

            //Se obtiene el CIF de la empresa seleccionada por el usuario
            $empresa = $em->getRepository(Empresa::class)->findOneBy(array('id' => $comercio->getIdEmpresa()));
            $comercio->setCif($empresa->getCif());

            //Se actualiza el comercio en la base de datos
            $em->persist($comercio);
            $em->flush();

            return $this->redirectToRoute(route: 'buscarComercioEmp');
        }

        return $this->render('empresario/modificarComercio.html.twig', [
            'controller_name' => '',
            'formulario' => $form->createView()
        ]);
    }

    #[Route('/empresario/comercio/eliminar/{id}', name: 'eliminarComercioEmp')]
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

            return $this->redirectToRoute(route: 'buscarComercioEmp');
        }

        return $this->render('empresario/eliminarComercio.html.twig', [
            'controller_name' => '',
            'formulario' => $form->createView()
        ]);
    }

    #[Route('/empresario/comercio/registrar', name: 'registrarComercioEmp')]
    public function registrarComercio(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $comercio = new Comercio();
        $empresa = new Empresa();

        //Se envía información del usuario actual al formulario de registro para filtrar las empresas que pertenecen al empresario
        $empresario = $em->getRepository(Empresario::class)->findOneBy(array('id_usuario' => $this->getUser()->getId()));
        $form = $this->createForm(ComercioType::class, $comercio, ['empresario' => $empresario->getId(),]);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $comercio->setValidez(validez: 'pendiente');

            //Se obtiene el CIF de la empresa seleccionada por el usuario
            $empresa = $em->getRepository(Empresa::class)->findOneBy(array('id' => $comercio->getIdEmpresa()));
            $comercio->setCif($empresa->getCif());

            //Se guarda el comercio en la base de datos
            $em->persist($comercio);
            $em->flush();
            $this->addFlash(type: 'exito', message: 'El comercio se ha registrado correctamente');
            return $this->redirectToRoute(route: 'empresario');
        }

        return $this->render('empresario/registrarComercio.html.twig', [
            'controller_name' => '',
            'formulario' => $form->createView()
        ]);
    }

    #[Route('/empresario/oferta/buscar', name: 'buscarOfertaEmp')]
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

        return $this->render('empresario/buscarOferta.html.twig', [
            'controller_name' => 'Esta es la página para buscar una Oferta',
            'ofertas' => $ofertas
        ]);
    }

    #[Route('empresario/comercio/oferta/buscar/{id}', name: 'buscarOfertaComercioEmp')]
    public function buscarOfertaComercio(Request $request, $id): Response
    {
        $em = $this->getDoctrine()->getManager();

        $ofertas = "";

        //Buscar todas las ofertas del comercio seleccionado
        $ofertas = $em->getRepository(Oferta::class)->findBy(array('id_comercio' => $id, 'validez' => 'sí'));

        return $this->render('empresario/buscarOfertaComercio.html.twig', [
            'controller_name' => 'Ofertas del comercio',
            'ofertas' => $ofertas,
            'id' => $id
        ]);
    }

    #[Route('empresario/comercio/emp/oferta/buscar/{id}', name: 'buscarOfertaComercioEmpresarioEmp')]
    public function buscarOfertaComercioEmpresario(Request $request, $id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $ofertas = "";

        //Buscar todas las ofertas del comercio seleccionado
        $ofertas = $em->getRepository(Oferta::class)->findBy(array('id_comercio' => $id));

        return $this->render('empresario/buscarOfertaComercioEmpresario.html.twig', [
            'controller_name' => 'Ofertas del comercio',
            'ofertas' => $ofertas,
            'id' => $id
        ]);
    }

    #[Route('/empresario/oferta/consultar/{id}', name: 'consultarOfertaEmp')]
    public function consultarOferta($id): Response
    {
        $em = $this->getDoctrine()->getManager();

        //Buscar la oferta a consultar
        $oferta = $em->getRepository(Oferta::class)->find($id);
        $form = $this->createForm(OfertaConsultaType::class, $oferta);

        return $this->render('empresario/consultarOferta.html.twig', [
            'controller_name' => 'Datos de la oferta',
            'formulario' => $form->createView(),
            'img_oferta' => $oferta->getImgOferta()
        ]);
    }

    #[Route('empresario/comercio/oferta/consultar/{id}', name: 'consultarOfertaComercioEmp')]
    public function consultarOfertaComercio($id): Response
    {
        $em = $this->getDoctrine()->getManager();

        //Buscar la oferta a consultar
        $oferta = $em->getRepository(Oferta::class)->find($id);
        $form = $this->createForm(OfertaConsultaType::class, $oferta);

        return $this->render('empresario/consultarOfertaComercio.html.twig', [
            'controller_name' => 'Datos de la oferta',
            'formulario' => $form->createView(),
            'oferta' => $oferta,
            'img_oferta' => $oferta->getImgOferta()
        ]);
    }

    #[Route('empresario/comercio/emp/oferta/consultar/{id}', name: 'consultarOfertaComercioEmpresarioEmp')]
    public function consultarOfertaComercioEmpresario($id): Response
    {
        $em = $this->getDoctrine()->getManager();

        //Buscar la oferta a consultar
        $oferta = $em->getRepository(Oferta::class)->find($id);
        $form = $this->createForm(OfertaConsultaType::class, $oferta);

        return $this->render('empresario/consultarOfertaComercioEmpresario.html.twig', [
            'controller_name' => 'Datos de la oferta',
            'formulario' => $form->createView(),
            'oferta' => $oferta,
            'img_oferta' => $oferta->getImgOferta()
        ]);
    }

    #[Route('/empresario/oferta/modificar/{id}', name: 'modificarOfertaEmp')]
    public function modificarOferta(Request $request, $id): Response
    {
        $oferta = new Oferta();
        $comercio = new Comercio();
        $em = $this->getDoctrine()->getManager();

        //Buscar la oferta a modificar
        $oferta = $em->getRepository(Oferta::class)->find($id);

        //Buscar las empresas del usuario actual
        $empresario = $em->getRepository(Empresario::class)->findOneBy(array('id_usuario' => $this->getUser()->getId()));
        $empresas = $em->getRepository(Empresa::class)->findBy(array('id_usuario' => $empresario->getId()));
        
        //Buscar todos los comercios de cada empresa para el filtro de comercios que pertenecen al usuario actual
        $comercios = array();
        for($i = 0; $i < sizeof($empresas); $i++) {
            $aux = $em->getRepository(Comercio::class)->findBy(array('id_empresa' => $empresas[$i]->getId()));
            if($aux !== null) {
                for ($j = 0; $j < sizeof($aux); $j++) {
                    array_push($comercios,$aux[$j]);
                }
            }
        }

        $form = $this->createForm(OfertaType::class, $oferta, ['comercios' => $comercios,]);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $oferta->setValidez(validez: 'pendiente');

            //Se obtiene el CIF de la empresa a la que pertenece el comercio, cuyo nombre ha sido seleccionado por el usuario
            $comercio = $em->getRepository(Comercio::class)->findOneBy(array('id' => $oferta->getIdComercio()));
            $oferta->setCif($comercio->getCif());

            //Se actualiza la oferta en la base de datos
            $em->persist($oferta);
            $em->flush();

            return $this->redirectToRoute(route: 'buscarOfertaEmp');
        }

        return $this->render('empresario/modificarOferta.html.twig', [
            'controller_name' => '',
            'formulario' => $form->createView(),
            'img_oferta' => $oferta->getImgOferta()
        ]);
    }

    #[Route('/empresario/oferta/eliminar/{id}', name: 'eliminarOfertaEmp')]
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

            return $this->redirectToRoute(route: 'buscarOfertaEmp');
        }

        return $this->render('empresario/eliminarOferta.html.twig', [
            'controller_name' => '',
            'formulario' => $form->createView(),
            'img_oferta' => $oferta->getImgOferta()
        ]);
    }

    #[Route('/empresario/oferta/registrar', name: 'registrarOfertaEmp')]
    public function registrarOferta(Request $request): Response
    {
        $oferta = new Oferta();
        $comercio = new Comercio();

        //Buscar las empresas del usuario actual
        $em = $this->getDoctrine()->getManager();
        $empresario = $em->getRepository(Empresario::class)->findOneBy(array('id_usuario' => $this->getUser()->getId()));
        $empresas = $em->getRepository(Empresa::class)->findBy(array('id_usuario' => $empresario->getId()));
        
        //Buscar todos los comercios de cada empresa para el filtro de comercios que pertenecen al usuario actual
        $comercios = array();
        for($i = 0; $i < sizeof($empresas); $i++) {
            $aux = $em->getRepository(Comercio::class)->findBy(array('id_empresa' => $empresas[$i]->getId()));
            if($aux !== null) {
                for ($j = 0; $j < sizeof($aux); $j++) {
                    array_push($comercios,$aux[$j]);
                }
            }
        }

        $form = $this->createForm(OfertaType::class, $oferta, ['comercios' => $comercios,]);

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
            
            //Se obtiene el CIF de la empresa a la que pertenece el comercio, cuyo nombre ha sido seleccionado por el usuario
            $comercio = $em->getRepository(Comercio::class)->findOneBy(array('id' => $oferta->getIdComercio()));
            $oferta->setCif($comercio->getCif());

            //Se guarda la oferta en la base de datos
            $em->persist($oferta);
            $em->flush();
            $this->addFlash(type: 'exito', message: 'La oferta se ha registrado correctamente');
            return $this->redirectToRoute(route: 'empresario');
        }

        return $this->render('empresario/registrarOferta.html.twig', [
            'controller_name' => '',
            'formulario' => $form->createView()
        ]);
    }

    #[Route('/empresario/perfil', name: 'verPerfilEmp')]
    public function verPerfil(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $usuario = $em->getRepository(Usuario::class)->find($this->getUser()->getId());
        
        $form = $this->createForm(PerfilType::class, $usuario);

        return $this->render('empresario/verPerfil.html.twig', [
            'controller_name' => 'Perfil del usuario',
            'formulario' => $form->createView()
        ]);
    }

    #[Route('/empresario/perfil/editar', name: 'editarPerfilEmp')]
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

            return $this->redirectToRoute(route: 'empresario');
        }

        return $this->render('empresario/editarPerfil.html.twig', [
            'controller_name' => '',
            'formulario' => $form->createView()
        ]);
    }

    #[Route('/empresario/perfil/borrar', name: 'borrarPerfilEmp')]
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

        return $this->render('empresario/borrarPerfil.html.twig', [
            'controller_name' => 'Esta es la página para borrar el perfil. CUIDADO',
            'formulario' => $form->createView()
        ]);
    }
}
