<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Extension;

/**
 * CMS extension manager
 *
 * @author Lim Afriyadi <lim.afriyadi@rajawalisoftware.com>
 */
class Manager
{
    private $extensions;
    
    public function __construct()
    {
        $this->extensions = array();
    }
    
    public function registerExtension(ExtensionInterface $extension)
    {
        $extName = $extension->getName();
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
    
    public function parse($text)
    {
        return preg_replace_callback(":[a-zA-Z0-9_-\.]+:", function(){
            
        }, $text);
    }
}