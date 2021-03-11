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

class Uploads {
    
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
                'uploads.twig', 
                [
                    'website' => new WebSite(), 
                    'session' => new Session(),
                    'currentPage' => 'uploads',
                    'fileList' => $fileList
                ]
            )
        );
        
    }

    public function list(): void {

        Response::ok();

        $dbFileList = DataBase::load('upload');
        $fileList = [];
        foreach($dbFileList as $dbFile) {
            $tmpObj = new UploadedFile($dbFile['path']);
            $tmpObj->setDescription($dbFile['description']);
            $tmpObj->setPath($dbFile['path']);
            $tmpObj->setId($dbFile['id']);
            $fileList[] = [
                'id' => $tmpObj->getId(),
                'basename' => $tmpObj->getBasename(),
                'path' => $tmpObj->getPath(),
                'size' => $tmpObj->getSize(),
                'description' => $tmpObj->getDescription(),
                'realpath' => $tmpObj->getRealPath(),
                'extension' => $tmpObj->getExtension(),
                'createtime' => $tmpObj->getCTime(),
                'type' => $tmpObj->getType()
            ];
        }

        Response::showJson([
            'status' => 'success',
            'data' => $fileList
        ]);

    }

    public function listById(): void {

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

        $dbFileList = DataBase::load('upload');
        $file = [];
        foreach($dbFileList as $dbFile) {

            if ($dbFile['id'] == $data['id']) {

                $tmpObj = new UploadedFile($dbFile['path']);
                $tmpObj->setDescription($dbFile['description']);
                $tmpObj->setPath($dbFile['path']);
                $tmpObj->setId($dbFile['id']);
                $file = [
                    'id' => $tmpObj->getId(),
                    'basename' => $tmpObj->getBasename(),
                    'path' => $tmpObj->getPath(),
                    'size' => $tmpObj->getSize(),
                    'description' => $tmpObj->getDescription(),
                    'realpath' => $tmpObj->getRealPath(),
                    'extension' => $tmpObj->getExtension(),
                    'createtime' => $tmpObj->getCTime(),
                    'type' => $tmpObj->getType()
                ];
                break;

            }

        }

        Response::showJson([
            'status' => 'success',
            'data' => $file
        ]);

    }

    public function add(): void {

        Response::ok();

        $request = new Request();
        if(!$request->issetPOST(['description']) && $request->issetFILES(['file'])) {
            Response::showJson([
                'status' => 'error',
                'message' => 'Debes completar todos los campos obligatorios.'
            ]);
            return;
        }
        $data = $request->getPOST();
        $file = $request->getFILES();

        $fileName = $file['file']['name'];
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
               
        $targetDir = __DIR__ . "/../../../uploads/" . date('d-m-Y') . '/';
        $targetFile = $targetDir.$fileName;

        $tempFile = $file['file']['tmp_name'];

        if($fileExtension == 'pdf' || getimagesize($tempFile)) {
            
            if(!file_exists($targetDir)) {
                mkdir($targetDir, 0755);
            }

            $id = uniqid();

            if(file_exists($targetFile)) {
                $fileName = pathinfo($fileName, PATHINFO_FILENAME).'-'.$id.'.'.$fileExtension;
                $targetFile  = $targetDir.$fileName;
            }

            if(move_uploaded_file($tempFile, $targetFile)) { 

                $newFile = [];
                $newFile['id'] = $id;
                $newFile['path'] = 'uploads/' . date('d-m-Y') . '/' . $fileName;
                $newFile['description'] = $data['description'];
        
                $allUploads = DataBase::load('upload');
                $allUploads[] = $newFile;
        
                DataBase::create('upload', $allUploads);
                Response::showJson([
                    'status' => 'success',
                    'message' => 'El archivo se ha guardado con éxito.'
                ]);

            } else {
                Response::showJson([
                    'status' => 'warning',
                    'message' => 'No hemos podido subir el archivo. ' . $tempFile . ' --- ' . $targetFile
                ]);
            }

        } else {
            Response::showJson([
                'status' => 'warning',
                'message' => 'El formato del archivo no es válido'
            ]);
        }

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

        $allUploads = DataBase::load('upload');

        for($i = 0; $i < sizeof($allUploads); $i++) {
            if($allUploads[$i]["id"] == $data["id"]) {
                unlink(__DIR__ . '/../../../' . $allUploads[$i]['path']);
                //unset($allUploads[$i]);
                array_splice($allUploads, $i, 1);
                break;
            }
        }

        DataBase::create('upload', $allUploads);

        Response::showJson([
            'status' => 'success',
            'message' => 'El archivo se ha eliminado con éxito.'
        ]);

    }
    
}