<?php

namespace Optime\Bundle\CommtoolBundle\Control;

use Optime\Bundle\CommtoolBundle\Control\AbstractControl;
use Optime\Bundle\CommtoolBundle\Builder\BuilderInterface;

class Multiline extends AbstractControl
{

    public function build(BuilderInterface $builder, array $options = array())
    {
        
    }

    public function getType()
    {
        return 'multiline';
    }

}