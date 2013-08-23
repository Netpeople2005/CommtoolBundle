<?php

namespace Optime\Bundle\CommtoolBundle\Template\Manipulator;

use Optime\Bundle\CommtoolBundle\CommtoolBuilderInterface;
use Optime\Bundle\CommtoolBundle\Control\ControlInterface;

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
     * Genera un html donde los valores de las secciones son los de los controles
     * del CommtoolBuilderInterface;
     * @param CommtoolBuilderInterface $template
     * @return string Html generado
     */
    public function generate(CommtoolBuilderInterface $template);

}