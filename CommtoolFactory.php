<?php

namespace Optime\Bundle\CommtoolBundle;

use Optime\Bundle\CommtoolBundle\ControlFactory;
use Optime\Bundle\CommtoolBundle\Builder\Builder;
use Optime\Bundle\CommtoolBundle\CommtoolBuilderInterface;
use Optime\Commtool\TemplateBundle\Model\TemplateInterface;
use Optime\Commtool\TemplateBundle\Twig\Extension\SectionExtension;

/**
 * 
 * Clase que crea los controles para un commtool
 * 
 * @author Manuel Aguirre <programador.manuel@gmail.com>
 */
class CommtoolFactory
{

    /**
     * clase que crea los controles
     * @var ControlFactory
     */
    protected $controlFactory;

    /**
     * 
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * Extensión twig que crea los atributos en las etiquetas html
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

    /**
     * Crea los controles en el commtool, a partir de un TemplateInterface
     * @param \Optime\Bundle\CommtoolBundle\CommtoolBuilderInterface $commtoolBuilder
     * @param \Optime\Commtool\TemplateBundle\Model\TemplateInterface $template
     * @param array $options
     */
    public function create(CommtoolBuilderInterface $commtoolBuilder
    , TemplateInterface $template, array $options = array())
    {
        $manipulator = $this->controlFactory->getManipulator();

        $manipulator->setContent($this->twig->render($template->getView()));

        $builder = new Builder($this->controlFactory, null);

        $options['template'] = $template;

        $commtoolBuilder->build($builder, $options);

        if (isset($options['data'])) {
            $values = $options['data'];
        } else {
            $values = array();
        }

        if ($builder->hasControls() and count($template->getSections())) {
            $controls = $builder->createControls($template->getSections());
        }else{
            $controls = array();
        }

        $commtoolBuilder->setControls($controls);
        
        $commtoolBuilder->setContent($this->getContent($commtoolBuilder, $template));

        $commtoolBuilder->setValues($values);
    }

    /**
     * Devuelve el contenido html del template
     * 
     * @param \Optime\Bundle\CommtoolBundle\CommtoolBuilderInterface $commtool
     * @param \Optime\Commtool\TemplateBundle\Model\TemplateInterface $template
     * @return string
     */
    protected function getContent(CommtoolBuilderInterface $commtool, TemplateInterface $template)
    {
        $this->sectionExtension->setCommtool($commtool);
        $content = $this->twig->render($template->getView());
        $this->sectionExtension->setCommtool(null);
        return $content;
    }

}