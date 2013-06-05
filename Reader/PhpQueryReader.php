<?php

namespace Optime\Bundle\CommtoolBundle\Reader;

use Optime\Bundle\CommtoolBundle\SectionFactory;
use Optime\Bundle\CommtoolBundle\Reader\ReaderInterface;
use Optime\Bundle\CommtoolBundle\Builder\BuilderInterface;

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

    public function getSections($content, BuilderInterface $builder)
    {
        $doc = \phpQuery::newDocument($content); //obtengo la instancia del phpQuery para el html

        $templateSections = array();

        $builderSections = $builder->getSections();

        $templateSections = array();

        foreach ($builder->getNames() as $name) {
            foreach ($doc[".{$name}"] as $id => $el) {
                if (pq($el)->parent(".{$name}")->size() === 0) {
                    $el = pq($el);
                    $section = $this->sectionFactory->create($name, $el->html(), $builderSections[$name]);
                    $section->setIdentifier($el->attr('data-section-id'));
                    $templateSections[] = $section;
                }
            }
        }

        return $templateSections;
    }

}