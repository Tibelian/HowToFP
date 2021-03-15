<?php

/**
 * @author Tibelian
 * @see www.tibelian.com
 */

namespace App\Controller;

use App\Controller\Http\Response;
use App\Controller\Http\Request;
use App\Model\WebSite;
use App\Model\Session;
use App\Model\Theme;
use App\Model\DataBase;
use App\Model\UploadedFile;
use App\Model\GalleryFile;

class Home {
    
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
        Response::write(
            Theme::getTemplate()->render(
                'home.twig', 
                [
                    'website' => new WebSite(), 
                    'session' => new Session(),
                    'currentPage' => 'home',
                    'articleList' => DataBase::load('news'),
                    'gallery' => $gallery
                ]
            )
        );
        
    }
    
}
