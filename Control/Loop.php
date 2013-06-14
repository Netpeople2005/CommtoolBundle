<?php

namespace Optime\Bundle\CommtoolBundle\Control;

use Optime\Bundle\CommtoolBundle\Control\AbstractControl;
use Optime\Bundle\CommtoolBundle\Builder\BuilderInterface;
use Optime\Bundle\CommtoolBundle\Control\ControlLoopInterface;
use Optime\Bundle\CommtoolBundle\Template\Manipulator\TemplateManipulatorInterface;

class Loop extends AbstractControl implements ControlLoopInterface
{

    /**
     *
     * @var ControlInterface
     */
    protected $prototype;

    public function build(BuilderInterface $builder, array $options = array())
    {
        if (!isset($options['type'])) {
            throw new \Exception("Se debe especificar el atributo type en las opciones de la sección de tipo loop");
        }

        if (!isset($options['selector'])) {
            throw new \Exception("Se debe especificar el atributo selector en las opciones de la sección de tipo loop");
        }

        $type = $options['type'];

        $builder->add($type);
    }

    public function getName()
    {
        return 'loop_' . $this->getOptions('selector');
    }

    public function getValue()
    {
        return parent::getValue();
    }

    public function setChildren(array $children)
    {
        parent::setChildren($children);

        if (!$this->prototype && count($children) && count(current($children))) {
            $this->prototype = count(current($children));
        }
    }

    public function getSelector($useParent = true)
    {
        return parent::getSelector($useParent);
    }

    public function getPrototype()
    {
        return $this->prototype;
    }

    public function addChild(ControlInterface $control)
    {
//        if (!isset($this->children[$control->getIdentifier()])) {
//            $this->children[$control->getIdentifier()] = $control;
//        }
    }

}