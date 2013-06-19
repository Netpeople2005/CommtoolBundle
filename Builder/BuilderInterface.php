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

    /**
     * @return ControlInterface
     */
    public function getControl();

    public function getPrototypes();
}
