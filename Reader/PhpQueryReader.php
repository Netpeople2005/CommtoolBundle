<?php

namespace Optime\Bundle\CommtoolBundle\Reader;

use Optime\Bundle\CommtoolBundle\SectionFactory;
use Optime\Bundle\CommtoolBundle\Reader\ReaderInterface;
use Optime\Bundle\CommtoolBundle\Builder\BuilderInterface;
use Optime\Bundle\CommtoolBundle\Section\SectionInterface;

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

        $builderSections = $builder->getSections();

        $templateSections = array();


        foreach ($builder->getNames() as $name) {
            foreach ($doc[".{$name}." . self::SELECTOR_ELEMENT] as $id => $el) {
                $el = pq($el);
                var_dump($el->parent('.' . self::SELECTOR_ELEMENT)->size());//->attr('class'));
                if ($el->parent('.' . self::SELECTOR_ELEMENT)->not('.' . $builder->getSection()->getName())->size() === 0) {
                    $section = $this->sectionFactory->create($name, trim($el->html()), $builderSections[$name]);
                    $section->setIdentifier($el->attr('data-section-id'));
                    $templateSections[] = $section;
                }
            }
        }

        return $templateSections;
    }

    /**
     * 
     * @param \Optime\Bundle\CommtoolBundle\Section\SectionInterface $section
     * @return string
     */
    public function find(SectionInterface $section, $content)
    {
        $doc = \phpQuery::newDocument($content);

        if ($section->getIdentifier()) {
            return $doc[".{$section->getName()}[data-section-id={$section->getIdentifier()}]"]->html();
        } else {
            return $doc[".{$section->getName()}"]->html();
        }
    }

}