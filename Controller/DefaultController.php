<?php

namespace Optime\Bundle\CommtoolBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    public function indexAction($name = 'Manuel')
    {
        $html = $this->render('OptimeCommtoolBundle::template_test.html.twig')->getContent();
        $this->get('commtool_template_factory')->create('singleline', $html);
//
//        $t = new \Optime\Bundle\CommtoolBundle\Template();
//        
//        $t->setContent($html);
//        
//        $r = new \Optime\Bundle\CommtoolBundle\Reader\PhpQueryReader();
//        
//        $r->setTemplate($t);
//        
//        var_dump($r->getSections());

        die;

        return $this->render('OptimeCommtoolBundle:Default:index.html.twig', array('name' => $name));
    }

}