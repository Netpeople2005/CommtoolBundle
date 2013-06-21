<?php

namespace Optime\Bundle\CommtoolBundle;

use Optime\Bundle\CommtoolBundle\Builder\Builder;
use Symfony\Component\DependencyInjection\ContainerAware;
use Optime\Bundle\CommtoolBundle\Control\ControlInterface;
use Optime\Commtool\TemplateBundle\Model\SectionConfigInterface;
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

    public function create(SectionConfigInterface $config, array $options = array())
    {
        $control = $this->resolveControl($config->getName());

        $builder = new Builder($this, $control);

        $control->setIdentifier($config->getIdentifier());
        $control->setIndex($config->getCompleteIdentifier());

        $control->build($builder, $options);

        if (isset($options['config']) and is_array($options['config'])) {
            $options['config'] = array_merge($options['config'], $config->getConfig());
        } else {
            $options['config'] = $config->getConfig();
        }

        if (!isset($options['label'])) {
            $options['label'] = $config->getLabel();
        }

        $control->setOptions($options);

        if ($builder->hasControls() and count($config->getChildren())) {
            $controls = $builder->createControls($config->getChildren());
            $control->setChildren($controls);
        }

        $this->manipulator->load($control);

        if (isset($options['data'])) {
            if (is_callable($options['data'])) {
                $value = call_user_func($options['data'], $config, $control->getValue());
                $control->setValue($value);
            } else {
                $control->setValue($options['data']);
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
        $name = $this->validateControlOrName($name);

        return clone $this->container->get($this->validTypes[$name]);
    }

    public function validateControlOrName($controlOrName)
    {
        if (is_object($controlOrName) && $controlOrName instanceof ControlInterface) {
            $name = $controlOrName->getName();
        } else {
            $name = $controlOrName;
        }

        if (!is_string($name)) {
            throw new \Exception("No se reconoce el valor " . (string) $name);
        }

        if (!isset($this->validTypes[$name])) {
            throw new \Exception("El control de tipo $name no se reconoce como un control registrado");
        }

        return $name;
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
