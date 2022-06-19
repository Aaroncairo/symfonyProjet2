<?php

namespace App\Form;

use App\Entity\Employes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom')
            ->add('nom')
            ->add('telephone')
            ->add('email')
            ->add('adresse', TextareaType::class, ["attr" => ["row" => 4]])
            ->add('poste')
            ->add('salaire')
            ->add('date_naissance')
            ->add("creer", SubmitType::class, ["label" => "Créer l'employe"])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employes::class,
        ]);
    }
}
