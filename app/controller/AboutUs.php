<?php

/**
 * @author Tibelian
 * @see www.tibelian.com
 */

namespace App\Controller;

use App\Model\WebSite;
use App\Model\Session;
use App\Model\Theme;

class AboutUs {
    
    public function show(): void {
        
        echo Theme::getTemplate()->render(
                'about-us.twig', 
                [
                    'website' => new WebSite(), 
                    'session' => new Session(),
                    'currentPage' => 'about-us'
                ]
        );
        
    }
    
}
