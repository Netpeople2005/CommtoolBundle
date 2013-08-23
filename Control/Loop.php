<?php

namespace Optime\Bundle\CommtoolBundle\Control;

use Exception;
use Optime\Bundle\CommtoolBundle\Builder\BuilderInterface;
use Optime\Bundle\CommtoolBundle\Control\AbstractControl;
use Optime\Bundle\CommtoolBundle\Control\ControlLoopInterface;
use Optime\Bundle\CommtoolBundle\ControlFactory;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
     * @var ControlFactory
     */
    protected $factory;

    public function build(BuilderInterface $builder, array $options = array())
    {
        if (!isset($options['filter_name'])) {
            throw new Exception("Los controles de tipo Loop solo se puede crear llamando al método addNamed del Builder");
        }

        $childrenOptions = $options['children'];

        if ($options['type']) {
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
        if (count($this->children)) {
            $values = array();
            foreach ($this->children as $index => $control) {
                $id = $control->getIdentifier();
                $values[$index] = array($id => $control->getValue());
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
            foreach ($value as $index => $val) {
                $prototype = clone $this->prototype;
                $prototype->setValue(current($val));
                $this->children[] = $prototype;
            }
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults(array(
            'type' => null,
            'children' => array(),
        ));
    }

}