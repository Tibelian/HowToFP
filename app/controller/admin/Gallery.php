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
use App\Model\UploadedFile;
use App\Model\GalleryFile;

class Gallery {
    
    public function show(): void {

        $dbFileList = DataBase::load('upload');
        $fileList = [];
        foreach($dbFileList as $dbFile) {
            $tmpObj = new UploadedFile($dbFile['path']);
            $tmpObj->setDescription($dbFile['description']);
            $tmpObj->setPath($dbFile['path']);
            $tmpObj->setId($dbFile['id']);
            $fileList[] = $tmpObj;
        }

        $dbGalleryList = DataBase::load('gallery');
        $gallery = [];
        foreach($dbGalleryList as $dbGallery) {

            $fileFound = null;
            foreach($fileList as &$file) {
                if($file->getId() == $dbGallery['file']) {
                    $fileFound = $file;
                    break;
                }
            }

            $tmpObj = new GalleryFile();
            $tmpObj->setDescription($dbGallery['description']);
            $tmpObj->setTitle($dbGallery['title']);
            $tmpObj->setId($dbGallery['id']);
            $tmpObj->setFile($fileFound);
            $gallery[] = $tmpObj;
        }

        Response::ok();
        Theme::change("administrator", false);
        Response::write(
            Theme::getTemplate()->render(
                'gallery.twig', 
                [
                    'website' => new WebSite(), 
                    'session' => new Session(),
                    'currentPage' => 'gallery',
                    'fileList' => $fileList,
                    'gallery' => $gallery
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
            'message' => 'La imagen se ha agregado con éxito en la galería.'
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

        for ($i = 0; $i < sizeof($allGallery); $i++) {
            if ($allGallery[$i]['id'] == $data['id']) {
                array_splice($allGallery, $i, 1);
                break;
            }
        }

        DataBase::create('gallery', $allGallery);

        Response::showJson([
            'status' => 'success',
            'message' => 'La imagen se ha quitado de la galería con éxito.'
        ]);

    }
    
}