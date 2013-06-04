<?php

namespace Optime\Bundle\CommtoolBundle;

use Optime\Bundle\CommtoolBundle\TemplateInterface;

class Template implements TemplateInterface
{

    protected $content;

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getSectionNames()
    {
        return array('singleline');
    }

    public function getSections()
    {
        
    }

}