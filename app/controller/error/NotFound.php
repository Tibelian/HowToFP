<?php

/**
 * @author Tibelian
 * @see www.tibelian.com
 */

namespace App\Controller\Error;

use App\Controller\Http\Response;
use App\Controller\Http\Request;
use App\Model\WebSite;
use App\Model\Session;
use App\Model\Theme;

class NotFound {
    
    public function show(): void {
        
        Response::notFound();
        Response::write(
            Theme::getTemplate()->render(
                '404.twig', 
                [
                    'website' => new WebSite(),
                    'session' => new Session()
                ]
            )
        );

    }
    
}
