<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Extensions;

use AppBundle\Extension\ExtensionInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Articles extension
 *
 * @author Lim Afriyadi <lim.afriyadi@rajawalisoftware.com>
 */
class ArticleExtension implements ExtensionInterface
{
    private $om;
    
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }
    
    public function getCode()
    {
        return "articles";
    }

    public function getName()
    {
        return "Article Extension";
    }
    
    public function getTemplate()
    {
        return "::article/index.html.twig";
    }
    
    public function getDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array("",""));
    }
    
    public function getContent($options)
    {
        $parent = $this->om->find(null, "/cms/articles");
        
        return $parent->getChildren("AppBundle\Document\Article");
    }
}