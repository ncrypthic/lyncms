<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of HomepageController
 *
 * @author Lim Afriyadi <lim.afriyadi@rajawalisoftware.com>
 */
class HomepageController extends Controller
{
    public function indexAction(Request $req)
    {
        $om = $this->get('doctrine_phpcr')->getManager();
        $homepage = $om->find("AppBundle\Document\Page", $this->getParameter("app.homepage_path") );
        return $this->render("::page/index.html.twig", array(
            'page' => $homepage
        ));
    }
}