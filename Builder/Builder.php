<?php

namespace Optime\Bundle\CommtoolBundle\Builder;

use Optime\Bundle\CommtoolBundle\ControlFactory;
use Optime\Bundle\CommtoolBundle\Builder\BuilderInterface;
use Optime\Bundle\CommtoolBundle\Control\ControlInterface;
use Optime\Commtool\TemplateBundle\Model\SectionConfigInterface;

class Builder implements BuilderInterface
{

    protected $controls = array();

    /**
     *
     * @var ControlFactory
     */
    protected $factory;

    /**
     *
     * @var ControlInterface
     */
    protected $parent;

    function __construct(ControlFactory $factory, ControlInterface $parent = null)
    {
        $this->factory = $factory;
        $this->parent = $parent;
    }

    public function add($section, array $options = array())
    {
        $sectionType = $this->factory->validateControlOrType($section);

        $this->controls[$sectionType] = $options;

        return $this;
    }

    /**
     * 
     * @return ControlInterface
     */
    public function getControl()
    {
        return $this->parent;
    }

    public function getFactory()
    {
        return $this->factory;
    }

    public function createControls($templateSections)
    {
        $controls = array();
        $types = array_keys($this->controls);
        $parent = $this->parent;
        //filtramos solo las secciones que no posean padres en primera instancia.
        $templateSections = array_filter($templateSections->toArray(), function(SectionConfigInterface $sec)
                use ($types, $parent) {
                    if (in_array($sec->getName(), $types)) {
                        if ($secParent = $sec->getParent()) {
                            return $parent and $parent->getIdentifier() === $secParent->getIdentifier();
                        } else {
                            return $parent === null;
                        }
                    }
                    return false;
                });
        foreach ($templateSections as $section) {
            $child = $this->factory->create($section, $this->controls[$section->getName()]);
            $child->setParent($this->getControl());
            $controls[] = $child;
        }
        return $controls;
    }

    public function hasControls()
    {
        return count($this->controls) > 0;
    }

    public function addNamed($name, $sectionType, array $options = array())
    {
        $sectionType = $this->factory->validateControlOrType($sectionType);

        $options['filter_name'] = $name;

        $this->controls[$name . '_' . $sectionType] = $options;

        return $this;
    }

}