<?php

namespace Optime\Bundle\CommtoolBundle\Control;

use Optime\Bundle\CommtoolBundle\Control\ControlInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

abstract class AbstractControl implements ControlInterface
{

    protected $sectionId;

    /**
     *
     * @var $value
     */
    protected $value;

    /**
     *
     * @var string
     */
    protected $index;

    /**
     *
     * @var string
     */
    protected $identifier;

    /**
     *
     * @var array
     */
    protected $children = array();

    /**
     *
     * @var ControlInterface
     */
    protected $parent;

    /**
     *
     * @var array
     */
    protected $options = array();

    public function getSectionId()
    {
        return $this->sectionId;
    }

    public function setSectionId($sectionId)
    {
        $this->sectionId = $sectionId;
    }

    public function getValue()
    {
        if (count($this->children)) {
            $value = array();
            foreach ($this->children as $index => $control) {
                $id = $control->getIdentifier();
                $value[$id] = $control->getValue();
            }

            return $value; //parece que así funciona pero no es seguro :-/
            return array('value' => $value);
        } else {
            return array('value' => $this->value);
        }
    }

    public function getIndex()
    {
        return $this->index;
    }

    public function setIndex($index)
    {
        $this->index = $index;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    public function setValue($value)
    {
        $this->value = $value;
        if (is_array($value)) {
            if (count($this->children)) {
                foreach ($this->children as $index => $control) {
                    $id = $control->getIdentifier();
                    $sectionName = $control->getSectionName();
                    if (!$control->isReadOnly()) {
                        if (array_key_exists($id, $value)) {
                            /*
                             * Acá se setea el valor en base al identificador
                             * del elemento en la BD.
                             */
                            $control->setValue($value[$id]);
                        } elseif ($sectionName && array_key_exists($sectionName, $value)) {
                            /*
                             * aca se setea el valor en base al nombre
                             * que se le da a la seccion en el html,
                             * ejemplo:
                             * {{ section_singleline("titulo") }}
                             * 
                             * si el $sectionName contiene el string titulo
                             * entonces se pasa su valor al control.
                             */
                            $control->setValue($value[$sectionName]);
                        } elseif (array_key_exists($index, $value)) {
                            /*
                             * esto es una funcionalidad que permite
                             * setear el valor en base al indice del control
                             * en el arreglo donde se encuentra contenido
                             * se debe usar con mucho cuidado.
                             */
                            $control->setValue($value[$index]);
                        }
                    }
                }
            } else {
                if (array_key_exists($this->getIdentifier(), $value)) {
                    $this->value = $value[$this->getIdentifier()];
                } elseif (array_key_exists('value', $value)) {
                    $this->value = $value['value'];
                }
            }
        }
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function setChildren(array $children)
    {
        $this->children = $children;
    }

    public function getCompleteType($useName = false)
    {
        if ($this->getParent()) {
            return $this->getParent()->getCompleteType() . '_' . $this->getName();
        } else {
            return $this->getName();
        }
    }

    public function getOptions($name = null)
    {
        if (null !== $name) {
            return isset($this->options[$name]) ? $this->options[$name] : null;
        } else {
            return $this->options;
        }
    }

    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setParent(ControlInterface $parent = null)
    {
        $this->parent = $parent;
    }

    public function isReadOnly()
    {
        return isset($this->options['readonly']) ? $this->options['readonly'] : false;
    }

    public function getName()
    {
        if (isset($this->options['filter_name'])) {
            return $this->options['filter_name'] . '_' . $this->getType();
        } else {
            return $this->getType();
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'label' => null,
            'filter_name' => null,
            'is_interactive' => true,
        ));

        $resolver->setOptional(array('data', 'bind'));
    }

    public function getSectionName()
    {
        return isset($this->options['filter_name']) ? $this->options['filter_name'] : null;
    }

    /**
     * Se debe implementar clone para clonar todos los hijos del 
     * elemento, ya que sino se estaría usando un mismo objeto en varios
     * controles.
     */
    public function __clone()
    {
        $prototipes = $this->children;
        $this->children = array();
        foreach ($prototipes as $index => $control) {
            $this->children[$index] = clone $control;
        }
    }

}
