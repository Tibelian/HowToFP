<?php

/**
 * @author Tibelian
 * @see www.tibelian.com
 */

namespace App\View\User;

use App\Model\WebSite;
use App\Model\Session;

class Login {
    
    public function show(): void{

        // render the template and show the result
        echo WebSite::getTemplate()->render(
                'user/login.twig', 
                [
                    'website' => new WebSite(),
                    'session' => new Session()
                ]
        );
        
    }
    
}
