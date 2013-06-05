<?php

namespace Optime\Bundle\CommtoolBundle;

use Optime\Bundle\CommtoolBundle\Template;
use Optime\Bundle\CommtoolBundle\SectionFactory;
use Optime\Bundle\CommtoolBundle\Writer\WriterInterface;

class TemplateFactory
{

    /**
     *
     * @var SectionFactory
     */
    protected $sectionFactory;

    /**
     *
     * @var WriterInterface
     */
    protected $writer;

    function __construct(SectionFactory $sectionFactory)
    {
        $this->sectionFactory = $sectionFactory;
    }

    public function create($name, $content, array $options = array())
    {
        $manipulator = $this->sectionFactory->getManipulator();
        
        $manipulator->setContent($content);

        $section = $this->sectionFactory->create($name, $content, $options);

        $template = new Template($manipulator->getContent());

        $template->setSections($section->getChildren());

        return $template;
    }

}