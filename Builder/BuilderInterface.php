<?php

namespace Optime\Bundle\CommtoolBundle\Builder;

use Optime\Bundle\CommtoolBundle\Control\ControlInterface;
use Optime\Bundle\CommtoolBundle\ControlFactory;

interface BuilderInterface
{

    /**
     * 
     * @param type $sectionName
     * @param array $options
     * @return BuilderInterface
     */
    public function add($sectionName, array $options = array());

    /**
     * @return ControlInterface
     */
    public function getControl();

    public function getPrototypes();

    /**
     * @return ControlFactory
     */
    public function getFactory();
}
