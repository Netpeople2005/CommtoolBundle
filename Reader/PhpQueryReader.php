<?php

namespace Optime\Bundle\CommtoolBundle\Reader;

use Optime\Bundle\CommtoolBundle\SectionFactory;
use Optime\Bundle\CommtoolBundle\TemplateInterface;
use Optime\Bundle\CommtoolBundle\Reader\ReaderInterface;

class PhpQueryReader implements ReaderInterface
{

    protected $template;

    /**
     *
     * @var SectionFactory
     */
    protected $sectionFactory;

    function __construct(SectionFactory $sectionFactory)
    {
        $this->sectionFactory = $sectionFactory;
    }

    public function getSections($content)
    {
        $doc = \phpQuery::newDocument($content); //obtengo la instancia del phpQuery para el html
        //ahora buscamos las secciones
        $sections = (array) $this->template->getSectionNames();

        $templateSections = array();
        
        $factory = $this->sectionFactory;
        
        foreach ($sections as $name) {
            $doc[".{$name}"]->each(function($s)use(&$templateSections, $name, $factory) {
                        $section = $factory->create($name, pq($s)->html());
                        $section->setIdentifier(pq($s)->attr('data-section-id'));
                        $templateSections[] = $section;
                    });
        }

        return $templateSections;
    }

    public function getTemplate()
    {
        return $this->template;
    }

    public function setTemplate(TemplateInterface $template)
    {
        $this->template = $template;
    }

    protected function resolveSection($type, $identifier, $value)
    {
        
    }

}