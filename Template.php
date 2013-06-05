<?php

namespace Optime\Bundle\CommtoolBundle;

use Optime\Bundle\CommtoolBundle\TemplateInterface;
use Optime\Bundle\CommtoolBundle\Section\SectionInterface;

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

    public function addSection(SectionInterface $section)
    {
        $this->sections[] = $section;
    }

    public function setSections(array $sections)
    {
        $this->sections = $sections;
    }

}