<?php

namespace Optime\Bundle\CommtoolBundle\Twig\Extension;

use Optime\Bundle\CommtoolBundle\TemplateView;
use Optime\Bundle\CommtoolBundle\Control\ControlInterface;
use Optime\Bundle\CommtoolBundle\CommtoolBuilderInterface;

class CommtoolExtension extends \Twig_Extension
{

    /**
     *
     * @var \Twig_Environment
     */
    protected $twig;
    protected $commtool_layout = 'OptimeCommtoolBundle::commtool_layout.html.twig';
    protected $template;

    public function initRuntime(\Twig_Environment $environment)
    {
        $this->twig = $environment;
    }

    public function getName()
    {
        return 'commtool_extension';
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('commtool_content', array($this, 'content'), array('is_safe' => array('html'),)),
            new \Twig_SimpleFunction('commtool_controls', array($this, 'controls'), array('is_safe' => array('html'),)),
            new \Twig_SimpleFunction('commtool_*', array($this, 'control'), array('is_safe' => array('html'),)),
        );
    }

    public function content(TemplateView $template)
    {
        return $template->getContent();
    }

    public function controls($commtoolOrControls)
    {
        if ($commtoolOrControls instanceof CommtoolBuilderInterface) {
            $commtoolOrControls = $commtoolOrControls->getControls();
        }

        $content = '';
        foreach ($commtoolOrControls as $control) {
//            if ($control->getChildren()) {
//                $content .= $this->controls($control->getChildren());
//            } else {
                $content .= $this->control($control->getType(), $control);
//            }
        }

        return $content;
    }

    public function control($type, ControlInterface $control)
    {
        return $this->getTemplate()->renderBlock("control_{$type}", array(
                    'id' => $control->getIndex(),
                    'label' => $control->getOptions('label'),
                    'options' => $control->getOptions(),
                    'children' => $control->getChildren(),
        ));
    }

    protected function getTemplate()
    {
        if (!$this->template) {
            $this->template = $this->twig->loadTemplate($this->commtool_layout);
        }

        return $this->template;
    }

}
