<?php

namespace Optime\Bundle\CommtoolBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    public function indexAction($name = 'Manuel')
    {
        $html = $this->render('OptimeCommtoolBundle::template_test.html.twig')->getContent();
        
        
        $t = $this->get('commtool_template_factory')
                ->create(new \Optime\Bundle\CommtoolBundle\CampaignTemplate(), $html);
        
        $r = $t->getControls();
//        var_dump($t);
        var_dump($r);
//        var_dump(end($r)->getChildren());

//        $this->get('commtool_template_writer')->replace($t, array(
//            '002' => "Este es el nuevo valor :-)",
//        ));
//        
//        var_dump($t->getContent());
        
        die;

        return $this->render('OptimeCommtoolBundle:Default:index.html.twig', array('name' => $name));
    }

}