<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Extension;

/**
 * Description of WidgetManager
 *
 * @author Lim Afriyadi <lim.afriyadi@rajawalisoftware.com>
 */
interface ExtensionInterface
{
    public function getName();
    public function getContent();
    public function getCode();
    public function render($options);
}