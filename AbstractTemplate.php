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
        foreach ($controls as $control) {
            $this->controls[$control->getIdentifier()] = $control;
        }
    }

    public function getValues()
    {
        $values = array();
        
        foreach ($this->getControls() as $control) {
            $values[$control->getIdentifier()] = $control->getValue();
        }

        return $values;
    }

    public function setValues($data)
    {
        foreach ($this->getControls() as $identifier => $control) {
            if (isset($data[$identifier])) {
                $control->setValue($data[$identifier]);
            }
        }
    }

}