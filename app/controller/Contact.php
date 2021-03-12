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
use App\Model\Mailer;

class Contact {
    
    public function show(): void {
        
        Response::ok();
        Response::write(
            Theme::getTemplate()->render(
                'contact.twig', 
                [
                    'website' => new WebSite(), 
                    'session' => new Session(),
                    'currentPage' => 'contact'
                ]
            )
        );
        
    }

    public function do(): void {

        Response::ok();

        $request = new Request();
        if(!$request->issetPOST(['name', 'subject', 'content'])) {
            Response::showJson([
                'status' => 'error',
                'message' => 'Debes completar todos los campos obligatorios.'
            ]);
            return;
        }

        $data = $request->getPOST();
        if(!isset($data['email'])) {
            $data['email'] = 'Anónimo';
        }
        $this->saveMessage($data);

        $content = '
            <p><strong>Nombre: </strong> '.$data["name"].'</p>
            <p><strong>Email: </strong> '.$data["email"].'</p>
            <p><strong>Asunto: </strong> '.$data["subject"].'</p>
            <p><strong>Contenido: </strong> '.$data["content"].'</p>
            <br>
            <br>
            <p>Mensaje enviado desde el formulario de contacto: ' . WebSite::getUrl() . '/contact </p>
        ';
        Mailer::send(WebSite::getAdminEmail(), 'Has recibido un nuevo mensaje', $content);

        Response::showJson([
            'status' => 'success',
            'message' => 'El mensaje se ha enviado con éxito'
        ]);

    }
    
    public function saveMessage($data): void {
        
        $messages = DataBase::load('messages');

        $newMessage = [];
        $newMessage['name'] = $data['name'];
        $newMessage['email'] = $data['email'];
        $newMessage['subject'] = $data['subject'];
        $newMessage['content'] = $data['content'];
        $newMessage['date'] = date("d-m-Y H:i");

        $messages[] = $newMessage;
        DataBase::create('messages', $messages);

    }

}
