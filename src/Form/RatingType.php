<?php

namespace App\Form;

use App\Entity\Rating;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RatingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('text')
            ->add('rating_score')
            ->add(
                'rating_score',
                ChoiceType::class,
                [
                    'choices' => [
                        '1 zvijezda' => 1,
                        '2 zvijezdice' => 2,
                        '3 zvijezdice' => 3,
                        '4 zvijezdice' => 4,
                        '5 zvijezdica' => 5,
                    ],
                    'expanded' => true
                ]
            );

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rating::class,
        ]);
    }
}
