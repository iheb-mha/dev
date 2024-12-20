<?php

namespace App\Form;

use App\Entity\LigneBonDeCommande;
use App\Entity\Medicament;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LigneBonDeCommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('medicament', EntityType::class, [
                'class' => Medicament::class,
                'choice_label' => 'nom',
                'multiple' => false,
                'expanded' => false,
                'label' => 'Médicaments',
                'required' => true,
                'attr' => ['style' => 'border: 2px solid;width:150px ; padding: 5px;margin-left: auto;'],
            ])
            ->add('quantite', NumberType::class, [
                'label' => 'Quantité',
                'required' => true,
                'attr' => ['style' => 'border: 2px solid; width:150px ; padding: 5px;margin-left: auto;'],
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LigneBonDeCommande::class,
        ]);
    }
}