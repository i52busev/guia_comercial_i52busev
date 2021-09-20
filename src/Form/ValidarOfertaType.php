<?php

namespace App\Form;

use App\Entity\Oferta;
use App\Entity\Empresa;
use App\Entity\Comercio;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ValidarOfertaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id_comercio', EntityType::class, array(
                'class' => Comercio::class,
                'label' => 'Comercio',
                'choice_label' => 'nombre_comercio',
                'disabled' => true,
                'required' => true))

            ->add('descripcion', TextareaType::class, array(
                'label' => 'Descripción',
                'disabled' => true,
                'required' => true,
                'attr' => array('maxlength' => 255)))

            ->add('fecha_inicio', DateTimeType::class, array(
                'label' => 'Inicio de la oferta',
                'widget' => 'text',
                'disabled' => true,
                'required' => true))

            ->add('fecha_fin', DateTimeType::class, array(
                'label' => 'Fin de la oferta',
                'widget' => 'text',
                'disabled' => true,
                'required' => true))

            ->add('img_oferta', UrlType::class, array(
                'label' => 'Imagen',
                'disabled' => true,
                'required' => false,
                'attr' => array('maxlength' => 255)))

            ->add('Validar', type: SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Oferta::class,
        ]);
    }
}
