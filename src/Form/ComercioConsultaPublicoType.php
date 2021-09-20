<?php

namespace App\Form;

use App\Entity\Empresa;
use App\Entity\Comercio;
use App\Entity\Empresario;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ComercioConsultaPublicoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder                
            ->add('id_empresa', EntityType::class, array(
                'class' => Empresa::class,
                'label' => 'Empresa*',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('e')
                        ->orderBy('e.nombre_empresa', 'ASC');
                },
                'choice_label' => 'nombre_empresa',
                'required' => true,
                'help' => 'Seleccionar la empresa'))

            ->add('nombre_comercio', TextType::class, array(
                'label' => 'Nombre del comercio*',
                'required' => true,
                'attr' => array('maxlength' => 64)))
                
            ->add('direccion_comercio', TextType::class, array(
                'label' => 'Dirección*',
                'required' => true,
                'attr' => array('maxlength' => 64),
                'help' => 'Dirección completa del callejero municipal'))

            ->add('codigo_postal', NumberType::class, array(
                'label' => 'Código Postal', 
                'required' => false,
                'attr' => array('maxlenght' => 5),
                'help' => 'Ej: 14850 (opcional)'))

            ->add('telefono_comercio', NumberType::class, array(
                'label' => 'Teléfono*', 
                'required' => true,
                'attr' => array('maxlenght' => 9),
                'help' => 'Ej: 957123456'))

            ->add('web_comercio', UrlType::class, array(
                'label' => 'Página Web',
                'required' => false,
                'attr' => array('maxlength' => 255),
                'help' => 'URL de la página web del comercio (opcional)'))

            ->add('Registrar', type: SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comercio::class,
        ]);
    }
}
