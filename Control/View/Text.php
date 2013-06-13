<?php

namespace Optime\Bundle\CommtoolBundle\Control\View;

use Optime\Bundle\CommtoolBundle\Control\View\ViewInterface;

class Text implements ViewInterface
{

    /**
     * Nombre unico de la sección
     */
    public function getName();

    public function getType();

    public function readOnly();

    public function getValue();
}
