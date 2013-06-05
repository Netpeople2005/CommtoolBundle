<?php

namespace Optime\Bundle\CommtoolBundle;

use Optime\Bundle\CommtoolBundle\Builder\Builder;
use Symfony\Component\DependencyInjection\ContainerAware;
use Optime\Bundle\CommtoolBundle\Section\SectionInterface;
use Optime\Bundle\CommtoolBundle\Template\Manipulator\TemplateManipulatorInterface;

class SectionFactory extends ContainerAware
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
     * @return SectionInterface
     */
    public function create($name, $content, array $options = array())
    {
        $section = $this->resolveSection($name);

        $section->setValue($content);

        $builder = new Builder($section);

        $section->build($builder, $options);

        if ($content && count($builder->getNames())) {
            $this->manipulator->createSections($builder);

            $section->setChildren($this->createSections($builder->getSections(), $options));
        }

        return $section;
    }

    /**
     * 
     * @param \Optime\Bundle\CommtoolBundle\Section\SectionInterface|string $name
     * @return \Optime\Bundle\CommtoolBundle\Section\SectionInterface
     */
    public function resolveSection($name)
    {
        if (is_object($name) && $name instanceof SectionInterface) {
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

    protected function createSections(array $prototypes, array $options = array())
    {
        $sections = array();
        foreach ($prototypes as $section) {
            $this->create($section['name'], $section['content'], $options);
        }
        return $sections;
    }

}
