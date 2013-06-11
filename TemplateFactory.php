<?php

namespace Optime\Bundle\CommtoolBundle;

use Optime\Bundle\CommtoolBundle\TemplateInterface;
use Optime\Bundle\CommtoolBundle\ControlFactory;
use Optime\Bundle\CommtoolBundle\Writer\WriterInterface;
use Optime\Bundle\CommtoolBundle\Builder\Builder;

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
        
        $template->setContent($manipulator->getContent());

        $template->setControls($builder->getControls());

        return $template;
    }

}