<?php

namespace Optime\Bundle\CommtoolBundle\Builder;

use Optime\Bundle\CommtoolBundle\Section\SectionInterface;

interface BuilderInterface
{

    /**
     * 
     * @param type $name
     * @param array $options
     * @return BuilderInterface
     */
    public function add($name, array $options = array());

    public function setSections(array $sections);

    public function getSections();

    public function getNames();

    /**
     * @return SectionInterface
     */
    public function getSection();
}
