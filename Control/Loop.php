<?php

namespace Optime\Bundle\CommtoolBundle\Control;

use Optime\Bundle\CommtoolBundle\Control\AbstractControl;
use Optime\Bundle\CommtoolBundle\Builder\BuilderInterface;
use Optime\Bundle\CommtoolBundle\Control\ControlLoopInterface;

class Loop extends AbstractControl implements ControlLoopInterface
{

    /**
     *
     * @var ControlInterface
     */
    protected $prototype;
    protected $type;

    public function build(BuilderInterface $builder, array $options = array())
    {
        if (!isset($options['type'])) {
            throw new \Exception("Se debe especificar el atributo type en las opciones de la sección de tipo loop");
        }

        if (!isset($options['selector'])) {
            throw new \Exception("Se debe especificar el atributo selector en las opciones de la sección de tipo loop");
        }

        $type = $options['type'];

        if (is_string($type)) {
            $this->type = $type;
        } elseif ($type instanceof ControlInterface) {
            $this->type = $type->getName();
        } else {
            throw new \Exception("No se reconoce el tipo de control para el Loop");
        }

        $builder->add($type);
    }

    public function getName()
    {
        return 'loop';// . $this->type;
    }

//    public function setValue($value)
//    {
//        $this->value = $value;
//
//        if (!is_array($value)) {
//            throw new \Exception("El control de Tipo {$this->getName()} solo acepta como valor un Arreglo");
//        }
//
////        foreach ($this->children as $type => $controls) {
////            foreach ($controls as $index => $control) {
////                if (isset($value[$index][$type])) {
////                    $control->setValue($value[$index][$type]);
////                }
////            }
////        }
//    }

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

}