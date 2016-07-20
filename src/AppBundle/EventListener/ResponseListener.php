<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\EventListener;

use AppBundle\Extension\Manager as ExtensionManager;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

/**
 * Description of ResponseListener
 *
 * @author Lim Afriyadi <lim.afriyadi@rajawalisoftware.com>
 */
class ResponseListener
{
    /**
     * @var ExtensionManager
     */
    private $manager;
    
    public function __construct(ExtensionManager $manager, \Twig_Environment $twig)
    {
        $this->manager = $manager;
        $this->manager->setTwig($twig);
    }
    
    public function onResponse(FilterResponseEvent $evt)
    {
        $contentType = $evt->getResponse()->headers->get("Content-Type");
        if($contentType !== 'application/json' && $contentType !== 'text/json') {
            $content = $evt->getResponse()->getContent();

            $evt->getResponse()->setContent($this->manager->compile($content));
        }
    }
}