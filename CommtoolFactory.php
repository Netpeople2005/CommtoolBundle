<?php

namespace Optime\Bundle\CommtoolBundle;

use Optime\Bundle\CommtoolBundle\TemplateView;
use Optime\Bundle\CommtoolBundle\ControlFactory;
use Optime\Bundle\CommtoolBundle\Builder\Builder;
use Optime\Bundle\CommtoolBundle\CommtoolBuilderInterface;
use Optime\Commtool\TemplateBundle\Model\TemplateInterface;
use Optime\Commtool\TemplateBundle\Model\SectionConfigInterface;
use Optime\Commtool\TemplateBundle\Twig\Extension\SectionExtension;

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

    /**
     *
     * @var SectionExtension
     */
    protected $sectionExtension;

    function __construct(ControlFactory $controlFactory, \Twig_Environment $twig
    , SectionExtension $sectionExtension)
    {
        $this->controlFactory = $controlFactory;
        $this->twig = $twig;
        $this->sectionExtension = $sectionExtension;
    }

    public function create(CommtoolBuilderInterface $commtoolBuilder
    , TemplateInterface $template, array $options = array())
    {
        $manipulator = $this->controlFactory->getManipulator();

        $manipulator->setContent($this->getContent($template));

        $builder = new Builder($this->controlFactory, null);

        $options['template'] = $template;

        $commtoolBuilder->build($builder, $options);

        if (isset($options['data'])) {
            $values = $options['data'];
        } else {
            $values = array();
        }

        $controls = $this->createControls($builder->getPrototypes(), $template->getSections());

        $commtoolBuilder->setContent($manipulator->getContent());

        $commtoolBuilder->setControls($controls);

        $commtoolBuilder->setValues($values);
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

    public function createControls(array $prototypes, $templateSections)
    {
        $controls = array();
        //filtramos solo las secciones que no posean padres en primera instancia.
        $templateSections = array_filter($templateSections->toArray(), function(SectionConfigInterface $sec) {
                    return null === $sec->getParent();
                });

        foreach ($templateSections as $section) {
            if (isset($prototypes[$section->getName()])) {
                
                $prototype = $prototypes[$section->getName()];

                $controls[] = $this->controlFactory->createFromPrototype($prototype, $section);
            }
        }

        return $controls;
    }

    protected function getContent(TemplateInterface $template)
    {
        $this->sectionExtension->setTemplate($template);
        $content = $this->twig->render($template->getView());
        $this->sectionExtension->setTemplate(null);
        return $content;
    }

}