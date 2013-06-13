<?php

namespace Optime\Bundle\CommtoolBundle\Builder;

use Optime\Bundle\CommtoolBundle\ControlFactory;
use Optime\Bundle\CommtoolBundle\Builder\BuilderInterface;
use Optime\Bundle\CommtoolBundle\Control\ControlInterface;

class Builder implements BuilderInterface
{

    protected $controls = array();
    protected $prototypes = array();
    protected $sections = array();

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
        $prototype = $this->factory->create($sectionName, null, $options);

        if (isset($this->prototypes[$prototype->getSelector()])) {
            throw new \Exception("No se puede agregar más de una sección que use el mismo selector");
        }

        $prototype->setOptions($options);

        $this->prototypes[$prototype->getSelector()] = $prototype;

        $this->sections[$prototype->getSelector()] = $prototype->getSelector();

        if ($this->parent) {
            $prototype->setParent($this->parent);
        }

        return $this;
    }

    public function getControls()
    {
        return $this->controls;
    }

    /**
     * 
     * @return ControlInterface
     */
    public function getControl()
    {
        return $this->parent;
    }

    public function setControls(array $sections)
    {
        $this->controls = $sections;
    }

    public function getSections()
    {
        return $this->sections;
    }

    public function getPrototypes()
    {
        return $this->prototypes;
    }

    public function getValues()
    {
        $values = array();

        foreach ($this->getControls() as $index => $control) {
            if (null !== $control->getIdentifier()) {
                $values[$control->getIdentifier()] = $control->getValue();
            } else {
                $values[] = $control->getValue();
            }
        }

        return $values;
    }

}