<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Document;

use Symfony\Cmf\Component\Routing\RouteReferrersReadInterface;
use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;

/**
 * Page object
 *
 * @author Lim Afriyadi <lim.afriyadi@rajawalisoftware.com>
 * @PHPCR\Document(referenceable=true)
 */
class Article implements RouteReferrersReadInterface
{
    use ContentTrait;
    
    /**
     * @PHPCR\Date()
     */
    protected $date;

    /**
     * @PHPCR\PrePersist()
     */
    public function updateDate()
    {
        if (!$this->date) {
            $this->date = new \DateTime();
        }
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }
    
    public function getYear()
    {
        return $this->date->format('Y');
    }
    
    public function getMonth()
    {
        return $this->date->format('m');
    }
    
    public function getDay()
    {
        return $this->date->format('d');
    }
}