<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Extension;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of WidgetManager
 *
 * @author Lim Afriyadi <lim.afriyadi@rajawalisoftware.com>
 */
interface ExtensionInterface
{
    public function getName();
    public function getCode();
    public function getTemplate();
    public function getContent($options);
    public function getDefaultOptions(OptionsResolver $resolver);
}