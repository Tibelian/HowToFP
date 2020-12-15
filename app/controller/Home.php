<?php

/**
 * @author Tibelian
 * @see www.tibelian.com
 */

namespace App\Controller;

use App\Controller\Http\Response;
use App\Controller\Http\Request;
use App\Model\WebSite;
use App\Model\Session;
use App\Model\Theme;

class Home {
    
    public function show(): void {
        
        Response::ok();
        Response::write(
            Theme::getTemplate()->render(
                'home.twig', 
                [
                    'website' => new WebSite(), 
                    'session' => new Session()
                ]
            )
        );
        
    }
    
}
