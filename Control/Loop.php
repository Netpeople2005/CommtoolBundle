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
        return 'loop';
    }

    public function getValue()
    {
        return parent::getValue();
    }

    public function setChildren(array $children)
    {
        parent::setChildren($children);

        $values = array();

        foreach ($children as $control) {
            $values[] = $control->getValue();
        }

        $this->value = $values;
    }

    public function getSelector($useParent = true)
    {
        return parent::getSelector($useParent) . '.' . $this->getOptions('selector');
    }

    public function setValue($value)
    {
        $this->value = (array) $value;
        foreach ($this->value as $index => $value) {
            if (isset($this->children[$index])) {
                $this->children[$index]->setValue($value);
            }
        }
    }

//    public function setValue($value)
//    {
//        $value = array_values($value); //solo nos interesa los valores, sin los indices
//
//        $this->setChildren(array()); //quito los hijos, ya que serán creados a partir de los valores
//        //establecidos.
//
//        foreach ($value as $val) {
//            $this->addChild($val);
//        }
//
//        $this->updateContent();
//    }
//    public function getContent()
//    {
//        return $this->realContent;
//    }
//    protected function addChild($value)
//    {
//        $control = clone $this->prototype;
//        $control->setValue($value);
//        $control->setParent($this);
//        $this->children[] = $control;
//    }

    protected function updateContent()
    {
        $query = \phpQuery::newDocument(trim($this->content));

        $contents = '';
        foreach ($this->getChildren() as $control) {
            $content = $query->clone();

            $content[$control->getSelector()]->html($control->getValue());

            $contents .= $content->html();
        }

        $this->realContent = $contents;
    }

    public function prepareContent(TemplateManipulatorInterface $manipulator)
    {
//        $content = $this->getContent();
//        
//        $manipulator->
    }

    public function getPrototype()
    {
        if (!$this->prototype) {
            $this->prototype = current($this->children);
        }
        
        return $this->prototype;
    }

}