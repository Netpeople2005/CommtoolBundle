<?php

namespace Optime\Bundle\CommtoolBundle;

use Optime\Bundle\CommtoolBundle\AbstractTemplate;
use Optime\Bundle\CommtoolBundle\Builder\BuilderInterface;

class CampaignTemplate extends AbstractTemplate
{

    public function build(BuilderInterface $builder, array $options = array())
    {
        $builder->add('singleline')
                ->add('loop', array(
                    'type' => 'singleline',
                    'selector' => 'nombres',
        ));
    }

}
