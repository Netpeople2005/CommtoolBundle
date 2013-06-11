<?php

namespace Optime\Bundle\CommtoolBundle;

use Optime\Bundle\CommtoolBundle\TemplateInterface;

abstract class AbstractTemplate implements TemplateInterface
{

    protected $content;
    protected $controls = array();

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getControls()
    {
        return $this->controls;
    }

    public function setControls(array $sections)
    {
        $this->controls = $sections;
    }

    public function getValues()
    {
        return $this->value;
    }

    public function setValues($data)
    {
//        foreach ($this->getControls() as $section) {
//            if (isset($data[$section->getIdentifier()])) {
//                $section->setValue($data[$section->getIdentifier()]);
//            }
//        }
    }

}