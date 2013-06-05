<?php

namespace Optime\Bundle\CommtoolBundle\Section;

use Optime\Bundle\CommtoolBundle\Section\AbstractSection;

class Product extends AbstractSection
{

    public function build(\Optime\Bundle\CommtoolBundle\Builder\BuilderInterface $builder, array $options = array())
    {
        
    }

    public function getName()
    {
        return 'singleline';
    }

}