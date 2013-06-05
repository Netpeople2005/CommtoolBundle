<?php

namespace Optime\Bundle\CommtoolBundle;

use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class TemplateManipulatorFactory
{

    public static function get(ContainerInterface $container, $type = 'phpquery')
    {
        return $container->get('commtool_manipulator_' . $type);
    }

}