<?php

namespace Optime\Bundle\CommtoolBundle;

use Optime\Bundle\CommtoolBundle\Builder\BuilderInterface;

/**
 * Definición de un Commtool
 * Esta clase contendrá los controles de cada sección del template, contendrá el contenido
 * html del template, permitirá indicar y configurar como y cuales secciones serán leidas
 * del template.
 * 
 * @author Manuel Aguirre <programador.manuel@gmail.com>
 */
interface CommtoolBuilderInterface
{

    /**
     * En este método se definiran los controles que usará el commtool, y a la vez
     * dependiendo de los controles agregados al builder, el commtool sabrá que secciones
     * leerá del template.
     * 
     * @param \Optime\Bundle\CommtoolBundle\Builder\BuilderInterface $builder
     * @param array $options
     */
    public function build(BuilderInterface $builder, array $options = null);

    public function setContent($content);

    public function getContent();

    /**
     * Devuelve un control a partir de si id
     * @param string $id
     * @param array $controls
     * @return Control\ControlInterface
     */
    public function getControl($id, array $controls = array());

    /**
     * Devuelve los controles
     * @return array
     */
    public function getControls();
    /**
     * Establece los controles que tendrá en commtool
     * @param array $controls
     */
    public function setControls(array $controls);

    /**
     * Permite establecer los valores para los controles
     * @param array $data
     */
    public function setValues($data);

    public function getValues();

    /**
     * Permite definir que archivo twig será usado para crear los controles en la vista
     * 
     * @return string el archvio twig a usar, ejemplo: MiBundle:Carpeta:archivo.html.twig
     */
    public function getLayout();
}