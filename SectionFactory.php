<?php

namespace Optime\Bundle\CommtoolBundle;

use Optime\Bundle\CommtoolBundle\Builder\Builder;
use Symfony\Component\DependencyInjection\ContainerAware;
use Optime\Bundle\CommtoolBundle\Section\SectionInterface;

class SectionFactory extends ContainerAware
{

    /**
     * 
     * @param type $name
     * @param type $content
     * @param array $options
     * @return SectionInterface
     */
    public function create($name, $content, array $options = array())
    {
        $section = $this->resolveSection($name);

        $section->setValue($content);
        
        $builder = new Builder($this);

        $section->build($builder, $options);

        return $section;
    }

    /**
     * 
     * @param \Optime\Bundle\CommtoolBundle\Section\SectionInterface|string $name
     * @return \Optime\Bundle\CommtoolBundle\Section\SectionInterface
     */
    public function resolveSection($name)
    {
        if (is_object($name) && $name instanceof SectionInterface) {
            return $name;
        } elseif (is_string($name)) {
            return $this->container->get("commtool.section.{$name}");
        }

        throw new \Exception("No se reconoce el valor ", (string) $name);
    }

}
