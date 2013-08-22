<?php

namespace Optime\Bundle\CommtoolBundle;

use Optime\Bundle\CommtoolBundle\CommtoolBuilderInterface;

/**
 * Esta es la clase base de todos los commtools,
 * Mediante la misma se definen la secciones que serán leidas de los 
 * templates y las estrategias usadas para dichas lecturas.
 * 
 * @author Manuel Aguirre <programador.manuel@gmail.com>
 */
abstract class AbstractCommtoolBuilder implements CommtoolBuilderInterface
{

    /**
     * Contenido del Template
     * @var type 
     */
    protected $content;

    /**
     * Controles que se crearón a partir de las secciones del template.
     * @var type 
     */
    protected $controls = array();

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getControls()
    {
        return $this->controls;
    }

    public function setControls(array $controls)
    {
        $this->controls = $controls;
    }

    public function getValues()
    {
        $values = array();
        foreach ($this->getControls() as $index => $control) {
            $values[$control->getIdentifier()] = $control->getValue();
//            $values[$index] = $control->getValue();
        }

        return $values;
    }

    public function setValues($data)
    {
        foreach ($this->getControls() as $index => $control) {
            $id = $control->getIdentifier();
            $sectionName = $control->getSectionName();
            if (!$control->isReadOnly()) {
                if (array_key_exists($id, $data)) {
                    /*
                     * Acá se setea el valor en base al identificador
                     * del elemento en la BD.
                     */
                    $control->setValue($data[$id]);
                } elseif ($sectionName && array_key_exists($sectionName, $data)) {
                    /*
                     * aca se setea el valor en base al nombre
                     * que se le da a la seccion en el html,
                     * ejemplo:
                     * {{ section_singleline("titulo") }}
                     * 
                     * si el $sectionName contiene el string titulo
                     * entonces se pasa su valor al control.
                     */
                    $control->setValue($data[$sectionName]);
                } elseif (array_key_exists($index, $data)) {
                    /*
                     * esto es una funcionalidad que permite
                     * setear el valor en base al indice del control
                     * en el arreglo donde se encuentra contenido
                     * se debe usar con mucho cuidado.
                     */
                    $control->setValue($data[$index]);
                }
            }
        }
    }

    public function getLayout()
    {
        return 'OptimeCommtoolBundle::commtool_layout.html.twig';
    }

    public function getControl($id, array $controls = null)
    {
        if (null === $controls) {
            $controls = $this->getControls();
        }

        foreach ($controls as $control) {
            if ($id === $control->getIdentifier()) {
                return $control;
            }
            if (null !== $result = $this->getControl($id, $control->getChildren())) {
                return $result;
            }
        }

        return null;
    }

}