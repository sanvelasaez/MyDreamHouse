<?php

namespace App\Form;

use App\Entity\Casa;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\Image;

class CasaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo', TextType::class, [
                'label' => 'Título',
                'required' => false
            ])
            ->add('direccion', TextType::class, [
                'label' => 'Dirección'
            ])
            ->add('cp', TextType::class, [
                'label' => 'Código postal',
                'required' => false
            ])
            ->add('tipo_venta', ChoiceType::class, [
                'choices' => [
                    'Se vende' => 'venta',
                    'Se alquila' => 'alquiler',
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'Tipo de venta',
                'required' => false,
                'placeholder' => false,
                
            ])
            ->add('tipo_casa', ChoiceType::class, [
                'choices' => [
                    'Piso' => 'piso',
                    'Ático' => 'ático',
                    'Bajo' => 'bajo',
                    'Dúplex' => 'dúplex',
                    'Loft' => 'loft',
                    'Estudio' => 'estudio',
                    'Casa o chalet' => 'casa o chalet',
                    'Chalet pareado' => 'chalet pareado',
                    'Chalet adosado' => 'chalet adosado',
                    'Finca' => 'finca'
                ],
                'expanded' => false,
                'multiple' => false,
                'label' => 'Tipo de casa',
                'required' => true,
                'placeholder'=>'Elija tipo de casa'
            ])
            ->add('id_ciu', EntityType::class, [
                'required' => true,
                'label' => 'Ciudad',
                'class' => 'App:Ciudad',
                'expanded' => false,
                'multiple' => false,
                'placeholder'=>'Elija ciudad'
            ])
            ->add('m2', IntegerType::class, [
                'label' => 'Metros cuadrados',
                'required' => false
            ])
            ->add('precio', MoneyType::class, [
                'label' => 'Precio',
                'required' => false
            ])
            ->add('fotos', FileType::class, [
                'label' => 'Fotos',
                'mapped' => false,
                'required' => false,
                'multiple' => true,
                'data_class' => null,
                /* 'constraints' => [
                    new Image([
                        'maxSize' => '20480k',
                        'maxSizeMessage'=>'Imágenes demasiado grandes, límite 20MB',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Por favor introduce un formato de imagen válido'
                    ])
                ] */
            ])
            ->add('descripcion', TextareaType::class, [
                'label' => 'Descripción',
                'required' => false
            ])
            ->add('habitaciones', IntegerType::class, [
                'label' => 'Número de habitaciones',
                'required' => false
            ])
            ->add('banos', IntegerType::class, [
                'label' => 'Número de baños',
                'required' => false
            ])
            ->add('coordenadas')
            ->add('especificaciones', TextareaType::class, [
                'label' => 'Especificaciones',
                'required' => false
            ])
            /* ->add('prioridad') */
            ->add('extra1', TextType::class, [
                'label' => 'Extra 1 ( Tipo de casa más preciso y si tiene ascensor)',
                'required' => false
            ])
            ->add('extra2', TextType::class, [
                'label' => 'Extra 2 ( Si tiene garaje)',
                'required' => false
            ])
            /* ->add('activo') */
            /* ->add('id_usu') */
            ->add('id_prop', EntityType::class, [
                'required' => true,
                'label' => 'Propietario',
                'class' => 'App:Propietario',
                'expanded' => false,
                'multiple' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Casa::class,
        ]);
    }
}
