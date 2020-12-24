<?php

/**
 * @author Tibelian
 * @see www.tibelian.com
 * 
 * sirve para manejar los datos
 * que se encuentran en los archivos JSON
 * 
 */

namespace App\Model;

class DataBase {

    /**
     * @param string $filename
     * @return array
     * @throws WebSiteException
     */
    public static function load(string $filename): array{
        $file = __DIR__ . '/../database/' . $filename . '.json';
        if(file_exists($file)){
            try{
                return json_decode(file_get_contents($file), true);
            }catch(\TypeError $e){
                throw new WebSiteException(500, "The JSON file '" . $filename . "' is corrupted. Probably because the file is empty or malformed", "DataBase@load");
            }
        }else{
            throw new WebSiteException(404, "The JSON file '" . $file . "' does not exist on our database", "DataBase@load");
        }
    }
    
    /**
     * @param string $filename
     * @param array $data
     * @return void
     */
    public static function create(string $filename, array $data): void{
        $filePath = __DIR__ . '/../database/' . $filename . '.json';
        file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT), LOCK_EX);
    }

    /**
     * @param string $login
     * @param string $encryptedPassword
     * @return User|null
     */
    public static function getUser(string $login, string $encryptedPassword = null): ?User {

        $userList = self::load('user');
        foreach ($userList as $userJson) {
            if ($userJson["login"] == $login) {

                $user = new User();
                $user->setLogin($login);
                $user->setEmail($userJson["email"]);
                $user->setPassword($userJson["password"]);
                $user->setAdmin($userJson["admin"]);

                if (isset($userJson['lostToken'])) {
                    $user->setToken($userJson['lostToken']);
                }

                if ($encryptedPassword !== null) {
                    if ($user->getPassword() !== $encryptedPassword) {
                        return null;
                    }
                }
                
                return $user;

            }
        }
        return null;
            
    }


}