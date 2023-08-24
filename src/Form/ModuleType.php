<?php

namespace App\Form;

use App\Entity\Module;
use App\Entity\Session;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ModuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('labelModule')
            ->add('duration')
            ->add('sessions', EntityType::class, [ 
                'class' => Session::class,
                'choice_label' => 'label',
                'multiple' => true,  // Permet de sélectionner plusieurs sessions
                'expanded' => false, // Utilisez un menu déroulant pour la sélection
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Module::class,
        ]);
    }
}
