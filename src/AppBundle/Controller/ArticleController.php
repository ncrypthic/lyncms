<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Document\Article;

/**
 * Description of ArticleController
 *
 * @author Lim Afriyadi <lim.afriyadi@rajawalisoftware.com>
 */
class ArticleController extends FOSRestController
{
    public function getArticlesAction()
    {
        $manager = $this->get('doctrine_phpcr')->getManager();
        $repo    = $manager->getRepository('AppBundle:Article');
        $parent  = $manager->find(null, "/cms/articles");

        return array_values($parent->getChildren()->toArray());
    }
    
    public function getArticleAction($id)
    {
        $manager = $this->get('doctrine_phpcr')->getManager();
        $repo    = $manager->getRepository('AppBundle:Article');
        
        return $repo->find("/cms/articles/{$id}", "AppBundle:Article");
    }
    
    /**
     * 
     * @param Request $req
     * @param ParamFetcher $fetcher
     */
    public function postArticleAction(Request $req)
    {
        $payload = json_decode($req->getContent());
        $article = new Article();
        $manager = $this->get('doctrine_phpcr')->getManager();
        $repo    = $manager->getRepository('AppBundle:Article');
        $parent  = $repo->find('/cms/articles', 'AppBundle:Article');
        $article->setContent($payload->content);
        $article->setTitle($payload->title);
        $article->setParentDocument($parent);
        $manager->persist($article);
        $manager->flush();
        
        return $article;
    }
    
    public function putArticleAction(Request $req, $title)
    {
        $payload = json_decode($req->getContent());
        $manager = $this->get('doctrine_phpcr')->getManager();
        $repo    = $manager->getRepository('AppBundle:Article');
        $article = $repo->find("/cms/articles/".$title);
        $parent  = $repo->find('/cms/articles', 'AppBundle:Article');
        $article->setContent($payload->content);
        $article->setTitle($payload->title);
        $article->setParentDocument($parent);
        $manager->persist($article);
        $manager->flush();
        
        return $article;
    }
    
    public function viewArticleAction($contentDocument)
    {
        return $this->render('::article/detail.html.twig', array(
            'article' => $contentDocument
        ));
    }
}