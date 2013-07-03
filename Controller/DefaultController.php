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
                ->find(1);

        $data = array(
            's_4' => array(
                array('s_5' => 'Primer Producto'),
                array('s_5' => 'Segundo Producto'),
            ),
        );

        $this->get('commtool_factory')->create($commtool, $template, array(
                'data' => $data,
        ));

        $c = $commtool->getControls();
//        var_dump($c);
//          var_dump($c[3]->getChildren());
        $v = $commtool->getValues();
        var_dump($v);
        var_dump($v['s_4'][0]);
//        die;
//        var_dump(end($v));
//        $commtool->setValues($data);
//        var_dump($commtool->getValues());
//        die;
//        die;
        //$commtool->setValues($data);

        return $this->render('OptimeCommtoolBundle:Default:index.html.twig', array(
                    'template' => $commtool,
        ));
    }

    public function updateSectionsAction()
    {
//        $html = $this->render('OptimeCommtoolBundle::template_test.html.twig')->getContent();

        return $this->render('OptimeCommtoolBundle:Default:tokens.html.twig');
    }

}