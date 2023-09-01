<?php

namespace App\Form;

use App\Entity\Service;
use App\Repository\ServiceTypeRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceUserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('service_type')
            ->add('service_status')
            ->add('service_field')
            ->add('title')
            ->add('description')
            ->add('adress')
            ->add('city')
            ->add('deadline')
            ->add('price')
            ->add('image', FileType::class, [
                'mapped' => false,
                'required' => false,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}
