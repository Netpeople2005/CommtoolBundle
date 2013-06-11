<?php

namespace Optime\Bundle\CommtoolBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Optime\Bundle\CommtoolBundle\DependencyInjection\Compiler\ControlPass;

class OptimeCommtoolBundle extends Bundle
{

    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ControlPass());
    }

}
