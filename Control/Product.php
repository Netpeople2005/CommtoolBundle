<?php

namespace Optime\Bundle\CommtoolBundle\Control;

use Optime\Bundle\CommtoolBundle\Control\AbstractControl;
use Optime\Bundle\CommtoolBundle\Builder\BuilderInterface;

class Product extends AbstractControl
{

    public function build(BuilderInterface $builder, array $options = array())
    {
        $builder->addNamed('product_image', 'image');
        $builder->addNamed('product_name', 'text');
        $builder->addNamed('product_description', 'multiline');
    }

    public function getType()
    {
        return 'product';
    }

}