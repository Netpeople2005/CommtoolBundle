<?php

namespace Optime\Bundle\CommtoolBundle\Template\Manipulator;

use Optime\Bundle\CommtoolBundle\CommtoolBuilderInterface;
use Optime\Bundle\CommtoolBundle\Control\ControlInterface;
use Optime\Bundle\CommtoolBundle\Builder\BuilderInterface;

/**
 * Interfaz que permite leer y escribir partes de un html mediante las secciones
 * 
 * @author Manuel Aguirre <programador.manuel@gmail.com>
 */
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
     * @param ControlInterface $section
     */
    public function load(ControlInterface $control);

    /**
     * Guarda en el content actual, el valor de la sección.
     * @param \Optime\Bundle\CommtoolBundle\Control\ControlInterface $section
     */
    public function save(CommtoolBuilderInterface $template);

    public function saveControl(ControlInterface $control, &$content);

    /**
     * Verifica la existencia de la sección en el content actual
     * @param \Optime\Bundle\CommtoolBundle\Control\ControlInterface $section
     * @return boolean
     */
    public function exists(ControlInterface $section);

    /**
     * Crea secciones a partir de los tipos especificados en el builder.
     * @param \Optime\Bundle\CommtoolBundle\Builder\BuilderInterface $builder
     * @param \Optime\Bundle\CommtoolBundle\Control\ControlInterface $parent si se especifica, crea las secciones a partir de esa sección
     * @return array arreglo con las secciones creadas.
     */
    public function createControls(BuilderInterface $builder, ControlInterface $parent = null);

    public function prepareContentView(CommtoolBuilderInterface $template, array $controlViews);
}