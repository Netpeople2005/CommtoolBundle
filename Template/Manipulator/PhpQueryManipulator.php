<?php

namespace Optime\Bundle\CommtoolBundle\Template\Manipulator;

use Optime\Bundle\CommtoolBundle\ControlFactory;
use Optime\Bundle\CommtoolBundle\Builder\BuilderInterface;
use Optime\Bundle\CommtoolBundle\Control\ControlInterface;
use Optime\Bundle\CommtoolBundle\Template\Manipulator\TemplateManipulatorInterface;

class PhpQueryManipulator implements TemplateManipulatorInterface
{

    /**
     * 
     * @var ControlFactory
     */
    protected $factory;

    /**
     *
     * @var \phpQueryObject
     */
    protected $phpQueryCont;

    public function __construct(ControlFactory $factory)
    {
        $this->factory = $factory;
    }

    public function createControls(BuilderInterface $builder, ControlInterface $parent = null)
    {
        $controls = array();

        if ($parent) {
            $phpQuery = \phpQuery::newDocument($parent->getValue());
        } else {
            $phpQuery = $this->phpQueryCont;
        }
        foreach ($builder->getPrototypes() as $prototype) {
            $items = $phpQuery['.' . $prototype->getSelector()];
            foreach ($items as $el) {
                $el = pq($el);
                $control = $this->factory->create($prototype->getName()
                        , $el->html(), $prototype->getOptions());
                var_dump($el->attr('data-section-id'));
                $control->setIdentifier($el->attr('data-section-id'));
                $controls[] = $control;
            }
        }

        $builder->setControls($controls);
    }

    public function exists(\Optime\Bundle\CommtoolBundle\Control\ControlInterface $section)
    {
        
    }

    public function getContent()
    {
        return $this->phpQueryCont->htmlOuter();
    }

    public function load(\Optime\Bundle\CommtoolBundle\Control\ControlInterface $section)
    {
        
    }

    public function save(\Optime\Bundle\CommtoolBundle\Control\ControlInterface $section)
    {
        
    }

    public function setContent($content)
    {
        $this->phpQueryCont = \phpQuery::newDocument($content);
    }

}
