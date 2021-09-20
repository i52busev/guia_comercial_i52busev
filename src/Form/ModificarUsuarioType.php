<?php

namespace App\Form;

use App\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ModificarUsuarioType extends AbstractType
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
            
            ->add('Aceptar', type: SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
        ]);
    }
}
