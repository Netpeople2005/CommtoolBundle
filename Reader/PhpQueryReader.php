<?php

namespace Optime\Bundle\CommtoolBundle\Reader;

use Optime\Bundle\CommtoolBundle\SectionFactory;
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

        $templateSections = array();
        foreach ($names as $name) {
            foreach ($doc[".{$name}"] as $id => $el) {
//                if (pq($el)->parent(".{$name}")->size() === 0) {
//                $el = pq($el);
                $section = $this->sectionFactory->create($name, 'HOLAAAAAAAAAA' . $id);
//                $section->setIdentifier($el->attr('data-section-id'));
                $templateSections[] = $section;
//                unset($section);
//                }
            }
        }

        return $templateSections;
    }

}