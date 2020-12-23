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

class Login {
    
    public function show(): void {

        Response::ok();
        Theme::change("administrator", false);
        Response::write(
            Theme::getTemplate()->render(
                'login.twig', 
                [
                    'website' => new WebSite(), 
                    'session' => new Session(),
                    'currentPage' => 'login'
                ]
            )
        );
        
    }

    public function do(): void {

        Response::ok();
        $request = new Request();
        if(!$request->issetPOST(["username", "password"])) {
            Response::showJson([
                'status'=> 'error',
                'message' => 'Debes introducir todos los datos obligatorios.'
            ]);
        }
        $data = $request->getPOST();

        $user = DataBase::getUser($data["username"], sha1($data["password"]));
        if($user instanceof User) {
            $_SESSION['user'] = $user;
            Session::setUser($user);
            Session::setLoggedIn(true);
            Response::showJson([
                'status'=> 'success',
                'message' => '¡Has iniciado sesión con éxito!'
            ]);
        } else {
            Response::showJson([
                'status'=> 'error',
                'message' => 'Los credenciales introducidos no son válidos.'
            ]);
        }

    }
    
}
