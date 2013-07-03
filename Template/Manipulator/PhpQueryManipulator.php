<?php

namespace Optime\Bundle\CommtoolBundle\Template\Manipulator;

use Optime\Bundle\CommtoolBundle\ControlFactory;
use Optime\Bundle\CommtoolBundle\CommtoolBuilderInterface;
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
        $vals = array();

        if ($parent) {
            $phpQuery = $this->phpQueryCont[$parent->getCompleteType()]->eq($parent->getIndex());
        } else {
            $phpQuery = $this->phpQueryCont;
        }

        foreach ($builder->getPrototypes() as $prototype) {

            $selector = $prototype->getCompleteType(false);

            if ($parent) {
                $prototype->setParent($parent);
            }

            $phpQueryTemp = $phpQuery->clone();

            $phpQueryTemp['.section']->not($selector)->remove();

            $items = $phpQueryTemp[$selector];
            foreach ($items as $index => $el) {
                $el = pq($el);
                $prototype->setIndex($index);
                $prototype->setIdentifier($this->createId($prototype));
                $control = $this->factory->createFromPrototype($prototype, $el, $prototype->getOptions());
                $controls[$prototype->getName()][$index] = $control;
                $vals[$prototype->getName()][$index] = $control->getValue();
            }
        }

        $builder->setControls($controls);
    }

    public function createId(ControlInterface $control)
    {
        $id = array();

        if ($control->getParent()) {
            $id[] = trim($control->getParent()->getIdentifier());
        }

        $id[] = $control->getName() . '[' . $control->getIndex() . ']';

        return join('.', $id);
    }

    public function exists(ControlInterface $section)
    {
        
    }

    public function getContent()
    {
        return $this->phpQueryCont->htmlOuter();
    }

    public function load(ControlInterface $control)
    {
        $part = $this->phpQueryCont["[data-id={$control->getIdentifier()}]"];
        if ($part->is('img')) {
            $control->setValue($part->attr('src'));
        } else {
            $control->setValue($part->html());
        }
    }

    public function save(CommtoolBuilderInterface $template)
    {
//        $content = \phpQuery::newDocument($template->getContent());
//        foreach ($template->getControls() as $control) {
//            $this->saveControl($control, $content);
//        }
//        $template->setContent((string) $content);
    }

    public function setContent($content)
    {
        $this->phpQueryCont = \phpQuery::newDocument($content);
    }

    public function saveControl(ControlInterface $control, &$content)
    {
//        $context = $content[$control->getSelector(false)];
//
//        if ($control instanceof ControlLoopInterface) {
//
//            $newContent = \phpQuery::newDocument('');
//            $selector = $control->getPrototype()->getSelector(false);
//
//            $control->setChildren(array());
//
//            foreach ($control->getValue() as $index => $val) {
//
//                $clone = pq((string) $context);
//
//                $prototype = clone $control->getPrototype();
//
//                $clone[$prototype->getSelector(false)]->attr('data-section-id', $index);
//
//                $prototype->setValue($val);
//                $prototype->setIdentifier($index);
//
//                $control->addChild($prototype);
//
//                $this->saveControl($prototype, $clone);
//                $newContent->append($clone->html());
//            }
//
//            $context->html($newContent);
//        } else {
//
//            if (count($control->getChildren())) {
//                foreach ($control->getChildren() as $child) {
//                    $this->saveControl($child, $context);
//                }
//            } else {
//                $context->html($control->getValue());
//            }
//        }
    }

    public function prepareContentView(CommtoolBuilderInterface $template, array $controlViews)
    {
        $content = \phpQuery::newDocument($template->getContent());

        $this->setAttrs($content, $controlViews);

        $c = $template->getControls();

        $template->setContent((string) $content);
    }

    protected function setAttrs(&$content, array $controlViews)
    {
        foreach ($controlViews as $control) {
            $current = $content[$control->vars['selector']];
            $current->attr('ng-bind', $control->vars['id']);
            $this->setAttrs($content, $control->vars['children']);
        }
    }

}
