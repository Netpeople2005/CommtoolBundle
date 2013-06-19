<?php

namespace Optime\Bundle\CommtoolBundle\Builder;

use Optime\Bundle\CommtoolBundle\ControlFactory;
use Optime\Bundle\CommtoolBundle\Builder\BuilderInterface;
use Optime\Bundle\CommtoolBundle\Control\ControlInterface;
use Optime\Bundle\CommtoolBundle\Control\ControlLoopInterface;

class Builder implements BuilderInterface
{

    protected $prototypes = array();

    /**
     *
     * @var ControlFactory
     */
    protected $factory;

    /**
     *
     * @var ControlInterface
     */
    protected $parent;

    function __construct(ControlFactory $factory, ControlInterface $parent = null)
    {
        $this->factory = $factory;
        $this->parent = $parent;
    }

    public function add($sectionName, array $options = array())
    {
        $prototype = $this->factory->create($sectionName, $options);

        if (isset($this->prototypes[$prototype->getSelector()])) {
            throw new \Exception("No se puede agregar más de una sección que use el mismo selector");
        }

        $prototype->setOptions($options);

        $this->prototypes[$prototype->getName()] = $prototype;

        if ($this->parent) {
            $prototype->setParent($this->parent);
        }

        return $this;
    }

    /**
     * 
     * @return ControlInterface
     */
    public function getControl()
    {
        return $this->parent;
    }

    public function getPrototypes()
    {
        return $this->prototypes;
    }

}