<?php

namespace Optime\Bundle\CommtoolBundle\Section;

use Optime\Bundle\CommtoolBundle\Section\AbstractSection;
use Optime\Bundle\CommtoolBundle\Template\Manipulator\TemplateManipulatorInterface;

class Loop extends AbstractSection
{

    /**
     *
     * @var TemplateManipulatorInterface
     */
    protected $manipulator;

    public function __construct(TemplateManipulatorInterface $manipulator)
    {
        $this->manipulator = $manipulator;
    }

    public function build(\Optime\Bundle\CommtoolBundle\Builder\BuilderInterface $builder, array $options = array())
    {
        if (!isset($options['type'])) {
            throw new \Exception("Se debe especificar el atributo type en las opciones de la sección de tipo loop");
        }

        $type = $options['type'];

        $builder->add($type);
    }

    public function getName()
    {
        return 'loop';
    }

}