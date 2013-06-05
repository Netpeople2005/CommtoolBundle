<?php

namespace Optime\Bundle\CommtoolBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    public function indexAction($name = 'Manuel')
    {
        $html = $this->render('OptimeCommtoolBundle::template_test.html.twig')->getContent();
        
        
        
        $t = $this->get('commtool_template_factory')
                ->create(new \Optime\Bundle\CommtoolBundle\CampaignSection(), $html);

        var_dump($t->getSections());

        die;

        return $this->render('OptimeCommtoolBundle:Default:index.html.twig', array('name' => $name));
    }

}