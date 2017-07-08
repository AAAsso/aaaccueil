<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class MonitoringType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('label')
            ->add('description')
            ->add('application', EntityType::class, [
                // L'objet qui doit être récupéré dans le formulaire
                'class' => 'AppBundle:Application',
                // Le champs qui sera utilisé en tant que label représentant l'objet
                'choice_label' => 'label',
                ]
            )
            ->add('estPublic', null, ['label' => 'Est public ?']);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Monitoring'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_monitoring';
    }

}
