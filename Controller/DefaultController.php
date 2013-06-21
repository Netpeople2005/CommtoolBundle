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
                ->find(8);

        $data = array(
            's_sponsor_loop' => array(
                '/commtool/web/bundles/commtooltemplate/images/template_45.jpg',
                '/commtool/web/bundles/commtooltemplate/images/template_43.jpg',
            ),
        );

        $this->get('commtool_factory')->create($commtool, $template, array(
                'data' => $data,
        ));

        $c = $commtool->getControls();
//        var_dump($c);
//        var_dump($c[1]);
        var_dump($commtool->getValues());
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