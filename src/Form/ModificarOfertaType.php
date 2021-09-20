<?php

namespace App\Form;

use App\Entity\Oferta;
use App\Entity\Comercio;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ModificarOfertaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descripcion', TextareaType::class, array(
                'label' => 'Descripción',
                'required' => true,
                'attr' => array('maxlength' => 255),
                'help' => 'Ej: 20% de descuento en productos de limpieza'))

            ->add('fecha_inicio', DateTimeType::class, array(
                'label' => 'Inicio de la oferta',
                'widget' => 'choice',
                'required' => true))
            
            ->add('fecha_fin', DateTimeType::class, array(
                'label' => 'Fin de la oferta',
                'widget' => 'choice',
                'required' => true))

            ->add('img_oferta', FileType::class, array(
                'label' => 'Imagen Oferta',
                'required' => false,
                'mapped' => false,
                'attr' => array('maxlength' => 255),))

            ->add('cif', TextType::class, array(
                'label' => 'CIF',
                'required' => true,
                'attr' => array('maxlength' => 9),
                'help' => 'Código de Identificación Fiscal de la empresa (8 números y 1 letra)'))

            ->add('id_comercio', EntityType::class, array(
                'class' => Comercio::class,
                'label' => 'Comercio',
                'choice_label' => 'nombre_comercio',
                'required' => true,
                'help' => 'Identificador del comercio al que pertenece la oferta'))
    
            ->add('Aceptar', type: SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Oferta::class,
        ]);
    }
}
