<?php

namespace Optime\Bundle\CommtoolBundle\Builder;

use Optime\Bundle\CommtoolBundle\Control\ControlInterface;

interface BuilderInterface
{

    /**
     * 
     * @param type $sectionName
     * @param array $options
     * @return BuilderInterface
     */
    public function add($sectionName, array $options = array());

    public function setControls(array $sections);

    public function getControls();

    public function getSections();

    /**
     * @return ControlInterface
     */
    public function getControl();
    
    public function getPrototypes();
}
