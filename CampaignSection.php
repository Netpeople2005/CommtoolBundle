<?php

namespace Optime\Bundle\CommtoolBundle;

use Optime\Bundle\CommtoolBundle\Section\AbstractSection;

class CampaignSection extends AbstractSection
{

    public function getName()
    {
        return 'campaign_section';
    }

    public function build(Builder\BuilderInterface $builder, array $options = array())
    {
        $builder->add('singleline')
                ->add('loop', array(
                    'type' => 'singleline',
                ));
    }

}
