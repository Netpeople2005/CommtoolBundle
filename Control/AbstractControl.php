<?php

namespace Optime\Bundle\CommtoolBundle\Control;

use Optime\Bundle\CommtoolBundle\Control\ControlInterface;

abstract class AbstractControl implements ControlInterface
{

    protected $value;
    protected $identifier;
    protected $children = array();

    /**
     *
     * @var ControlInterface
     */
    protected $parent;
    protected $options = array();

    public function getDefaultValue()
    {
        return null;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function setChildren(array $children)
    {
        $this->children = $children;
    }

    public function getSelector()
    {
        if ($this->getParent()) {
            return $this->getParent()->getName() . '_' . $this->getName();
        } else {
            return $this->getName();
        }
    }

    public function getOptions($name = null)
    {
        if (null !== $name) {
            return isset($this->options[$name]) ? $this->options[$name] : null;
        } else {
            return $this->options;
        }
    }

    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setParent(ControlInterface $parent)
    {
        $this->parent = $parent;
    }

}
