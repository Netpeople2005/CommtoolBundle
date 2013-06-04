<?php

namespace Optime\Bundle\CommtoolBundle\Reader;

use Optime\Bundle\CommtoolBundle\TemplateInterface;
use Optime\Bundle\CommtoolBundle\Reader\ReaderInterface;

class PhpQueryReader implements ReaderInterface
{

    protected $template;

    public function getSections()
    {
        $doc = \phpQuery::newDocument($this->template->getContent()); //obtengo la instancia del phpQuery para el html
        //ahora buscamos las secciones
        $sections = (array) $this->template->getSectionNames();
        $templateSections = array();
        foreach ($sections as $name) {
            $doc[".{$name}"]->each(function($s)use(&$templateSections, $name){
                $templateSections[$name][] = pq($s)->html();
            });
        }

        return $templateSections;
    }

    public function getTemplate()
    {
        return $this->template;
    }

    public function setTemplate(TemplateInterface $template)
    {
        $this->template = $template;
    }

}