<?php

namespace Optime\Bundle\CommtoolBundle;

use Optime\Bundle\CommtoolBundle\AbstractCommtoolBuilder;
use Optime\Bundle\CommtoolBundle\Builder\BuilderInterface;

class CampaignCommtool extends AbstractCommtoolBuilder
{

    public function build(BuilderInterface $builder, array $options = array())
    {
        $builder->addNamed('logo_ppal', 'image', array(
            'bind' => array(
                'click' => 'get_gallery_ppal'
            ),
        ));
        $builder->addNamed('ppal', 'image', array(
            'bind' => array(
                'click' => 'get_gallery_theme'
            ),
        ));
        $builder->add('singleline', array(
            'bind' => array(
                'click' => 'mi_function'
            ),
        ));

        $builder->addNamed('loop', 'singleline');

        $builder->add('multiline');

        $builder->addNamed('singleline', 'loop', array(
            'type' => 'singleline',
            'children_options' => array(
                'bind' => array(
                    'click' => 'HOLA'
                ),
            ),
            'bind' => array(
                'click' => 'show_data'
            ),
        ));
    }

    public function getLayout()
    {
        return 'OptimeCommtoolBundle::campaign_layout.html.twig';
    }

}
