<?php

namespace Optime\Bundle\CommtoolBundle;

use Optime\Bundle\CommtoolBundle\Section\SectionInterface;

interface TemplateInterface
{

    public function setContent($content);
    public function getContent();

    public function getSections();

    public function setSections(array $sections);

    public function setValues($data);

    public function getValues();
}