<?php

namespace Optime\Bundle\CommtoolBundle\Builder;

use Optime\Bundle\CommtoolBundle\SectionFactory;
use Optime\Bundle\CommtoolBundle\Builder\BuilderInterface;
use Optime\Bundle\CommtoolBundle\Section\SectionInterface;

class Builder implements BuilderInterface
{

    protected $sections = array();

    public function add($name, array $options = array())
    {
        if (is_object($name) && $name instanceof SectionInterface) {
            $this->sections[$name->getName()] = $options;
        } elseif (is_string($name)) {
            $this->sections[$name] = $options;
        } else {
            throw new \Exception("No se reconoce el valor " . (string) $name);
        }
    }

    public function getNames()
    {
        return array_keys($this->getSections());
    }

    public function getSections()
    {
        return $this->sections;
    }

}