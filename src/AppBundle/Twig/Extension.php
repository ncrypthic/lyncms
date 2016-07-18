<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Twig;

/**
 * Description of Extension
 *
 * @author Lim Afriyadi <lim.afriyadi@rajawalisoftware.com>
 */
class Extension extends \Twig_Extension
{
    public function getName()
    {
        return "cms";
    }
    
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter($name, $callable)
        );
    }
}