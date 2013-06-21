<?php

namespace Optime\Bundle\CommtoolBundle\Control;

use Optime\Bundle\CommtoolBundle\Control\AbstractControl;
use Optime\Bundle\CommtoolBundle\Builder\BuilderInterface;

class Product extends AbstractControl
{

    public function build(BuilderInterface $builder, array $options = array())
    {
        $builder->add('singleline')
                ->add('multiline');
    }

    public function getType()
    {
        return 'product';
    }

}