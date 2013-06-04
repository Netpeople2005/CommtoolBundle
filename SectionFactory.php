<?php

namespace Optime\Bundle\CommtoolBundle;

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

        //$section->build($builder);

        return $section;
    }

    /**
     * 
     * @param \Optime\Bundle\CommtoolBundle\Section\SectionInterface|string $name
     * @return \Optime\Bundle\CommtoolBundle\Section\SectionInterface
     */
    protected function resolveSection($name)
    {
        if (is_object($name) && $name instanceof SectionInterface) {
            return $name;
        } elseif (is_string($name)) {
            return $this->container->get("commtool.section.{$name}");
        }

        throw new \Exception("No se reconoce el valor ", (string) $name);
    }

}
