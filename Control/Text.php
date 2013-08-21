<?php

namespace Optime\Bundle\CommtoolBundle\Control;

use Optime\Bundle\CommtoolBundle\Builder\BuilderInterface;
use Optime\Bundle\CommtoolBundle\Control\AbstractControl;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Text extends AbstractControl
{

    public function build(BuilderInterface $builder, array $options = array())
    {
        
    }

    public function getType()
    {
        return 'text';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults(array(
            'is_interactive' => false,
            'is_html' => true,
        ));
    }

}