<?php

namespace Optime\Bundle\CommtoolBundle\Builder;

interface BuilderInterface
{

    public function add($section, array $options = array());
    
    public function getSections();
    public function getNames();
}
