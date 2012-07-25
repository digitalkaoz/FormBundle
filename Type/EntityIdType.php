<?php

namespace Gregwar\FormBundle\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Form\Exception\FormException;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Gregwar\FormBundle\DataTransformer\OneEntityToIdTransformer;
use Symfony\Component\OptionsResolver\Options;

/**
 * Entity identitifer
 *
 * @author Gregwar <g.passault@gmail.com>
 */
class EntityIdType extends AbstractType
{
    protected $registry;

    public function __construct(RegistryInterface $registry)
    {
        $this->registry = $registry;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addViewTransformer(new OneEntityToIdTransformer(
            $this->registry->getEntityManager($options['em']),
            $options['class'], 
            $options['property'],
            $options['query_builder']
        ), true);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $hidden = function (Options $options) {
            return $options['hidden'];
        };
        
        $resolver->setDefaults(array(
            'em'                => null,
            'class'             => null,
            'property'          => null,
            'query_builder'     => null,
            'compound'          => false,
            'type'              => 'hidden',
            'hidden'            => $hidden,
        ));
    }
    

    public function getParent()
    {
        //$options = $this->getDefaultOptions(array());
        return 'text';
        
        return $options['hidden'] ? 'hidden' : 'text';
    }

    public function getName()
    {
        return 'entity_id';
    }
}
