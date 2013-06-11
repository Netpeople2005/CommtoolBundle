<?php

namespace Optime\Bundle\CommtoolBundle\Control;

use Optime\Bundle\CommtoolBundle\Control\AbstractControl;
use Optime\Bundle\CommtoolBundle\Builder\BuilderInterface;
use Optime\Bundle\CommtoolBundle\Template\Manipulator\TemplateManipulatorInterface;

class Loop extends AbstractControl
{

    /**
     *
     * @var TemplateManipulatorInterface
     */
    protected $manipulator;

    public function __construct(TemplateManipulatorInterface $manipulator)
    {
        //$this->manipulator = $manipulator;
    }

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

    public function getSelector()
    {
        return parent::getSelector() . '.' . $this->getOptions('selector');
    }

}