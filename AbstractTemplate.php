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

    public function setControls(array $controls)
    {
        $this->controls = $controls;
    }

    public function getValues()
    {
        $values = array();

        foreach ($this->getControls() as $type => $controls) {
            foreach ($controls as $index => $control) {
                $values[$type][$index] = $control->getValue();
            }
        }

        return $values;
    }

    public function setValues($data)
    {
        foreach ($this->getControls() as $type => $controls) {
            foreach ($controls as $index => $control) {
                if (isset($data[$type][$index])) {
                    $control->setValue($data[$type][$index]);
                }
            }
        }
    }

}