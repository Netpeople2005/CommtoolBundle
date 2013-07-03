<?php

namespace Optime\Bundle\CommtoolBundle\Control\View;

use Optime\Bundle\CommtoolBundle\Control\ControlInterface;
use Optime\Bundle\CommtoolBundle\Control\View\ViewInterface;

class ControlView implements ViewInterface
{

    public $vars;

    function __construct(ControlInterface $control, ViewInterface $parent = null)
    {
        $this->vars = $control->getOptions();

        $this->vars['type'] = $control->getName();
        $this->vars['selector'] = $control->getCompleteType();
        $this->vars['parent'] = $parent;
        $this->vars['children'] = array();

        if ($parent) {
            $parent->addChild($this);
            $this->vars['id'] = $parent->getId() . '._' . $control->getIdentifier();
        } else {
            $this->vars['id'] = '_' . $control->getIdentifier();
        }

        if (is_string($control->getValue())) {
            $this->vars['value'] = $control->getValue();
            $this->vars['is_input'] = true;
        } else {
            $this->vars['value'] = null;
            $this->vars['is_input'] = false;
        }
    }

    public function addChild(ViewInterface $view)
    {
        array_push($this->vars['children'], $view);
    }

    public function getId()
    {
        return $this->vars['id'];
    }

}
