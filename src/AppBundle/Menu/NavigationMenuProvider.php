<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Menu;

use Knp\Menu\Provider\MenuProviderInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Menu\FactoryInterface;
use Symfony\Cmf\Api\Slugifier\SlugifierInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of NavigationMenuProvider
 *
 * @author Lim Afriyadi <lim.afriyadi@rajawalisoftware.com>
 */
class NavigationMenuProvider implements MenuProviderInterface
{
    private $om;
    private $menuFactory;
    private $slugifier;
    
    public function __construct(ObjectManager $om, FactoryInterface $factory, 
            SlugifierInterface $slugifier)
    {
        $this->om = $om;
        $this->menuFactory = $factory;
        $this->slugifier = $slugifier;
    }
    
    public function get($name, array $options = array())
    {
        if($name === 'navigation') {
            return $this->getNavigationMenuItems();
        }
    }

    public function has($name, array $options = array())
    {
        return $name === 'navigation';
    }
    
    private function getNavigationMenuItems()
    {
        $root = $this->menuFactory->createItem('root');
        $parent = $this->om->find(null, "/cms/pages");
        $pages = $parent->getChildren();
        $items  = array();
        foreach($pages as $page) {
            /* @var $page Page */
            $title = $page->getTitle();
            $root->addChild($this->menuFactory->createItem($title, array(
                'uri' => $this->slugifier->slugify($title)
            )));
        }
        
        return $root;
    }
}