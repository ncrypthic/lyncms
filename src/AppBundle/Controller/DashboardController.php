<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    public function indexAction()
    {
        return $this->render('AppBundle:Dashboard:index.html.twig', array(
            'extensions' => array()
        ));
    }
    
    public function pageEditorAction()
    {
        return $this->render('AppBundle:Dashboard:page_editor.html.twig');
    }
}
