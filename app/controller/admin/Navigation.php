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

class Navigation {
    
    public function show(): void {

        Response::ok();
        Theme::change("administrator", false);
        Response::write(
            Theme::getTemplate()->render(
                'navigation.twig', 
                [
                    'website' => new WebSite(), 
                    'session' => new Session(),
                    'currentPage' => 'navigation'
                ]
            )
        );
        
    }

    public function add(): void {

        Response::ok();

        $request = new Request();
        if(!$request->issetPOST(['title', 'url'])) {
            Response::showJson([
                'status' => 'error',
                'message' => 'Debes completar todos los campos obligatorios.'
            ]);
            return;
        }
        $data = $request->getPOST();

        $newLink = [];
        $newLink['id'] = uniqid();
        $newLink['title'] = $data['title'];
        $newLink['url'] = $data['url'];

        $allLinks = DataBase::load('links');
        $allLinks[] = $newLink;

        DataBase::create('links', $allLinks);

        Response::showJson([
            'status' => 'success',
            'message' => 'El artículo se ha eliminado con éxito.'
        ]);

    }

    public function unLink(): void {

        Response::ok();

        $request = new Request();
        if(!$request->issetPOST(['id'])) {
            Response::showJson([
                'status' => 'error',
                'message' => 'Debes completar todos los campos obligatorios.'
            ]);
            return;
        }
        $data = $request->getPOST();

        $allLinks = DataBase::load('links');

        foreach($allLinks as &$link) {
            if ($link['id'] == $data['id']) {
                unset($link);
                break;
            }
        }

        DataBase::create('links', $allLinks);

        Response::showJson([
            'status' => 'success',
            'message' => 'El enlace se ha eliminado con éxito.'
        ]);

    }
    
}