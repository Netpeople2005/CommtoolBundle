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
    protected $template;

    /**
     *
     * @var CommtoolBuilderInterface
     */
    protected $commtool;

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
            new \Twig_SimpleFunction('control_binds', array($this, 'binds'), array(
                'needs_context' => true,
                'is_safe' => array('html'),
                    )),
            new \Twig_SimpleFunction('commtool_ng_controller', array($this, 'ngController'), array('is_safe' => array('html'),)),
        );
    }

    public function content(CommtoolBuilderInterface $commtool)
    {
        $this->commtool = $commtool;
        return $commtool->getContent();
    }

    public function controls($commtoolOrControls)
    {
        if ($commtoolOrControls instanceof CommtoolBuilderInterface) {
            $commtoolOrControls = $commtoolOrControls->getControls();
        }

        $content = '';
        foreach ($commtoolOrControls as $control) {
//            $content .= $this->control($control->getCompleteType(), $control);
            $content .= $this->control($control->getCompleteType(), $control);
        }

        return $content;
    }

    public function ngController(CommtoolBuilderInterface $commtool)
    {
        $js = '';
        foreach ($commtool->getValues() as $id => $value) {
            $js .= '$scope.' . $id . ' = ' . json_encode($value) . PHP_EOL;
        }

        $js.= PHP_EOL . '$scope.functions = {}' . PHP_EOL;

        $js.= $this->jsBindControls($commtool->getControls());

        return $js;
    }

    protected function jsBindControls($controls)
    {
        $js = '';
        foreach ($controls as $index => $control) {
            $binds = array();
            foreach ((array) $control->getOptions('bind') as $bind) {

                if ($parent = $control->getParent()) {
                    $parent = $parent->getIndex();
                } else {
                    $parent = 'scope';
                }

                $binds[] = $bind . ":function(scope, data, control){
                    {$bind}(scope, data, control); 
                    /*if(angular.isArray(data.parent)){
                        alert('es un array')
                    }else{
                        data.parent.{$control->getIdentifier()}=data.element;
                    }*/
                }";
            }
            $js .= '$scope.functions.' . $control->getIdentifier() . ' = {' . join(',', $binds) . '}' . PHP_EOL;
            if (count($control->getChildren())) {
                $js .= $this->jsBindControls($control->getChildren());
            }
        }
        return $js;
    }

    public function control($type, ControlInterface $control)
    {
        $context = array(
            'id' => $control->getIndex(),
            'section_id' => $control->getSectionId(),
            'identifier' => $control->getIdentifier(),
            'type' => $control->getType(),
            'label' => $control->getOptions('label'),
            'options' => $control->getOptions(),
            'control' => $control,
        );
        
        if($control instanceof \Optime\Bundle\CommtoolBundle\Control\ControlLoopInterface){
            $context['children'] = array(current($control->getChildren()));
        }else{
            $context['children'] = $control->getChildren();
        }
        
        $content = $this->getTemplate()->renderBlock("control_{$type}", $context);
        
        if (!$content) {
            $type = explode('_', $type, 2);
            if (count($type) > 1) {
                return $this->control($type[1], $control);
            }
        }

        return $content;
    }

    public function binds($context)
    {
        $content = '';

        $controlData = json_encode(array(
            'id' => $context['control']->getIndex(),
            'section_id' => $context['control']->getSectionId(),
            'identifier' => $context['control']->getIdentifier(),
            'type' => $context['control']->getType(),
                ), JSON_HEX_QUOT);

        if ($parent = $context['control']->getParent()) {
            $parent = $parent->getIndex();
        } else {
            $parent = 'this';
        }

        if (isset($context['options']['bind'])) {
            foreach ((array) $context['options']['bind'] as $event => $function) {
                $content .= " ng-{$event}='functions.{$context['identifier']}.{$function}(this, {$context['id']}, {$controlData})' ";
            }
        }

        return $content;
    }

    /**
     * 
     * @return \Twig_Template
     * @throws \Exception
     */
    protected function getTemplate()
    {
        if (!$this->template) {
            if (!$this->commtool instanceof CommtoolBuilderInterface) {
                throw new \Exception("No se puede intentar crear controles de un commtool sin antes llamar a commtool_content");
            }
            $this->template = $this->twig->loadTemplate($this->commtool->getLayout());
        }

        return $this->template;
    }

}
