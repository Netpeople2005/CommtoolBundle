<?php

namespace Optime\Bundle\CommtoolBundle\Reader;

use Optime\Bundle\CommtoolBundle\Builder\BuilderInterface;

interface ReaderInterface
{

    public function getSections($content, BuilderInterface $builder);
}