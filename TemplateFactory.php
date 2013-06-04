<?php

namespace Optime\Bundle\CommtoolBundle;

use Optime\Bundle\CommtoolBundle\Template;
use Optime\Bundle\CommtoolBundle\SectionFactory;
use Optime\Bundle\CommtoolBundle\Reader\ReaderInterface;

class TemplateFactory
{

    /**
     *
     * @var ReaderInterface 
     */
    protected $reader;

    /**
     *
     * @var SectionFactory
     */
    protected $sectionFactory;

    function __construct(ReaderInterface $reader, SectionFactory $sectionFactory)
    {
        $this->reader = $reader;
        $this->sectionFactory = $sectionFactory;
    }

    public function create($name, $content, array $options = array())
    {
        $section = $this->sectionFactory->create($name, $content);
        
        $template = new Template();
        $template->setSectionNames(array('singleline'));
        
        $this->reader->setTemplate($template);
        
        var_dump($this->reader->getSections($content));
//
//        $template->setSections($this->builder->getSections());

        $reader = $this->reader;

        $reader->setTemplate($template);

        $reader->getSections($content);

//        $template->setSectionNames($this->builder->getNames());
//        return $template;
    }

}