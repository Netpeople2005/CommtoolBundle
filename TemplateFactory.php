<?php

namespace Optime\Bundle\CommtoolBundle;

use Optime\Bundle\CommtoolBundle\TemplateView;
use Optime\Bundle\CommtoolBundle\ControlFactory;
use Optime\Bundle\CommtoolBundle\Builder\Builder;
use Optime\Bundle\CommtoolBundle\TemplateInterface;
use Optime\Bundle\CommtoolBundle\Writer\WriterInterface;

class TemplateFactory
{

    /**
     *
     * @var ControlFactory
     */
    protected $controlFactory;

    /**
     *
     * @var WriterInterface
     */
    protected $writer;

    function __construct(ControlFactory $controlFactory)
    {
        $this->controlFactory = $controlFactory;
    }

    public function create(TemplateInterface $template, $content, array $options = array())
    {
        $manipulator = $this->controlFactory->getManipulator();

        $manipulator->setContent($content);
        
        $builder = new Builder($this->controlFactory, null);

        $template->build($builder, $options);

        $manipulator->createControls($builder);
//        $template->setContent($manipulator->getContent());

        $template->setControls($builder->getControls());
    }

    /**
     * 
     * @param \Optime\Bundle\CommtoolBundle\TemplateInterface $template
     * @return \Optime\Bundle\CommtoolBundle\TemplateView
     */
    public function createView(TemplateInterface $template)
    {
        $controls = array();
        
        foreach($template->getControls() as $index => $control){
            $controls[$index] = $control->createView();
        }        
        
        $this->controlFactory->getManipulator()->prepareContentView($template, $controls);
        
        $view = new TemplateView($template->getContent(), $controls);

        return $view;
    }

}