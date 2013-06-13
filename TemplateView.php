<?php

namespace Optime\Bundle\CommtoolBundle;

class TemplateView
{

    protected $content;
    protected $controls = array();

    public function __construct($content, array $controls)
    {
        $this->content = $content;
        $this->controls = $controls;
    }

    public function getContent()
    {
        return $this->content;
    }
    
    public function getControls()
    {
        return $this->controls;
    }

}
