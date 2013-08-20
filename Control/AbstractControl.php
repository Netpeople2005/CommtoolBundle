<?php

namespace Optime\Bundle\CommtoolBundle\Control;

use Optime\Bundle\CommtoolBundle\Control\ControlInterface;
use Optime\Bundle\CommtoolBundle\Control\View\ViewInterface;

abstract class AbstractControl implements ControlInterface
{

    protected $sectionId;

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

    public function getSectionId()
    {
        return $this->sectionId;
    }

    public function setSectionId($sectionId)
    {
        $this->sectionId = $sectionId;
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

            return array('value' => $value);
//            return $value;
        } else {
            return array('value' => $this->value);
//            return $this->value;
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
            if (count($this->children)) {
                foreach ($this->children as $index => $control) {
                    $id = $control->getIdentifier();
                    if (!$control->isReadOnly() and isset($value[$id])) {
//                        var_dump($value[$id]);
                        $control->setValue($value[$id]);
                    }
                }
            } else {
                if (array_key_exists($this->getIdentifier(), $value)) {
                    $this->value = $value[$this->getIdentifier()];
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

    public function getCompleteType($useName = false)
    {
        if ($this->getParent()) {
            return $this->getParent()->getCompleteType() . '_' . $this->getName();
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

    public function setParent(ControlInterface $parent = null)
    {
        $this->parent = $parent;
    }

    public function isReadOnly()
    {
        return isset($this->options['readonly']) ? $this->options['readonly'] : false;
    }

    public function getName()
    {
        if (isset($this->options['filter_name'])) {
            return $this->options['filter_name'] . '_' . $this->getType();
        } else {
            return $this->getType();
        }
    }

}
