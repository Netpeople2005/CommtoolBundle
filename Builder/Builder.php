<?php

namespace Optime\Bundle\CommtoolBundle\Builder;

use Optime\Bundle\CommtoolBundle\Builder\BuilderInterface;
use Optime\Bundle\CommtoolBundle\Section\SectionInterface;

class Builder implements BuilderInterface
{

    protected $sections = array();
    protected $names = array();

    /**
     *
     * @var SectionInterface
     */
    protected $current;

    function __construct(SectionInterface $current)
    {
        $this->current = $current;
    }

    public function add($name, array $options = array())
    {
        if (is_object($name) && $name instanceof SectionInterface) {
            $this->names[] = array($name->getName(), $options);
        } elseif (is_string($name)) {
            $this->names[] = array($name, $options);
        } else {
            throw new \Exception("No se reconoce el valor " . (string) $name);
        }

        return $this;
    }

    public function getNames()
    {
        return $this->names;
    }

    public function getSections()
    {
        return $this->sections;
    }

    /**
     * 
     * @return SectionInterface
     */
    public function getSection()
    {
        return $this->current;
    }

    public function setSections(array $sections)
    {
        $this->sections = $sections;
    }

}