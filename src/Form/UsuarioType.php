<?php

namespace App\Form;

use App\Entity\Usuario;
//use Doctrine\DBAL\Types\DateType;
//use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;

class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'required' => true
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Contraseña',
                'required' => true
            ])
            ->add('nombre', TextType::class, [
                'label' => 'Nombre',
                'required' => true
            ])
            ->add('apellidos', TextType::class, [
                'label' => 'Apellidos'
            ])
            ->add('fecha_nac', DateType::class, [
                'widget' => 'single_text',
                'attr' => array(
                    'max' => date('Y-m-d')
                )
            ])
            /* ->add('roles', ChoiceType::class, [
                'label' => 'Rol',
                'choices' => [
                    'Usuario' => '["ROLE_USER"]',
                    'Administrador' => '["ROLE_ADMIN"]'
                ],
                'expanded' => true,
                'multiple' => false,
                'required' => true
            ]) */
            ->add('imagen_usu', FileType::class, [
                'label' => 'Foto',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Por favor introduce un formato de imagen válido'
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
        ]);
    }
}
