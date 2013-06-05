<?php

namespace Optime\Bundle\CommtoolBundle\Builder;

use Optime\Bundle\CommtoolBundle\SectionFactory;
use Optime\Bundle\CommtoolBundle\Builder\BuilderInterface;

class Builder implements BuilderInterface
{

    protected $sections = array();
    protected $names = array();

    /**
     *
     * @var SectionFactory
     */
    protected $factory;

    function __construct(SectionFactory $factory)
    {
        $this->factory = $factory;
    }

    public function add($name, array $options = array())
    {
        $section = $this->factory->resolveSection($name);
        $this->sections[$section->getIdentifier()] = $section;
        $this->names[$section->getName()] = $section->getName();
    }

    public function getNames()
    {
        return $this->names;
    }

    public function getSections()
    {
        return $this->sections;
    }
}