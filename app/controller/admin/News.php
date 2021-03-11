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

class News {
    
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

        Response::ok();
        Theme::change("administrator", false);
        Response::write(
            Theme::getTemplate()->render(
                'news.twig', 
                [
                    'website' => new WebSite(), 
                    'session' => new Session(),
                    'currentPage' => 'news',
                    'fileList' => $fileList,
                    'articleList' => DataBase::load('news')
                ]
            )
        );
        
    }

    public function add(): void {

        Response::ok();

        $request = new Request();
        if(!$request->issetPOST(['title', 'image', 'content'])) {
            Response::showJson([
                'status' => 'error',
                'message' => 'Debes completar todos los campos obligatorios.'
            ]);
            return;
        }
        $data = $request->getPOST();

        $newArticle = [];
        $newArticle['id'] = uniqid();
        $newArticle['title'] = $data['title'];
        $newArticle['image'] = $data['image'];
        $newArticle['content'] = $data['content'];

        if($data["button_text"] && $data["button_url"]) {
            $newArticle["button_text"] = $data["button_text"];
            $newArticle["button_url"] = $data["button_url"];
        }

        $allNewsList = DataBase::load('news');
        $allNewsList[] = $newArticle;

        DataBase::create('news', $allNewsList);

        Response::showJson([
            'status' => 'success',
            'message' => 'El artículo se ha añadido con éxito.'
        ]);

    }

    public function delete(): void {

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

        $allNewsList = DataBase::load('news');

        for ($i = 0; $i < sizeof($allNewsList); $i++) {
            if ($allNewsList[$i]['id'] == $data['id']) {
                array_splice($allNewsList, $i, 1);
                break;
            }
        }

        DataBase::create('news', $allNewsList);

        Response::showJson([
            'status' => 'success',
            'message' => 'El artículo se ha eliminado con éxito.'
        ]);

    }
    
}
