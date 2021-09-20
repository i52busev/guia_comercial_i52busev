<?php

namespace App\Form;

use App\Entity\Empresa;
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
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ValidarEmpresaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder    
            ->add('id_usuario', EntityType::class, array(
                'class' => Empresario::class,
                'label' => 'Id Empresario',
                'query_builder' => function (EntityRepository $er) use ($options){
                    return $er->createQueryBuilder('e')
                        ->where('e.id = ?1')
                        ->orderBy('e.id', 'ASC')
                        ->setParameter(1,$options['empresario']);
                },
                'choice_label' => 'id',
                'mapped' => false,
                'disabled' => true,
                'required' => true))


            ->add('cif', TextType::class, array(
                'label' => 'CIF',
                'disabled' => true,
                'required' => true,
                'attr' => array('maxlength' => 9)))

            ->add('nombre_empresa', TextType::class, array(
                'label' => 'Nombre',
                'disabled' => true,
                'required' => true,
                'attr' => array('maxlength' => 64)))
                
            ->add('direccion_empresa', TextType::class, array(
                'label' => 'Dirección',
                'disabled' => true,
                'required' => true,
                'attr' => array('maxlength' => 64)))

            ->add('localidad_empresa', TextType::class, array(
                'label' => 'Localidad',
                'disabled' => true,
                'required' => true,
                'attr' => array('maxlength' => 64)))

            ->add('provincia_empresa', TextType::class, array(
                'label' => 'Provincia',
                'disabled' => true,
                'required' => true,
                'attr' => array('maxlength' => 20)))
            
            ->add('cp_empresa', NumberType::class, array(
                'label' => 'Código Postal',
                'disabled' => true, 
                'required' => false,
                'attr' => array('maxlenght' => 5)))

            ->add('telefono_empresa', NumberType::class, array(
                'label' => 'Teléfono',
                'disabled' => true, 
                'required' => true,
                'attr' => array('maxlenght' => 9)))

            ->add('actividad_economica', TextareaType::class, array(
                'label' => 'Actividad Económica',
                'disabled' => true,
                'required' => true,
                'attr' => array('maxlength' => 255)))

            ->add('web_empresa', UrlType::class, array(
                'label' => 'Página Web',
                'disabled' => true,
                'required' => false,
                'attr' => array('maxlength' => 255)))

            ->add('logotipo', UrlType::class, array(
                'label' => 'Logotipo',
                'disabled' => true,
                'required' => false,
                'attr' => array('maxlength' => 255)))

            ->add('Validar', type: SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Empresa::class,
            'empresario' => null,
        ]);
    }
}
