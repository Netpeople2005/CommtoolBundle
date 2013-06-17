<?php

namespace Optime\Bundle\CommtoolBundle;

use Optime\Bundle\CommtoolBundle\Builder\BuilderInterface;

interface CommtoolBuilderInterface
{

    public function build(BuilderInterface $builder, array $options = array());

    public function setContent($content);

    public function getContent();

    public function getControls();

    public function setControls(array $controls);

    public function setValues($data);

    public function getValues();
}