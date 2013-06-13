<?php

namespace Optime\Bundle\CommtoolBundle\Control\View;

interface ViewInterface
{

    public function addChild(ViewInterface $view);
    public function getId();
}
