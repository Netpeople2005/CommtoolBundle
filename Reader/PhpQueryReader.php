<?php

namespace Optime\Bundle\CommtoolBundle\Reader;

use Optime\Bundle\CommtoolBundle\SectionFactory;
use Optime\Bundle\CommtoolBundle\TemplateInterface;
use Optime\Bundle\CommtoolBundle\Reader\ReaderInterface;

class PhpQueryReader implements ReaderInterface
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

    public function getSections($content, array $names)
    {
        $doc = \phpQuery::newDocument($content); //obtengo la instancia del phpQuery para el html
        
        \phpQuery::selectDocument($doc);

        $templateSections = array();
        foreach ($names as $name) {
            $sections = $doc[".{$name}"]->filter(function($el)use($name){
                        var_dump(pq($el)->html(), pq($el)->parent()->html());
                return pq($el)->parent(".{$name}")->size() === 0;
            });
            foreach ($sections as $el) {
                $section = $this->sectionFactory->create($name, pq($el)->html());
                $section->setIdentifier(pq($el)->attr('data-section-id'));
                $templateSections[] = $section;
            }
        }

        return $templateSections;
    }

}