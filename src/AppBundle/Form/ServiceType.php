<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ServiceType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('label')
            ->add('url')
            ->add('monitoring', EntityType::class, [
                // L'objet qui doit être récupéré dans le formulaire
                'class' => 'AppBundle:Monitoring',
                // Le champs qui sera utilisé en tant que label représentant l'objet
                'choice_label' => 'label',
                ]
            )
            ->add('estPublic', null, ['label' => 'Est public ?'])
            ->add('estSurAccueil', null, ['label' => 'Est sur l\'accueil ?']);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Service'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_service';
    }

}
