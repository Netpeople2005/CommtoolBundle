<?php

namespace Optime\Bundle\CommtoolBundle;

use Optime\Bundle\CommtoolBundle\Template;
use Optime\Bundle\CommtoolBundle\SectionFactory;

class TemplateFactory
{

    /**
     *
     * @var SectionFactory
     */
    protected $sectionFactory;

    function __construct(SectionFactory $sectionFactory)
    {
        $this->sectionFactory = $sectionFactory;
    }

    public function create($name, $content, array $options = array())
    {
        $section = $this->sectionFactory->create($name, $content, $options);

        $template = new Template($content);
        
        $template->setSections($section->getChildren());

        return $template;
    }

}