<?php

namespace Optime\Bundle\CommtoolBundle;

use Optime\Bundle\CommtoolBundle\Section\SectionInterface;

interface TemplateInterface
{

    public function getContent();

    public function getSections();

    public function getSectionNames();

    public function setSectionNames(array $names);

    public function setSections(array $sections);

    public function addSection(SectionInterface $section);
}