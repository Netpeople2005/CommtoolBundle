<?php

namespace Optime\Bundle\CommtoolBundle;

use Optime\Bundle\CommtoolBundle\TemplateInterface;

class Template implements TemplateInterface
{

    protected $content;
    protected $sections = array();

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

    public function getValues()
    {
        return $this->value;
    }

    public function setValues($data)
    {
        foreach ($this->getSections() as $section) {
            if (isset($data[$section->getIdentifier()])) {
                $section->setValue($data[$section->getIdentifier()]);
            }
        }
    }

}