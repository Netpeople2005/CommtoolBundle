<?php

namespace Optime\Bundle\CommtoolBundle;

use Optime\Bundle\CommtoolBundle\AbstractCommtoolBuilder;
use Optime\Bundle\CommtoolBundle\Builder\BuilderInterface;
use Optime\Commtool\TemplateBundle\Model\SectionConfigInterface;

class CampaignCommtool extends AbstractCommtoolBuilder
{

    public function build(BuilderInterface $builder, array $options = array())
    {
        $builder->add('image', array(
            'data' => '/commtool/web/bundles/commtooltemplate/images/template_09.jpg'
        ));
        $builder->add('singleline', array(
            'data' => function(SectionConfigInterface $section, $value) {
                return 'Hola Mundo';
            },
        ));
        $builder->add('product');
        $builder->add('loop', array(
            'type' => 'image',
            'selector' => 'sin',
        ));
//        $builder->add('loop', array(
//            'type' => 'product',
//            'selector' => 'pro',
//        ));
    }

}
