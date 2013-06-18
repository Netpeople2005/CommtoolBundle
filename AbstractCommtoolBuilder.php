<?php

namespace Optime\Bundle\CommtoolBundle;

use Optime\Bundle\CommtoolBundle\CommtoolBuilderInterface;

abstract class AbstractCommtoolBuilder implements CommtoolBuilderInterface
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
        foreach ($this->getControls() as $index => $control) {
            $values[$control->getIdentifier()] = $control->getValue();
//            $values[$index] = $control->getValue();
        }

        return $values;
    }

    public function setValues($data)
    {
        foreach ($this->getControls() as $index => $control) {
            $id = $control->getIdentifier();
            if (isset($data[$id])) {
                $control->setValue($data[$id]);
            }
        }
    }

}