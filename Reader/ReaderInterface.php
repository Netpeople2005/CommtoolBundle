<?php

namespace Optime\Bundle\CommtoolBundle\Reader;

use Optime\Bundle\CommtoolBundle\TemplateInterface;

interface ReaderInterface
{

    public function getSections($content);

    public function setTemplate(TemplateInterface $template);

    /**
     * @return TemplateInterface 
     */
    public function getTemplate();
}