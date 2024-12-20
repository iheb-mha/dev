<?php
// src/Form/LigneMedicamentType.php

namespace App\Form;

use App\Entity\LigneMedicament;
use App\Entity\Medicament;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LigneMedicamentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('medicament', EntityType::class, [
                'class' => Medicament::class,
                'choice_label' => 'id',
                'label' => 'Medicament ID',
            ])
            ->add('numLigne', IntegerType::class, [
                'required' => true,
                'label' => 'Line of Command',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LigneMedicament::class,
        ]);
    }
}