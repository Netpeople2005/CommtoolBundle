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
        if (!isset($options['filter_name'])) {
            throw new \Exception("Los controles de tipo Loop solo se puede crear llamando al método addNamed del Builder");
        }

        $childrenOptions = isset($options['children_options']) ? $options['children_options'] : array();

        if (isset($options['type'])) {
            $builder->add($options['type'], $childrenOptions);
        } else {
            $builder->add($options['filter_name'], $childrenOptions);
        }
    }

    public function getType()
    {
        return 'loop';
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