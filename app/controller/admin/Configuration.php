<?php

/**
 * @author Tibelian
 * @see www.tibelian.com
 */

namespace App\Controller\Admin;

use App\Controller\Http\Response;
use App\Controller\Http\Request;
use App\Model\DataBase;
use App\Model\WebSite;
use App\Model\Session;
use App\Model\Theme;
use App\Model\User;

class Configuration {
    
    public function show(): void {

        Response::ok();
        Theme::change("administrator", false);
        Response::write(
            Theme::getTemplate()->render(
                'configuration.twig', 
                [
                    'website' => new WebSite(), 
                    'session' => new Session(),
                    'currentPage' => 'configuration'
                ]
            )
        );
        
    }

    public function do(): void {

        Response::ok();

        $request = new Request();
        if(!$request->issetPOST(['title', 'url', 'favicon', 'theme', 'cdn', 'admin_email'])) {
            Response::showJson([
                'status' => 'error',
                'message' => 'Debes completar todos los campos obligatorios.'
            ]);
            return;
        }

        $data = $request->getPOST();
        $configFile = DataBase::load('website/config');

        $configFile['title'] = $data['title'];
        $configFile['url'] = $data['url'];
        $configFile['favicon'] = $data['favicon'];
        $configFile['theme'] = $data['theme'];
        $configFile['cdn'] = $data['cdn'];
        $configFile['admin_email'] = $data['admin_email'];

        DataBase::create('website/config', $configFile);

        Response::showJson([
            'status' => 'success',
            'message' => 'La configuración ha sido guardada con éxito.'
        ]);

    }
    
}