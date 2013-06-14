<?php

namespace Optime\Bundle\CommtoolBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Optime\Bundle\CommtoolBundle\CampaignTemplate;

class DefaultController extends Controller
{

    public function indexAction()
    {

        $html = $this->render('OptimeCommtoolBundle::template_test.html.twig')->getContent();
        
        $template = new CampaignTemplate();
        
        $this->get('commtool_template_factory')->create($template, $html);
        
        $c = $template->getControls();
        
        var_dump($c['product'][0]);

       
        return $this->render('OptimeCommtoolBundle:Default:index.html.twig', array('content' => $html));
    }

    public function updateSectionsAction()
    {
        $html = $this->render('OptimeCommtoolBundle::template_test.html.twig')->getContent();

//        $todo = \phpQuery::newDocument('<span>hola</span><div>parrafo<p>Mi Div</p></div>');
//        
//        var_dump($todo['span']->html());
//        
//        $div = $todo['div'];
//        
//        var_dump($div->html());
//        
//        $p = $div['p'];
//        
//        var_dump($p->html());
//
//        die;


        $this->get('commtool_template_factory')
                ->create($t = new \Optime\Bundle\CommtoolBundle\CampaignTemplate(), $html);

        $data = array(
            '001' => 'Hola Men',
            '002' => array(
                'singleline_0' => 'Manuel',
                'singleline_1' => ':-) Otro Mas',
            ),
            '003' => array(
                'p1' => 'Manuel :-)',
            ),
            '005' => array(
                'product_0' => array(
                    'singleline_0' => 'Ese es el Peo',
                ),
                'product_1' => array(
                    'singleline_0' => 'QUE BIEN VALE',
                ),
            ),
        );

        var_dump($t->getValues());
        $t->setValues($data);
        var_dump($t->getValues());
        $this->get('commtool_manipulator')->save($t);

        $r = $t->getControls();

//        var_dump($r['002']->getChildren());
//        var_dump($r['005']->getChildren());


        return $this->render('OptimeCommtoolBundle:Default:index.html.twig', array(
                    'template' => $this->get('commtool_template_factory')->createView($t),
        ));
    }

}