<?php

namespace Optime\Bundle\CommtoolBundle\Section;

use Optime\Bundle\CommtoolBundle\Section\SectionInterface;

abstract class AbstractSection implements SectionInterface
{

    protected $value;
    protected $identifier;
    protected $children = array();

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

}
