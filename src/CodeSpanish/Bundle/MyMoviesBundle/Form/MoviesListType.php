<?php

namespace CodeSpanish\Bundle\MyMoviesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MoviesListType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('amazonId')
            ->add('imdbId')
            ->add('wikipediaId')
            ->add('rottentomatoesId')
            ->add('mymoviesId')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CodeSpanish\Bundle\MyMoviesBundle\Entity\MoviesList'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'codespanish_bundle_mymoviesbundle_movieslist';
    }
}
