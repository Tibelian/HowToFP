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

class Gallery {
    
    public function show(): void {

        Response::ok();
        Theme::change("administrator", false);
        Response::write(
            Theme::getTemplate()->render(
                'gallery.twig', 
                [
                    'website' => new WebSite(), 
                    'session' => new Session(),
                    'currentPage' => 'gallery'
                ]
            )
        );
        
    }

    public function link(): void {

        Response::ok();

        $request = new Request();
        if(!$request->issetPOST(['file', 'title', 'description'])) {
            Response::showJson([
                'status' => 'error',
                'message' => 'Debes completar todos los campos obligatorios.'
            ]);
            return;
        }
        $data = $request->getPOST();

        $newImage = [];
        $newImage['id'] = uniqid();
        $newImage['title'] = $data['title'];
        $newImage['description'] = $data['description'];
        $newImage['file'] = $data['file'];

        $allGallery = DataBase::load('gallery');
        $allGallery[] = $newImage;

        DataBase::create('gallery', $allGallery);

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

        $allGallery = DataBase::load('gallery');

        foreach($allGallery as &$image) {
            if ($image['id'] == $data['id']) {
                unset($image);
                break;
            }
        }

        DataBase::create('news', $allGallery);

        Response::showJson([
            'status' => 'success',
            'message' => 'La imagen se ha quitado de la galería con éxito.'
        ]);

    }
    
}