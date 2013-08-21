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
     * 
     * @param type $name
     * @param type $sectionName
     * @param array $options
     * @return BuilderInterface
     */
    public function addNamed($name, $sectionName, array $options = array());

    /**
     * @return ControlInterface
     */
    public function getControl();

    /**
     * @return ControlFactory
     */
    public function getFactory();

    public function createControls($templateSections);

    public function hasControls();
}
