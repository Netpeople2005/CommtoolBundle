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

    /**
     * 
     * @param type $name
     * @param type $content
     * @param array $options
     * @return ControlInterface
     */
    public function create($name, array $options = array())
    {
        return $this->_create($this->resolveControl($name), $options);
    }

    /**
     * 
     * @param type $name
     * @param type $content
     * @param array $options
     * @return ControlInterface
     */
    public function createFromPrototype(ControlInterface $control
    , SectionConfigInterface $config, $value = null)
    {
        $control = clone $control;
        $control->setIdentifier($config->getIdentifier());

        $options = $control->getOptions();

        if (isset($options['config'])) {
            $options['config'] = array_merge($options['config'], $config->getConfig());
        } else {
            $options['config'] = $config->getConfig();
        }

        if (count($control->getChildren()) and count($config->getChildren())) {
            $prototypes = $control->getChildren();

            $controls = array();

            foreach ($config->getChildren() as $secConf) {
                if (isset($prototypes[$secConf->getName()])) {
                    $prototype = $prototypes[$secConf->getName()];

                    if (is_array($value) and isset($value[$secConf->getIdentifier()])) {
                        $controlValue = $value[$secConf->getIdentifier()];
                    } else {
                        $controlValue = null;
                    }

                    $controls[] = $this->createFromPrototype($prototype, $secConf, $controlValue);
                }
            }

            $control->setChildren($controls);
        }


        if (isset($options['data'])) {
            if (is_callable($options['data'])) {
                $value = call_user_func($options['data'], $config, $value);
                $control->setValue($value);
            } else {
                $control->setValue($options['data']);
            }
        } else if (null !== $value) {
            $control->setValue($value);
        } else {
            $this->manipulator->load($control);
        }

        return $control;
    }

    protected function _create($control, array $options = array())
    {

        $builder = new Builder($this, $control);

        $control->build($builder, $options);

        if (count($builder->getPrototypes())) {

            $options['has_children'] = true;

            $control->setChildren($builder->getPrototypes());
        }

        $control->setOptions($options);

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
