<?php

namespace Optime\Bundle\CommtoolBundle\Template\Manipulator;

use Optime\Bundle\CommtoolBundle\SectionFactory;
use Optime\Bundle\CommtoolBundle\Builder\BuilderInterface;
use Optime\Bundle\CommtoolBundle\Template\Manipulator\TemplateManipulatorInterface;

class PhpQueryManipulator implements TemplateManipulatorInterface
{

    /**
     * 
     * @var SectionFactory
     */
    protected $factory;

    /**
     *
     * @var \phpQueryObject
     */
    protected $phpQueryCont;

    public function __construct(SectionFactory $factory)
    {
        $this->factory = $factory;
    }

    public function createSections(BuilderInterface $builder)
    {
        $templateSections = array();
        var_dump($builder->getNames());
        foreach ($builder->getNames() as $name) {
            foreach ($this->phpQueryCont[".{$name}." . self::SELECTOR_ELEMENT] as $id => $el) {
                $el = pq($el);
                if ($el->parent('.' . self::SELECTOR_ELEMENT)
                                ->not('.' . $builder->getSection()->getName())->size() === 0) {
                    $templateSections[] = array(
                        'id' => $el->attr('data-section-id'),
                        'name' => $name,
                        'content' => trim($el->html()),
                    );
                }
            }
        }

        $builder->setSections($templateSections);
    }

    public function exists(\Optime\Bundle\CommtoolBundle\Section\SectionInterface $section)
    {
        
    }

    public function getContent()
    {
        return $this->phpQueryCont->htmlOuter();
    }

    public function load(\Optime\Bundle\CommtoolBundle\Section\SectionInterface $section)
    {
        
    }

    public function save(\Optime\Bundle\CommtoolBundle\Section\SectionInterface $section)
    {
        
    }

    public function setContent($content)
    {
        $this->phpQueryCont = \phpQuery::newDocument($content);
    }

}
