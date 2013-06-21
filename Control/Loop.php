<?php

namespace Optime\Bundle\CommtoolBundle\Control;

use Optime\Bundle\CommtoolBundle\Control\AbstractControl;
use Optime\Bundle\CommtoolBundle\Builder\BuilderInterface;
use Optime\Bundle\CommtoolBundle\Control\ControlLoopInterface;
use Optime\Commtool\TemplateBundle\Model\SectionConfigInterface;

class Loop extends AbstractControl implements ControlLoopInterface
{

    /**
     *
     * @var ControlInterface
     */
    protected $prototype;
    protected $type;

    /**
     *
     * @var \Optime\Bundle\CommtoolBundle\ControlFactory
     */
    protected $factory;

    public function build(BuilderInterface $builder, array $options = array())
    {
        if (!isset($options['type'])) {
            throw new \Exception("Se debe especificar el atributo type en las opciones de la sección de tipo loop");
        }

        $this->type = $builder->getFactory()->validateControlOrType($options['type']);

        $builder->add($this->type);
    }

    public function getType()
    {
        return 'loop_' . $this->type;
    }

    public function setChildren(array $children)
    {
        parent::setChildren($children);
        if (!$this->prototype && count($children)) {
            $this->prototype = current($children);
        }
    }

    public function getPrototype()
    {
        return $this->prototype;
    }

    public function getValue()
    {
//            var_dump($this->children);die;
        if (count($this->children)) {
            $values = array();
            foreach ($this->children as $index => $control) {
                $id = $control->getIdentifier();
//                $value[$index] = $control->getValue();
                $values[] = array($id => $control->getValue());
            }

            return $values;
        } else {
            return $this->value;
        }
    }

    public function setValue($value)
    {
        $this->value = $value;
        if (is_array($value)) {
            $this->setChildren(array());
            foreach ($value as $val) {
                $prototype = clone $this->prototype;
                $prototype->setValue($val);
                $this->children[] = $prototype;
            }
        }
    }

}