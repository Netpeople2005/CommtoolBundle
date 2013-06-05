<?php

namespace Optime\Bundle\CommtoolBundle;

use Optime\Bundle\CommtoolBundle\Builder\Builder;
use Symfony\Component\DependencyInjection\ContainerAware;
use Optime\Bundle\CommtoolBundle\Section\SectionInterface;

class SectionFactory extends ContainerAware
{

    /**
     *
     * @var Reader\ReaderInterface
     */
    protected $reader;
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

        $builder = new Builder($this);

        $section->build($builder, $options);

        if ($content && count($builder->getNames())) {
            $section->setChildren($this->reader->getSections($content, $builder));
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
        $this->reader = $this->container->get("commtool_template_reader");
    }

    public function getValidTypes()
    {
        return $this->validTypes;
    }

}
