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
                        '1 Star' => 1,
                        '2 Stars' => 2,
                        '3 Stars' => 3,
                        '4 Stars' => 4,
                        '5 Stars' => 5,
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
