<?php

namespace Optime\Bundle\CommtoolBundle\Twig\Extension;

use Optime\Bundle\CommtoolBundle\TemplateView;

class CommtoolExtension extends \Twig_Extension
{

    public function getName()
    {
        return 'commtool_extension';
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('commtool_content', array($this, 'content'), array('is_safe' => array('html'),)),
        );
    }

    public function content(TemplateView $template)
    {
        return $template->getContent();
    }

}
