<?php

namespace Optime\Bundle\CommtoolBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Optime\Bundle\CommtoolBundle\CampaignCommtool;

class DefaultController extends Controller
{

    public function indexAction()
    {
        $commtool = new CampaignCommtool();

        $template = $this->getDoctrine()
                ->getManager()
                ->getRepository('CommtoolTemplateBundle:Template')
                ->find(7);

        $this->get('commtool_factory')->create($commtool, $template);

        $c = $commtool->getControls();
//        echo "<pre>";
//        print_r($template->getValues());

        $data = array(
            'singleline' => array('Primer Singleline', 'Segundo Singleline'),
            'product' => array(
                array(
                    'singleline' => array('Primer producto con su primer singleline', 'Primer producto con su segundo singleline'),
                ),
                array(
                    'singleline' => array('Segundo producto con su primer singleline'),
                    'multiline' => array('Segundo producto con su primer multiline'),
                ),
            ),
            'loop_sin' => array(
                array(
                    'singleline' => array('Loop Sin con primer Singleline')
                ),
                array(
                    'singleline' => array('Loop Sin con segundo Singleline')
                ),
            ),
            'loop_pro' => array(
                array(
                    'product' => array(
                        array(
                            'singleline' => array('Loop Pro con su primer singleline'),
                        ),
                    )
                ),
                array(
                    'product' => array(
                        array(
                            'singleline' => array('Loop Pro con su segundo singleline'),
                        ),
                    )
                ),
            ),
        );

        $commtool->setValues($data);

        echo "<pre>";
        print_r($commtool->getValues());
        echo "</pre>";

        return $this->render('OptimeCommtoolBundle:Default:index.html.twig', array(
                    'template' => $commtool,
        ));
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