<?php

namespace Optime\Bundle\CommtoolBundle;

use Optime\Bundle\CommtoolBundle\Builder\Builder;
use Symfony\Component\DependencyInjection\ContainerAware;
use Optime\Bundle\CommtoolBundle\Control\ControlInterface;
use Optime\Bundle\CommtoolBundle\Template\Manipulator\TemplateManipulatorInterface;

class ControlFactory extends ContainerAware
{

    /**
     *
     * @var TemplateManipulatorInterface
     */
    protected $manipulator;
    protected $validTypes = array();

    function __construct($validTypes)
    {
        $this->validTypes = $validTypes;
    }

    /**
     * 
     * @param type $name
     * @param type $content
     * @param array $options
     * @return ControlInterface
     */
    public function create($name, $content, array $options = array())
    {
        return $this->_create($this->resolveControl($name), $content, $options);
    }

    /**
     * 
     * @param type $name
     * @param type $content
     * @param array $options
     * @return ControlInterface
     */
    public function createFromPrototype(ControlInterface $control, $content, array $options = array())
    {
        return $this->_create(clone $control, $content, $options);
    }

    protected function _create($control, $content, array $options = array())
    {
        $control->setContent($content);
        $control->setOptions($options);

        $builder = new Builder($this, $control);

        $control->build($builder, $options);

        if ($content && count($builder->getPrototypes())) {

            $this->manipulator->createControls($builder, $control);

            $control->setChildren($builder->getControls());

            $control->setValue($builder->getValues());
        } else {
            if ($content instanceof \phpQueryObject) {
                $control->setValue(trim($content->html()));
            } else {
                $control->setValue(trim((string) $content));
            }
        }

        return $control;
    }

    /**
     * 
     * @param \Optime\Bundle\CommtoolBundle\Control\ControlInterface|string $name
     * @return \Optime\Bundle\CommtoolBundle\Control\ControlInterface
     */
    public function resolveControl($name)
    {
        if (is_object($name) && $name instanceof ControlInterface) {
            if (isset($this->validTypes[$name->getName()])) {
                $name = $name->getName();
            } else {
                return $name;
            }
        }

        if (!is_string($name)) {
            throw new \Exception("No se reconoce el valor " . (string) $name);
        }

        if (isset($this->validTypes[$name])) {
            return clone $this->container->get($this->validTypes[$name]);
        }

        throw new \Exception("El tipo de sección $name no existe");
    }

    public function getSelector($name)
    {
        if (isset($this->validTypes[$name])) {
            return $this->container->get($this->validTypes[$name])->getSelector();
        }
    }

    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null)
    {
        parent::setContainer($container);
    }

    public function getValidTypes()
    {
        return $this->validTypes;
    }

    public function getManipulator()
    {
        return $this->manipulator;
    }

    public function setManipulator(TemplateManipulatorInterface $manipulator)
    {
        $this->manipulator = $manipulator;
    }

}
