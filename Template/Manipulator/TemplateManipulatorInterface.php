<?php

namespace Optime\Bundle\CommtoolBundle\Template\Manipulator;

use Optime\Bundle\CommtoolBundle\Section\SectionInterface;
use Optime\Bundle\CommtoolBundle\Builder\BuilderInterface;

interface TemplateManipulatorInterface
{

    const SELECTOR_ELEMENT = 'section';

    /**
     * Establece el contenido en el manejador.
     * @param mixed $content
     */
    public function setContent($content);

    /**
     * Devuelve el contenido actual del manejador.
     * @return mixed 
     */
    public function getContent();

    /**
     * Carga en la sección, el valor de este, actualmente representado en el contenido actual 
     * del manipulador
     * @param SectionInterface $section
     */
    public function load(SectionInterface $section);

    /**
     * Guarda en el content actual, el valor de la sección.
     * @param \Optime\Bundle\CommtoolBundle\Section\SectionInterface $section
     */
    public function save(SectionInterface $section);

    /**
     * Verifica la existencia de la sección en el content actual
     * @param \Optime\Bundle\CommtoolBundle\Section\SectionInterface $section
     * @return boolean
     */
    public function exists(SectionInterface $section);

    /**
     * Crea secciones a partir de los tipos especificados en el builder.
     * @param \Optime\Bundle\CommtoolBundle\Builder\BuilderInterface $builder
     * @return array arreglo con las secciones creadas.
     */
    public function createSections(BuilderInterface $builder);
}