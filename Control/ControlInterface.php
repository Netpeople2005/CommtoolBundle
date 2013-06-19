<?php

namespace Optime\Bundle\CommtoolBundle\Control;

use Optime\Bundle\CommtoolBundle\Builder\BuilderInterface;
use Optime\Bundle\CommtoolBundle\Control\View\ViewInterface;

/**
 * Define una sección del Elemento Editable.
 * Puede contener desde el propio elemento hasta un subelemento cualquiera.
 */
interface ControlInterface
{

    /**
     * Devuelve el nombre que identifica la sección que maneja el control
     */
    public function getName();

    /**
     * Crea como tal el control y sus subcontroles.
     * @param type $builder
     * @param array $options opciones adicionales del template
     */
    public function build(BuilderInterface $builder, array $options = array());

    /**
     * Devuelve el valor inicial que tendrá la sección.
     */
    public function getDefaultValue();

    /**
     * Devuelve el valor actual de la sección.
     */
    public function getValue();

    public function setValue($value);

    public function getIdentifier();

    public function getIndex();

    public function setIndex($id);

    public function setIdentifier($identifier);

    public function getChildren();

    public function setChildren(array $children);

    public function getSelector($useParent = true);

    public function getParent();

    public function setParent(ControlInterface $parent);

    public function getOptions($name = null);

    public function setOptions(array $options);
}