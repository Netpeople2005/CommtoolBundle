<?php

namespace Optime\Bundle\CommtoolBundle\Section;

use Optime\Bundle\CommtoolBundle\Section\AbstractSection;

class Singleline extends AbstractSection
{

    protected $value;

    public function build(\Optime\Bundle\CommtoolBundle\Builder\BuilderInterface $builder, array $options = array())
    {
        
    }

    public function getName()
    {
        return 'singleline';
    }

}