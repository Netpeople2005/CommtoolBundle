<?php

namespace Optime\Bundle\CommtoolBundle\Reader;

use Optime\Bundle\CommtoolBundle\TemplateInterface;

interface ReaderInterface
{

    public function getSections($content, array $names);
}