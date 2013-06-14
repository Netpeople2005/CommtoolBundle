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
        if (is_array($value)) {
            foreach ($this->children as $type => $controls) {
                foreach ($controls as $index => $control) {
                    if (isset($value[$index])) {
                        $control->setValue($value[$index]);
                    }
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

        if ($this->getParent()) {
            $parent = $this->getParent();
            if ($useParent) {
                $selector = $parent->getSelector() . ' .' . $parent->getName() . '_' . $this->getName();
            } else {
                $selector = '.' . $parent->getName() . '_' . $this->getName();
            }
        } else {
            $selector = '.' . $this->getName();
        }

//        if (null !== $this->getIdentifier()) {
//            $selector .= "[data-section-id={$this->getIdentifier()}]";
//        }

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

}
