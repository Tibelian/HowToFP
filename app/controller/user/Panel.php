<?php

/**
 * @author Tibelian
 * @see www.tibelian.com
 */

namespace App\View\User;

use App\Model\WebSite;
use App\Model\Session;

class Panel {
    
    public function show(): void {

        // get all the required data
        $status = \App\Controller\Web\Status::getAll();
        $account = Session::getUser();

        // render the template and show the result
        echo WebSite::getTemplate()->render(
                'user/panel.twig', 
                [
                    'website' => new WebSite(),
                    'session' => new Session(),
                    'status' => $status,
                    'account' => $account
                ]
        );
        
    }
    
}
