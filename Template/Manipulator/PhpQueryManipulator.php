<?php

namespace Optime\Bundle\CommtoolBundle\Template\Manipulator;

use Optime\Bundle\CommtoolBundle\CommtoolBuilderInterface;
use Optime\Bundle\CommtoolBundle\Control\ControlInterface;
use Optime\Bundle\CommtoolBundle\Control\ControlLoopInterface;
use Optime\Bundle\CommtoolBundle\ControlFactory;
use Optime\Bundle\CommtoolBundle\Template\Manipulator\TemplateManipulatorInterface;
use phpQuery;
use phpQueryObject;

class PhpQueryManipulator implements TemplateManipulatorInterface
{

    /**
     * 
     * @var ControlFactory
     */
    protected $factory;

    /**
     *
     * @var phpQueryObject
     */
    protected $phpQueryCont;

    public function __construct(ControlFactory $factory)
    {
        $this->factory = $factory;
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
            $html = $part->html();
            if (!mb_check_encoding($html, 'UTF-8')) {
                $html = utf8_encode($html);
            }
            $control->setValue($html);
        }
    }

    public function generate(CommtoolBuilderInterface $template)
    {
        $html = $template->getContent();
        if (!mb_check_encoding($html, 'UTF-8')) {
            $html = utf8_encode($html);
        }
        $content = phpQuery::newDocument($html);

        $this->_generate($content, $template->getControls());

        $content->find('*')->removeAttr('data-id');
        $content->find('*')->removeAttr('data-type');
        $content->find('*')->removeAttr('data-name');
        $content->find('*')->removeAttr('ng-bind');
        $content->find('*')->removeAttr('ng-repeat');

        return (string) $content;
    }

    protected function _generate(\phpQueryObject $content, $controls)
    {
        foreach ((array) $controls as $control) {
            $part = $content["[data-id={$control->getIdentifier()}]"];
            if ($control instanceof ControlLoopInterface) {
                //cuando es loop, debemos clonar el html original y crear tantas
                //copias como hijos contenta el control.
                $this->updateLoopContent($part, $control);
            } else {
                if ($control->getChildren()) {
                    $this->_generate($part, $control->getChildren());
                } else {
                    $this->updateContent($part, $control);
                }
            }
        }
    }

    protected function updateContent(\phpQueryObject $content, ControlInterface $control)
    {
        $content->html(current($control->getValue()));
    }

    protected function updateLoopContent(\phpQueryObject $content, ControlLoopInterface $control)
    {
        $children = $control->getChildren();

        if (count($children) == 0) {
            $content->remove();
        } else {
            $prototype = $content->clone();
            foreach ($children as $index => $child) {
                $clone = $prototype->clone();
                if (0 == $index) {
                    $this->_generate($content, array($child));
                } else {
                    $content->after($clone);
                    $this->_generate($clone, array($child));
                }
            }
        }
    }

    public function setContent($content)
    {
        $this->phpQueryCont = phpQuery::newDocument($content);
    }

}
