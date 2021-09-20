<?php

namespace App\Form;

use App\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class PerfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('email', EmailType::class, array(
            'label' => 'Correo electrónico', 
            'required' => true,
            'attr' => array('maxlenght' => 64)))

        ->add('nombre', TextType::class, array(
            'label' => 'Nombre', 
            'required' => true,
            'attr' => array('maxlenght' => 20)))

        ->add('apellidos', TextType::class, array(
            'label' => 'Apellidos', 
            'required' => true,
            'attr' => array('maxlenght' => 64)))

        ->add('telefono', NumberType::class, array(
            'label' => 'Teléfono', 
            'required' => true,
            'attr' => array('maxlenght' => 9)))

        ->add('fecha_alta', DateTimeType::class, array(
            'label' => 'Fecha alta',
            'widget' => 'text',
            'disabled' => true,
            'required' => true))
       
        ->add('roles', ChoiceType::class, [
            'label' => 'Tipo de usuario',
            'required' => true,
            'multiple' => false,
            'choices' => [
                'Cliente' => 'ROLE_CLIENTE',
                'Empresario' => 'ROLE_EMPRESARIO',
                'Administrador' => 'ROLE_ADMINISTRADOR',],
            ])

        ;

        //Conversión para el campo de elección de roles
        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                     //Transformar el array en string
                     return count($rolesArray)? $rolesArray[0]: null;
                },
                function ($rolesString) {
                     //Volver a transformar el string en array
                     return [$rolesString];
                }
        ));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
        ]);
    }
}
