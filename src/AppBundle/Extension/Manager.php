<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Extension;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * CMS extension manager
 *
 * @author Lim Afriyadi <lim.afriyadi@rajawalisoftware.com>
 */
class Manager
{
    /**
     * @var array
     */
    private $extensions;
    /**
     * @var \Twig_Environment
     */
    private $twig;
    
    public function __construct()
    {
        $this->extensions = array();
    }
    
    public function setTwig(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }
    
    public function registerExtension(ExtensionInterface $extension)
    {
        $extName = $extension->getCode();
        if(isset($this->extensions[$extName])) {
            $msg = sprintf("Cannot register '%s' extension because it was already registered", $extName);
            throw new \InvalidArgumentException($msg);
        }
        $this->extensions[$extName] = $extension;
        
        return $this;
    }
    
    public function getExtensions()
    {
        return $this->extensions;
    }
    
    public function compile($text)
    {
        $codes           = array_keys($this->extensions);
        $patterns        = array();
        $resolver        = new OptionsResolver();
        array_walk($codes, function($code) use(&$patterns, $resolver) { 
            $extension = $this->extensions[$code];
            
            $patterns["/:(".$code.")(?:(.*)):/"] = function($match) use($extension, $resolver) {
                $str      = html_entity_decode($match[2]);
                $stripped = str_replace(" ", "", $str);
                $trimmed  = trim($str, "()");
                $arg      = str_getcsv($trimmed);
                $extension->getDefaultOptions($resolver);
                $content  = $extension->getContent($resolver->resolve($arg));
                
                return $this->twig->render($extension->getTemplate(), 
                        array('data' => $content));
            };
        });
        
        return preg_replace_callback_array($patterns, $text);
    }
}