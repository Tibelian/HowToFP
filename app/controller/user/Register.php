<?php

/**
 * @author Tibelian
 * @see www.tibelian.com
 */

namespace App\View\User;

use App\Model\WebSite;
use App\Model\Session;
use App\Controller\Web\Status;
use App\DataAccessObject\OperationJSON;

class Register {
    
    /**
     * @return void
     */
    public function show(): void{

        // get all the required data
        $status = Status::getAll();

        // render the template and show the result
        echo WebSite::getTemplate()->render(
                'user/register.twig', 
                [
                    'website' => new WebSite(),
                    'session' => new Session(),
                    'status' => $status
                ]
        );
        
    }
    
    /**
     * @param string $login
     * @param string $token
     * @return void
     */
    public function showActivate(string $login, string $token): void{
        $valid = false;
        $data = OperationJSON::getOperationToken("register-activation", $login, $token);
        if(isset($data["login"])){
            $valid = true;
        }
        echo WebSite::getTemplate()->render(
                'operation/index.twig', 
                [
                    'website' => new WebSite(),
                    'session' => new Session(),
                    'operationName' => 'register-activation',
                    'operationData' => $data,
                    'valid' => $valid,
                ]
        );
    }
    
}
