<?php

namespace Optime\Bundle\CommtoolBundle\Control;

use Optime\Bundle\CommtoolBundle\Control\AbstractControl;
use Optime\Bundle\CommtoolBundle\Builder\BuilderInterface;

class ProductDetail extends AbstractControl
{

    public function build(BuilderInterface $builder, array $options = array())
    {
        $builder->addNamed('part_number', 'text');
        $builder->addNamed('reward', 'text');
        $builder->addNamed('points', 'text');
    }

    public function getType()
    {
        return 'product_detail';
    }

}