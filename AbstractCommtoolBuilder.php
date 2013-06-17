<?php

namespace Optime\Bundle\CommtoolBundle;

use Optime\Bundle\CommtoolBundle\CommtoolBuilderInterface;
use Optime\Bundle\CommtoolBundle\Control\ControlLoopInterface;

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

        foreach ($this->getControls() as $type => $controls) {
            foreach ($controls as $index => $control) {
                if ($control instanceof ControlLoopInterface) {
                    $values[$type] = $control->getValue();
                } else {
                    $values[$type][$index] = $control->getValue();
                }
            }
        }

        return $values;
    }

    public function setValues($data)
    {
        foreach ($this->getControls() as $type => $controls) {
            foreach ($controls as $index => $control) {
                if ($control instanceof ControlLoopInterface) {
                    if (isset($data[$type])) {
                        $control->setValue($data[$type]);
                    }
                } else {
                    if (isset($data[$type][$index])) {
                        $control->setValue($data[$type][$index]);
                    }
                }
            }
        }
    }

}