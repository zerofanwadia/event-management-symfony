<?php

namespace App\Form;

use App\Entity\Event;
use App\Model\EventFiltrer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecherchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', SearchType::class, [
                'label' => 'Chercher',
                'required' => false,
                'attr' => ['placeholder' => 'Chercher un événement']])
                ->add('lieu', SearchType::class, [
                    'label' => 'Lieu',
                    'required' => false,
                    'attr' => ['placeholder' => 'Chercher par lieu']])
                    ->add('startDate', DateType::class, [
                        'label' => 'Date de début',
                        'required' => false,
                        'attr' => ['placeholder' => 'date de début']])
                        ->add('endDate', DateType::class, [
                            'label' => 'Date de fin',
                            'required' => false,
                            'attr' => ['placeholder' => 'date de fin']])
            ->add('Recherche', SubmitType::class)
            
            
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EventFiltrer::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }
}
