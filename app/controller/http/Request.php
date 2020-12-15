<?php

/**
 * @author Tibelian
 * @see www.tibelian.com
 */

namespace App\Controller\Http;

class Request {
    
    private array $HEADERS;
    private array $POST;
    private array $GET;
    private array $FILES;
    private array $SERVER;
    private array $COOKIES;
    
    
    function __construct() {
        
        $this->initHEADERS();
        $this->initPOST();
        $this->initGET();      
        $this->initFILES();
        $this->initSERVER();
        $this->initCOOKIES();
        
    }
    
    public function issetPOST(array $data){
        $isset = true;
        foreach ($data as $value) {
            if(!isset($this->POST[$value])){
                $isset = false;
            }
        }
        return $isset;
    }
    
    public function issetGET(array $data){
        $isset = true;
        foreach ($data as $value) {
            if(!isset($this->GET[$value])){
                $isset = false;
            }
        }
        return $isset;
    }
    
    public function issetFILES(array $data){
        $isset = true;
        foreach ($data as $value) {
            if(!isset($this->POST[$value])){
                $isset = false;
            }
        }
        return $isset;
    }
    
    public function issetCOOKIES(array $data){
        $isset = true;
        foreach ($data as $value) {
            if(!isset($this->POST[$value])){
                $isset = false;
            }
        }
        return $isset;
    }
    
    private function initHEADERS(): void{
        foreach($_SERVER as $key => $value) {
            if (substr($key, 0, 5) <> 'HTTP_') {
                continue;
            }
            $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
            $this->HEADERS[$header] = $value;
        }
    }
    
    private function initPOST(): void{
        foreach ($_POST as $key => $value) {
            $this->POST[$key] = $value;
        }
    }
    
    private function initGET(): void{
        foreach ($_GET as $key => $value) {
            $this->GET[$key] = $value;
        }
    }
    
    private function initFILES(): void{
        foreach ($_FILES as $key => $value) {
            $this->FILES[$key] = $value;
        }
    }
    
    private function initSERVER(): void{
        foreach ($_SERVER as $key => $value) {
            $this->SERVER[$key] = $value;
        }
    }
    
    private function initCOOKIES(): void{
        foreach ($_COOKIE as $key => $value) {
            $this->COOKIES[$key] = $value;
        }
    }
    
    
    function getHEADERS(): array {
        return $this->HEADERS;
    }

    function getPOST(): array {
        return $this->POST;
    }

    function getGET(): array {
        return $this->GET;
    }

    function getFILES(): array {
        return $this->FILES;
    }

    function getSERVER(): array {
        return $this->SERVER;
    }

    function getCOOKIES(): array {
        return $this->COOKIES;
    }

    
}
