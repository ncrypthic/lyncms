<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Document\Page;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * PageController
 *
 * @author Lim Afriyadi <lim.afriyadi@rajawalisoftware.com>
 */
class PageController extends FOSRestController
{
    public function getPagesAction()
    {
        $om = $this->get('doctrine_phpcr')->getManager();
        $pages = $om->find(null, "/cms/pages");
        
        return array_values($pages->getChildren()->toArray());
    }
    
    /**
     * 
     * @param string $titles
     * @return type
     */
    public function getPageAction($title)
    {
        $om   = $this->get('doctrine_phpcr')->getManager();
        $repo = $om->getRepository('AppBundle:Page');
        
        return $repo->find("/cms/pages/{$title}", "AppBundle:Page");
    }
    
    public function postPageAction(Request $req)
    {
        $om   = $this->get('doctrine_phpcr')->getManager();
        $pages = $om->find(null, "/cms/pages");
        $page = new Page();
        $page->setTitle($req->request->get('title'));
        $page->setParentDocument($pages);
        $page->setContent("");
        $om->persist($page);
        $om->flush();
        
        return $page;
    }
    
    public function deletePageAction($title)
    {
        $om   = $this->get('doctrine_phpcr')->getManager();
        $page = $om->find("AppBundle:Page", "/cms/pages/${title}");
        $om->remove($page);
        $om->flush();
    }
    
    public function viewPageAction($contentDocument)
    {
        return $this->render('::page/index.html.twig', array(
            'page' => $contentDocument
        ));
    }
}