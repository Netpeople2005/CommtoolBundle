<?php

namespace Optime\Bundle\CommtoolBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class ControlPass implements CompilerPassInterface
{

    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('commtool_control_factory');

        $sections = array();

        foreach ($container->findTaggedServiceIds('commtool.control.type') as $serviceId => $tag) {
            if (!isset($tag[0]['alias'])) {
                throw new \Exception("Debe definir un alias para el tag del servicio $serviceId");
            }
            $sections[$tag[0]['alias']] = $serviceId;
        }
        
        $definition->replaceArgument(0, $sections);
    }

}
