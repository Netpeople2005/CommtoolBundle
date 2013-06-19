<?php

namespace Optime\Bundle\CommtoolBundle\Control;

use Optime\Bundle\CommtoolBundle\Control\ControlInterface;
use Optime\Bundle\CommtoolBundle\Control\View\ViewInterface;

abstract class AbstractControl implements ControlInterface
{

    /**
     *
     * @var $value
     */
    protected $value;

    /**
     *
     * @var string
     */
    protected $index;

    /**
     *
     * @var string
     */
    protected $identifier;

    /**
     *
     * @var array
     */
    protected $children = array();

    /**
     *
     * @var ControlInterface
     */
    protected $parent;

    /**
     *
     * @var array
     */
    protected $options = array();

    public function getDefaultValue()
    {
        return null;
    }

    public function getValue()
    {
        if (count($this->children)) {
            $value = array();
            foreach ($this->children as $index => $control) {
                $id = $control->getIdentifier();
//                $value[$index] = $control->getValue();
                $value[$id] = $control->getValue();
            }

            return $value;
        } else {
            return $this->value;
        }
    }

    public function getIndex()
    {
        return $this->index;
    }

    public function setIndex($index)
    {
        $this->index = $index;
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
        if (is_array($value)) {
            foreach ($this->children as $index => $control) {
                $id = $control->getIdentifier();
                if (!$control->isReadOnly() and isset($value[$id])) {
                    $control->setValue($value[$id]);
                }
            }
        }
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function setChildren(array $children)
    {
        $this->children = $children;
    }

    public function getSelector($useParent = true)
    {

        if ($useParent && $this->getParent()) {
            $selector = $this->getParent()->getSelector() . ' .' . $this->getName();
        } else {
            $selector = '.' . $this->getName();
        }

        return $selector;
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

    public function createView(ViewInterface $parent = null)
    {
        $view = new View\ControlView($this, $parent);

        foreach ($this->getChildren() as $control) {
            $control->createView($view);
        }

        return $view;
    }

    public function isReadOnly()
    {
        return isset($this->options['readonly']) ? $this->options['readonly'] : false;
    }

}
