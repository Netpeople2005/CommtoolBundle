<?php

namespace Optime\Bundle\CommtoolBundle\Section;

use Optime\Bundle\CommtoolBundle\Section\SectionInterface;

abstract class AbstractSection implements SectionInterface
{

    protected $value;

    public function getDefaultValue()
    {
        return null;
    }

    public function getValue()
    {
        return $this->value;
    }

}
