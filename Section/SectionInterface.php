<?php

namespace Optime\Bundle\CommtoolBundle\Section;

use Optime\Bundle\CommtoolBundle\Writer\WriterInterface;
use Optime\Bundle\CommtoolBundle\Builder\BuilderInterface;

/**
 * Define una sección del Elemento Editable.
 * Puede contener desde el propio elemento hasta un subelemento cualquiera.
 */
interface SectionInterface
{

    /**
     * Devuelve el nombre que identifica a la sección
     */
    public function getName();

    /**
     * Crea como tal la sección y sus subsecciones.
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

    public function setIdentifier($identifier);

    public function getChildren();

    public function setChildren(array $children);
}