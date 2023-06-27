<?php

namespace App\Form;

use App\Entity\Service;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('owner_id')
            ->add('creator_id')
            ->add('updater_id')
            ->add('service_status_id')
            ->add('service_type_id')
            ->add('service_field_id')
            ->add('title')
            ->add('description')
            ->add('adress')
            ->add('city_id')
            ->add('county_id')
            ->add('country_id')
            ->add('deadline')
            ->add('price')
            ->add('valid_till')
            ->add('created_at')
            ->add('updated_at')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}
