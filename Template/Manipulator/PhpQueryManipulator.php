<?php

namespace Optime\Bundle\CommtoolBundle\Template\Manipulator;

use Optime\Bundle\CommtoolBundle\ControlFactory;
use Optime\Bundle\CommtoolBundle\TemplateInterface;
use Optime\Bundle\CommtoolBundle\Builder\BuilderInterface;
use Optime\Bundle\CommtoolBundle\Control\ControlInterface;
use Optime\Bundle\CommtoolBundle\Control\ControlLoopInterface;
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
            $phpQuery = $this->phpQueryCont[$parent->getSelector()];
        } else {
            $phpQuery = $this->phpQueryCont;
        }

        foreach ($builder->getPrototypes() as $prototype) {
            $items = $phpQuery[$prototype->getSelector(false)];
            foreach ($items as $index => $el) {
                $el = pq($el);
                $control = $this->factory->createFromPrototype($prototype, $el, $prototype->getOptions());
                if ($el->attr('data-section-id')) {
                    $id = $el->attr('data-section-id');
                } else {
                    $id = $prototype->getName() . '_' . $index;
                    $el->attr('data-section-id', $id);
                }
                $control->setIdentifier($id);
                if ($prototype->getParent()) {
                    $control->setParent($prototype->getParent());
                }
                $controls[$id] = $control;
            }
        }

        $builder->setControls($controls);
    }

    public function exists(ControlInterface $section)
    {
        
    }

    public function getContent()
    {
        return $this->phpQueryCont->htmlOuter();
    }

    public function load(TemplateInterface $template)
    {
        
    }

    public function save(TemplateInterface $template)
    {
        $content = \phpQuery::newDocument($template->getContent());
        foreach ($template->getControls() as $control) {
            $this->saveControl($control, $content);
        }
        $template->setContent((string) $content);
    }

    public function setContent($content)
    {
        $this->phpQueryCont = \phpQuery::newDocument($content);
    }

    public function saveControl(ControlInterface $control, &$content)
    {
        $context = $content[$control->getSelector(false)];

        if ($control instanceof ControlLoopInterface) {

            $newContent = \phpQuery::newDocument('');
            $selector = $control->getPrototype()->getSelector(false);

            foreach ($control->getValue() as $index => $val) {
                $clone = pq($context->htmlOuter());
                $prototype = clone $control->getPrototype();
                $prototype->setValue($val);
                $clone[$prototype->getSelector(false)]->attr('data-section-id', $index);
                $this->saveControl($prototype, $clone);
                $newContent->append($clone->html());
            }

            $context->html($newContent);
        } else {

            if (count($control->getChildren())) {
                foreach ($control->getChildren() as $child) {
                    $this->saveControl($child, $context);
                }
            } else {
                $context->html($control->getValue());
            }
        }
    }

}
