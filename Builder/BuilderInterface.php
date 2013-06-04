<?php

namespace Optime\Bundle\CommtoolBundle\Builder;

interface BuilderInterface
{

    public function add($name, array $options = array());
    
    public function getSections();
    public function getNames();
}
