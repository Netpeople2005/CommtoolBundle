<?php

namespace Optime\Bundle\CommtoolBundle;

use Exception;
use Optime\Bundle\CommtoolBundle\Builder\Builder;
use Optime\Bundle\CommtoolBundle\Control\ControlInterface;
use Optime\Bundle\CommtoolBundle\Template\Manipulator\TemplateManipulatorInterface;
use Optime\Commtool\TemplateBundle\Model\SectionConfigInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Clase que se encarga de crear los controles para un commtool.
 * 
 * 
 * @author Manuel Aguirre <programador.manuel@gmail.com>
 */
class ControlFactory extends ContainerAware
{

    /**
     * Objeto que lee y escribe en el html
     * @var TemplateManipulatorInterface
     */
    protected $manipulator;

    /**
     * controles disponibles en la plataforma
     * @var array
     */
    protected $validTypes = array();

    function __construct($validTypes)
    {
        $this->validTypes = $validTypes;
    }

    /**
     * Crea un control a partir de la configuración de una sección.
     * 
     * @param SectionConfigInterface $config
     * @param array $options
     * @return ControlInterface
     */
    public function create(SectionConfigInterface $config, array $options = array())
    {
        $control = $this->resolveControl($config->getType());

        $options['label'] = $config->getLabel();
        $control->setDefaultOptions($resolver = $this->getOptionsResolver());
        $options = $resolver->resolve($options);
        $control->setOptions($options);

        $builder = new Builder($this, $control);

        $control->setIdentifier($config->getIdentifier());
        $control->setIndex($config->getCompleteIdentifier());
        $control->setSectionId($config->getId());

        $control->build($builder, $options);

        if ($builder->hasControls() and count($config->getChildren())) {
            $controls = $builder->createControls($config->getChildren());
            $control->setChildren($controls);
        }

        $this->manipulator->load($control);

        if (isset($options['data'])) {
            if (is_callable($options['data'])) {
                $value = call_user_func($options['data']
                        , $control->getValue(), $control, $config);
                $control->setValue($value);
            } else {
                $control->setValue($options['data']);
            }
        }

        return $control;
    }

    /**
     * devuelve una instancia de un control a partir de su nombre ó de una instancia.
     * 
     * @param ControlInterface|string $name
     * @return ControlInterface
     */
    public function resolveControl($type)
    {
        $type = $this->validateControlOrType($type);

        return clone $this->container->get($this->validTypes[$type]);
    }

    /**
     * verifica que un nombre ó una instancia sean un tipo de control válido
     * 
     * @param ControlInterface $controlOrType
     * @return ControlInterface
     * @throws Exception
     */
    public function validateControlOrType($controlOrType)
    {
        if ($controlOrType instanceof ControlInterface) {
            $type = $controlOrType->getType();
        } else {
            $type = $controlOrType;
        }

        if (!is_string($type)) {
            throw new Exception("No se reconoce el valor " . (string) $type);
        }

        if (!isset($this->validTypes[$type])) {
            throw new Exception("El control de tipo $type no se reconoce como un control registrado");
        }

        return $type;
    }

    /**
     * Establece el container en la clase
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
    }

    public function getValidTypes()
    {
        return $this->validTypes;
    }

    /**
     * Devuelve true si el tipo pasado por argumento es válido
     * @param string $type
     * @return boolean
     */
    public function isValidType($type)
    {
        return isset($this->validTypes[$type]);
    }

    public function getManipulator()
    {
        return $this->manipulator;
    }

    public function setManipulator(TemplateManipulatorInterface $manipulator)
    {
        $this->manipulator = $manipulator;
    }

    /**
     * 
     * @return OptionsResolver
     */
    public function getOptionsResolver()
    {
        $resolver = new OptionsResolver();

        return $resolver;
    }

}
