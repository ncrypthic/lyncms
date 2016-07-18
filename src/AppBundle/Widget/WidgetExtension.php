<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Widget;

use AppBundle\Extension\ExtensionInterface;

/**
 * Description of WidgetExtension
 *
 * @author Lim Afriyadi <lim.afriyadi@rajawalisoftware.com>
 */
class WidgetExtension implements ExtensionInterface
{
    public function getContent()
    {
        
    }

    public function getName()
    {
        return 'widget';
    }

    public function getCode()
    {
        return "widget";
    }

    public function render($options)
    {
        
    }

}