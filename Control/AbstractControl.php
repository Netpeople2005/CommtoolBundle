<?php

namespace Optime\Bundle\CommtoolBundle\Control;

use Optime\Bundle\CommtoolBundle\Control\ControlInterface;

abstract class AbstractControl implements ControlInterface
{

    protected $value;
    protected $identifier;
    protected $children = array();
    protected $content;

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
        if (is_array($value)) {
            foreach ($this->children as $control) {
                if (isset($value[$control->getIdentifier()])) {
                    $control->setValue($value[$control->getIdentifier()]);
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

        if (null !== $this->getIdentifier()) {
            $selector .= "[data-section-id={$this->getIdentifier()}]";
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

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

}
