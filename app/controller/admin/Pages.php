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

class Pages {
    
    public function showHome(): void {

        Response::ok();
        Theme::change("administrator", false);
        Response::write(
            Theme::getTemplate()->render(
                'pages/home.twig', 
                [
                    'website' => new WebSite(), 
                    'session' => new Session(),
                    'currentPage' => 'pages/home'
                ]
            )
        );
        
    }
    
    public function showAboutUs(): void {

        Response::ok();
        Theme::change("administrator", false);
        Response::write(
            Theme::getTemplate()->render(
                'pages/about-us.twig', 
                [
                    'website' => new WebSite(), 
                    'session' => new Session(),
                    'currentPage' => 'pages/about-us'
                ]
            )
        );
        
    }
    
    public function showContact(): void {

        Response::ok();
        Theme::change("administrator", false);
        Response::write(
            Theme::getTemplate()->render(
                'pages/contact.twig', 
                [
                    'website' => new WebSite(), 
                    'session' => new Session(),
                    'currentPage' => 'pages/contact'
                ]
            )
        );
        
    }
    
}