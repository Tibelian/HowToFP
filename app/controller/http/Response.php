<?php

/**
 * @author Tibelian
 * @see www.tibelian.com
 */

namespace App\Controller\Http;

class Response {
    
    private static array $headers;
    
    public static function ok() {
        header('HTTP/1.1 200 OK');
    }
    public static function notFound() {
        header('HTTP/1.1 404 Not Found');
    }
    
    public static function addHeader($name, $value): void {
        self::$headers[$name][] = $value;
    }

    public static function setHeader($name, $value): void {
        self::$headers[$name] = $value;
    }

    public static function redirect($url): void {
        header("Location: $url");
    }
    
    public static function showJson(array $json): void {
        header('Content-Type: application/json');
        echo json_encode($json, JSON_PRETTY_PRINT);
    }

    public static function write(string $data): void {
        echo $data;
    }
    
}
