<?php

namespace App\Form;

use App\Entity\BonDeCommande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class BonDeCommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ligneCommandes', CollectionType::class, [
                'entry_type' => LigneBonDeCommandeType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => false,
            ])
            // Remplacer 'dateCommande' par 'date' ici
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de Commande',
                'required' => false,
            ])
            // Ajout du champ status
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Pending' => 'pending',
                    'Completed' => 'completed',
                    'Cancelled' => 'cancelled',
                ],
                'label' => 'Statut',
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BonDeCommande::class,
        ]);
    }
}
