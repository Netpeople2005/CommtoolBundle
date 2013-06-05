<?php

namespace Optime\Bundle\CommtoolBundle\Section;

use Optime\Bundle\CommtoolBundle\Section\AbstractSection;

class Multiline extends AbstractSection
{

    protected $value;

    public function build(\Optime\Bundle\CommtoolBundle\Builder\BuilderInterface $builder, array $options = array())
    {
        
    }

    public function getName()
    {
        return 'multiline';
    }

}