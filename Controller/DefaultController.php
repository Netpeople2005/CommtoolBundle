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
            's_sing_1' => 'Nuevo Valor Singleline',
            's_product_1' => array(
                's_sing_prod_1' => 'Nuevo Singleline dentro de Product'
            ),
        );

        $this->get('commtool_factory')->create($commtool, $template, array(
                //'data' => $data,
        ));

        $c = $commtool->getControls();
//        var_dump($c);
//        var_dump($c[1]);
//        var_$sectiondump($commtool->getValues());
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