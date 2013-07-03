<?php

namespace Optime\Bundle\CommtoolBundle;

use Optime\Bundle\CommtoolBundle\Builder\BuilderInterface;

interface CommtoolBuilderInterface
{

    public function build(BuilderInterface $builder, array $options = null);

    public function setContent($content);

    public function getContent();

    /**
     * 
     * @param type $id
     * @param array $controls
     * @return Control\ControlInterface
     */
    public function getControl($id, array $controls = array());

    public function getControls();

    public function setControls(array $controls);

    public function setValues($data);

    public function getValues();

    public function getLayout();
}