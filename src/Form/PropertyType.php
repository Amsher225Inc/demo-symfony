<?php

namespace App\Form;

use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('room')
            ->add('betroom')
            ->add('description')
            ->add('heat', ChoiceType::class, [
                'choices' => $this->getChoises()
            ])
            ->add('adresse')
            ->add('city')
            ->add('floor')
            ->add('price')
            ->add('postal_code')
            ->add('sold')
            ->add('surface')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
            'translation_domain' => 'forms'
        ]);
    }

    /***
     * @return array
     */
    private function getChoises() : array
    {
        $choises = Property::HEAT;
        $output = [];
        foreach ($choises as $k => $v){
            $output[$v] = $k;
        }
        return $output;
    }
}
