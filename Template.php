<?php

namespace Optime\Bundle\CommtoolBundle;

use Optime\Bundle\CommtoolBundle\TemplateInterface;
use Optime\Bundle\CommtoolBundle\Section\SectionInterface;

class Template implements TemplateInterface
{

    protected $content;
    protected $sections = array();
    protected $value;

    function __construct($content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getSections()
    {
        return $this->sections;
    }

    public function setSections(array $sections)
    {
        $this->sections = $sections;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;

        foreach ($this->sections as $section) {
            $section->setValue($value);
        }
    }

}