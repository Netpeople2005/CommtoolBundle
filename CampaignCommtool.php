<?php

namespace Optime\Bundle\CommtoolBundle;

use Optime\Bundle\CommtoolBundle\AbstractCommtoolBuilder;
use Optime\Bundle\CommtoolBundle\Builder\BuilderInterface;

class CampaignCommtool extends AbstractCommtoolBuilder
{

    public function build(BuilderInterface $builder, array $options = array())
    {
        $builder->add('singleline', array(
            'data' => function(SectionConfig $section) {
                
            },
        ));
        $builder->add('product');
        $builder->add('loop', array(
            'type' => 'singleline',
            'selector' => 'sin',
        ));
        $builder->add('loop', array(
            'type' => 'product',
            'selector' => 'pro',
        ));
    }

}