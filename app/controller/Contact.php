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

class Contact {
    
    public function show(): void {
        
        Response::ok();
        Response::write(
            Theme::getTemplate()->render(
                'contact.twig', 
                [
                    'website' => new WebSite(), 
                    'session' => new Session(),
                    'currentPage' => 'contact'
                ]
            )
        );
        
    }
    
}
