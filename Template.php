<?php

namespace Optime\Bundle\CommtoolBundle;

use Optime\Bundle\CommtoolBundle\TemplateInterface;
use Optime\Bundle\CommtoolBundle\Section\SectionInterface;

class Template implements TemplateInterface
{

    protected $content;
    protected $sections = array();

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
        return $this->sections;
    }

    public function addSection(SectionInterface $section)
    {
        $this->sections[] = $section;
    }

    public function setSections(array $sections)
    {
        
    }

    public function setSectionNames(array $names)
    {
        
    }

}