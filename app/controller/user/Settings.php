<?php

/**
 * @author Tibelian
 * @see www.tibelian.com
 */

namespace App\View\User;

use App\Model\WebSite;
use App\DataAccessObject\OperationJSON;
use App\Model\Session;

class Settings {
    
    /**
     * @return void
     */
    public function show(): void {

        // get all the required data
        $status = \App\Controller\Web\Status::getAll();
        $account = Session::getUser();

        // render the template and show the result
        echo WebSite::getTemplate()->render(
                'user/settings.twig', 
                [
                    'website' => new WebSite(),
                    'session' => new Session(),
                    'status' => $status,
                    'account' => $account
                ]
        );
        
    }
    
    /**
     * @param string $login
     * @param string $token
     * @return void
     */
    public function showConfirmNewEmail(string $login, string $token): void {
        $valid = false;
        $data = OperationJSON::getOperationToken("change-email", $login, $token);
        if(isset($data["login"])){
            $valid = true;
        }
        echo WebSite::getTemplate()->render(
                'operation/index.twig', 
                [
                    'website' => new WebSite(),
                    'session' => new Session(),
                    'operationName' => "change-email",
                    'operationData' => $data,
                    'valid' => $valid
                ]
        );
    }
    
    /**
     * @param string $login
     * @param string $token
     * @return void
     */
    public function showConfirmDelete(string $login, string $token): void{
        $valid = false;
        $data = OperationJSON::getOperationToken("delete-account", $login, $token);
        if(isset($data["login"])){
            $valid = true;
        }
        echo WebSite::getTemplate()->render(
                'operation/index.twig', 
                [
                    'website' => new WebSite(),
                    'operationName' => "delete-account",
                    'operationData' => $data,
                    'valid' => $valid
                ]
        );
    }
    
}
