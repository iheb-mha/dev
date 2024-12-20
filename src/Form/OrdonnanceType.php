<?php

namespace App\Form;

use App\Entity\LigneMedicament;
use App\Entity\Medecin;
use App\Entity\Ordonnance;
use App\Entity\user;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrdonnanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateEmission', null, [
                'widget' => 'single_text'
            ])
            ->add('idClient', EntityType::class, [
                'class' => user::class,
                'choice_label' => 'id',
            ])
            ->add('medecin', EntityType::class, [
                'class' => Medecin::class,
                'choice_label' => 'nom',
            ])
            ->add('LigneMedicament', EntityType::class, [
                'class' => LigneMedicament::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ordonnance::class,
        ]);
    }
}
