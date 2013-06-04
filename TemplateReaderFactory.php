<?php

namespace Optime\Bundle\CommtoolBundle;

use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class TemplateReaderFactory
{

    public function get2($type = 'phpquery')
    {
        return $this->get('commtool_reader_phpquery');
        return $this->get('commtool_reader_' . $type);
    }

    public static function get(ContainerInterface $container, $type = 'phpquery')
    {
        return $container->get('commtool_reader_' . $type);
    }

}