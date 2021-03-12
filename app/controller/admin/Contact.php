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
                    'mail' => DataBase::load('website/mailer'),
                    'messages' => DataBase::load('messages')
                ]
            )
        );
        
    }

    public function do(): void {

        Response::ok();

        $request = new Request();
        if(!$request->issetPOST(['name', 'host', 'user', 'password', 'port', 'smtp', 'smtp_secure'])) {
            Response::showJson([
                'status' => 'error',
                'message' => 'Debes completar todos los campos obligatorios.'
            ]);
            return;
        }

        $data = $request->getPOST();
        $configFile = DataBase::load('website/mailer');

        $configFile['name'] = $data['name'];
        $configFile['host'] = $data['host'];
        $configFile['user'] = $data['user'];
        $configFile['password'] = $data['password'];
        $configFile['port'] = $data['port'];
        $configFile['smtp'] = $data['smtp'];
        $configFile['smtp_secure'] = $data['smtp_secure'];

        DataBase::create('website/mailer', $configFile);

        Response::showJson([
            'status' => 'success',
            'message' => 'Los datos del contacto han sido guardados con éxito.'
        ]);

    }
    
}