<?php

namespace Optime\Bundle\CommtoolBundle\Control;

use Optime\Bundle\CommtoolBundle\Builder\BuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Define una sección del Elemento Editable.
 * Puede contener desde el propio elemento hasta un subelemento cualquiera.
 */
interface ControlInterface
{

    /**
     * Devuelve el nombre que identifica la sección que maneja el control, y puede variar.
     */
    public function getName();

    /**
     * Devuelve el tipo de sección, para una sección de un tipo definido no cambiará jamas.
     */
    public function getType();

    /**
     * Crea como tal el control y sus subcontroles.
     * @param type $builder
     * @param array $options opciones adicionales del template
     */
    public function build(BuilderInterface $builder, array $options = array());

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

    public function getCompleteType($useName = false);

    public function getParent();

    public function setParent(ControlInterface $parent = null);

    public function getOptions($name = null);

    public function setOptions(array $options);

    public function isReadOnly();

    public function getSectionId();

    public function setSectionId($id);

    public function setDefaultOptions(OptionsResolverInterface $resolver);

    public function getSectionName();
}