<?php

namespace Optime\Bundle\CommtoolBundle\Writer;

use Optime\Bundle\CommtoolBundle\TemplateInterface;
use Optime\Bundle\CommtoolBundle\Writer\WriterInterface;
use Optime\Bundle\CommtoolBundle\Reader\ReaderInterface;
use Optime\Bundle\CommtoolBundle\Section\SectionInterface;

class PhpQueryWriter implements WriterInterface
{

    protected $phpQuery;

//    /**
//     *
//     * @var ReaderInterface
//     */
//    protected $reader;
//
//    public function __construct(ReaderInterface $reader)
//    {
//        $this->reader = $reader;
//    }

    public function replace(TemplateInterface $template, $data)
    {
        $this->setContent($template->getContent());

        $template->setValues($data);

        foreach ($template->getSections() as $section) {
            $this->write($section);
        }

        $template->setContent($this->getContent());
    }

    /**
     * 
     * @param \Optime\Bundle\CommtoolBundle\Section\SectionInterface $section
     * @return \Optime\Bundle\CommtoolBundle\Writer\PhpQueryWriter
     */
    public function write(SectionInterface $section)
    {
        $this->find($section)->html($section->getValue());
        return $this;
    }

    public function getContent()
    {
        return $this->phpQuery->htmlOuter();
    }

    /**
     * 
     * @param type $content
     * @return \Optime\Bundle\CommtoolBundle\Writer\PhpQueryWriter
     */
    public function setContent($content)
    {
        $this->phpQuery = \phpQuery::newDocument($content);
        return $this;
    }
    
    /**
     * 
     * @param \Optime\Bundle\CommtoolBundle\Section\SectionInterface $section
     * @return \phpQueryObject
     */
    protected function find(SectionInterface $section)
    {
        if ($section->getIdentifier()) {
            return $this->phpQuery[".{$section->getName()}[data-section-id={$section->getIdentifier()}]"];
        } else {
            return $this->phpQuery[".{$section->getName()}"];
        }
    }

}