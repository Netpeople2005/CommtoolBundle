<?php

namespace Optime\Bundle\CommtoolBundle\Control;

use Optime\Bundle\CommtoolBundle\Builder\BuilderInterface;
use Optime\Bundle\CommtoolBundle\Control\AbstractControl;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Multiline extends AbstractControl
{

    public function build(BuilderInterface $builder, array $options = array())
    {
        
    }

    public function getType()
    {
        return 'multiline';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults(array(
            'is_html' => false,
        ));
    }

}