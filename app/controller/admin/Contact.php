<?php

/**
 * @author Tibelian
 * @see www.tibelian.com
 */

namespace App\Controller\Admin;

use App\Controller\Http\Response;
use App\Controller\Http\Request;
use App\Model\WebSite;
use App\Model\Session;
use App\Model\Theme;
use App\Model\DataBase;

class Contact {
    
    public function show(): void {

        Response::ok();
        Theme::change("administrator", false);
        Response::write(
            Theme::getTemplate()->render(
                'contact.twig', 
                [
                    'website' => new WebSite(), 
                    'session' => new Session(),
                    'currentPage' => 'contact',
                    'mail' => DataBase::load('website/mailer')
                ]
            )
        );
        
    }
    
}