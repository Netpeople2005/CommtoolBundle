<?php

namespace Optime\Bundle\CommtoolBundle;

use Optime\Bundle\CommtoolBundle\TemplateView;
use Optime\Bundle\CommtoolBundle\ControlFactory;
use Optime\Bundle\CommtoolBundle\Builder\Builder;
use Optime\Bundle\CommtoolBundle\CommtoolBuilderInterface;
use Optime\Commtool\TemplateBundle\Model\TemplateInterface;

class CommtoolFactory
{

    /**
     *
     * @var ControlFactory
     */
    protected $controlFactory;

    /**
     *
     * @var \Twig_Environment
     */
    protected $twig;

    function __construct(ControlFactory $controlFactory, \Twig_Environment $twig)
    {
        $this->controlFactory = $controlFactory;
        $this->twig = $twig;
    }

    public function create(CommtoolBuilderInterface $commtoolBuilder
    , TemplateInterface $template, array $options = array())
    {
        $manipulator = $this->controlFactory->getManipulator();
        
        $manipulator->setContent($this->getContent($template));

        $builder = new Builder($this->controlFactory, null);

        $commtoolBuilder->build($builder, $options);

        $manipulator->createControls($builder);

        $commtoolBuilder->setContent($manipulator->getContent());

        $commtoolBuilder->setControls($builder->getControls());
    }

    /**
     * 
     * @param \Optime\Bundle\CommtoolBundle\CommtoolBuilderInterface $template
     * @return \Optime\Bundle\CommtoolBundle\TemplateView
     */
    public function createView(CommtoolBuilderInterface $template)
    {
        $controls = array();

        foreach ($template->getControls() as $index => $control) {
            $controls[$index] = $control->createView();
        }

        $this->controlFactory->getManipulator()->prepareContentView($template, $controls);

        $view = new TemplateView($template->getContent(), $controls);

        return $view;
    }

    protected function getContent(TemplateInterface $template)
    {
        return $this->twig->render($template->getView());
    }

}