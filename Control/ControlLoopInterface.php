<?php

namespace Optime\Bundle\CommtoolBundle\Control;

use Optime\Bundle\CommtoolBundle\Control\ControlInterface;

/**
 * Al implementarse está interfaz estamos indicando que nuestro el contenido de dicho
 * control se repetirá tantas veces como valores contenga el mismo.
 * 
 * ejemplo:
 * 
 * <div class="loop">
 *      <p><span class="singleline">1</span></p>
 * </div>
 * 
 * si el valor del control es:
 * 
 * array(1,2,3)
 * 
 * el contenido deberá ser:
 * 
 * <div class="loop">
 *      <p><span class="singleline">1</span></p>
 *      <p><span class="singleline">2</span></p>
 *      <p><span class="singleline">3</span></p>
 * </div>
 * 
 */
interface ControlLoopInterface
{

    /**
     * @return ControlInterface $control
     */
    public function getPrototype();
}
