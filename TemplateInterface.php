<?php

namespace Optime\Bundle\CommtoolBundle;

interface TemplateInterface
{

    public function getContent();

    public function getSections();

    public function getSectionNames();
}