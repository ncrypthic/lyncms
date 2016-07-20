<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * Description of ExtensionPass
 *
 * @author Lim Afriyadi <lim.afriyadi@rajawalisoftware.com>
 */
class ExtensionPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $manager    = $container->getDefinition("app_bundle.extension_manager");
        $extensions = $container->findTaggedServiceIds("app.extension");
        foreach($extensions as $name=>$def) {
            $manager->addMethodCall("registerExtension", array($container->getDefinition($name)));
        }
    }
}