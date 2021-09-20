<?php

namespace App\Form;

use App\Entity\Empresa;
use App\Entity\Comercio;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ValidarComercioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id_empresa', EntityType::class, array(
                'class' => Empresa::class,
                'label' => 'Empresa',
                'choice_label' => 'nombre_empresa',
                'disabled' => true,
                'required' => true))

            ->add('cif', TextType::class, array(
                'label' => 'CIF',
                'disabled' => true,
                'required' => true,
                'attr' => array('maxlength' => 9)))

            ->add('nombre_comercio', TextType::class, array(
                'label' => 'Nombre',
                'disabled' => true,
                'required' => true,
                'attr' => array('maxlength' => 64)))

            ->add('direccion_comercio', TextType::class, array(
                'label' => 'Dirección',
                'disabled' => true,
                'required' => true,
                'attr' => array('maxlength' => 64)))

            ->add('codigo_postal', NumberType::class, array(
                'label' => 'Código Postal',
                'disabled' => true, 
                'required' => false,
                'attr' => array('maxlenght' => 5)))

            ->add('telefono_comercio', NumberType::class, array(
                'label' => 'Teléfono',
                'disabled' => true, 
                'required' => true,
                'attr' => array('maxlenght' => 9)))

            ->add('web_comercio', UrlType::class, array(
                'label' => 'Página Web',
                'disabled' => true,
                'required' => false,
                'attr' => array('maxlength' => 255)))
                
            ->add('Validar', type: SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comercio::class,
        ]);
    }
}
