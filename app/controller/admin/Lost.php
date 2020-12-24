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
use App\Model\Mailer;
use App\Model\WebSiteException;

class Lost {
    
    public function show(): void {

        Response::ok();
        Theme::change("administrator", false);
        Response::write(
            Theme::getTemplate()->render(
                'user/lost.twig', 
                [
                    'website' => new WebSite(), 
                    'session' => new Session(),
                    'currentPage' => 'lost'
                ]
            )
        );
        
    }
    
    public function showRecover(string $username, string $token): void {

        $user = DataBase::getUser($username);
        Response::ok();
        Theme::change("administrator", false);
        Response::write(
            Theme::getTemplate()->render(
                'user/lost-recover.twig', 
                [
                    'website' => new WebSite(), 
                    'session' => new Session(),
                    'currentPage' => 'recover',
                    'user' => $user,
                    'token' => $token
                ]
            )
        );
        
    }

    public function do(): void {

        Response::ok();
        $request = new Request();
        if(!$request->issetPOST(["username", "email"])) {
            Response::showJson([
                'status'=> 'error',
                'message' => 'Debes introducir todos los datos obligatorios.'
            ]);
        }
        $data = $request->getPOST();

        $user = DataBase::getUser($data["username"]);
        if($user instanceof User && $user->getEmail() == $data['email']) {
            if($this->generateToken($user)) {
                Response::showJson([
                    'status'=> 'success',
                    'message' => 'Le hemos enviado un mensaje al correo electrónico con los pasos a seguir para recuperar su cuenta.'
                ]);
            } else {
                Response::showJson([
                    'status'=> 'error',
                    'message' => 'No se ha podido generar un token para cambiar su contraseña. Contacte con un administrador si el error persiste.'
                ]);
            }
        } else {
            Response::showJson([
                'status'=> 'error',
                'message' => 'No se ha encontrado ninguna cuenta con los datos introducidos.'
            ]);
        }

    }

    public function generateToken(User $user): bool {

        $token = sha1(date('H:i:sd-m-Y') . rand(10000,999999));
        $userList = DataBase::load('user');
        foreach ($userList as &$userJson) {
            if ($userJson["email"] == $user->getEmail()) {
                $userJson["lostToken"] = $token;
                break;
            }
        }
        DataBase::create('user', $userList);

        try {
            $link = WebSite::getUrl() . '/administrator/lost/' . $user->getLogin() . '/' . $token;
            $subject = 'Contraseña olvidada - '. WebSite::getTitle();
            $message = 'Haga click en el siguiente enlace con para crear una nueva contraseña: <a href="'. $link .'">Cambiar contraseña</a>';
            Mailer::send($user->getEmail(), $subject, $message);
            return true;
        } catch (WebSiteException $we) {
            return false;
        }
    }
    
}
