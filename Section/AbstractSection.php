<?php

namespace Optime\Bundle\CommtoolBundle\Section;

use Optime\Bundle\CommtoolBundle\Section\SectionInterface;

abstract class AbstractSection implements SectionInterface
{

    protected $value;
    protected $identifier;
    protected $children = array();
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

    public function replaceContent($content, \Optime\Bundle\CommtoolBundle\Writer\WriterInterface $writer)
    {
        $writer->replace($content, $this);

        foreach ($this->children as $section) {
            $writer->replace($content, $section);
        }
    }

    public function getSelector()
    {
        if (null === $this->getOptions('no_selector')) {
            return $this->getName();
        } else {
            return false;
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

}
