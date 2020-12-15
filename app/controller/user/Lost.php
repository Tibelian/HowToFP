<?php

/**
 * @author Tibelian
 * @see www.tibelian.com
 */

namespace App\View\User;

use App\Model\WebSite;
use App\DataAccessObject\OperationJSON;
use App\Model\Session;

class Lost {
    
    /**
     * @return void
     */
    public function show(): void{

        // render the template and show the result
        echo WebSite::getTemplate()->render(
                'user/lost.twig', 
                [
                    'website' => new WebSite(),
                    'session' => new Session()
                ]
        );
        
    }
    
    /**
     * @param string $token
     * @return void
     */
    public function showRecover(string $login, string $token): void{
        $valid = false;
        $data = OperationJSON::getOperationToken("lost-password", $login, $token);
        if(isset($data["login"])){
            $valid = true;
        }
        echo WebSite::getTemplate()->render(
                'operation/index.twig', 
                [
                    'website' => new WebSite(),
                    'session' => new Session(),
                    'operationName' => 'lost-password',
                    'operationData' => $data,
                    'valid' => $valid,
                ]
        );
    }
    
}
