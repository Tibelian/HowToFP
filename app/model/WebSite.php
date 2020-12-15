<?php

/**
 * @author Tibelian
 * @see www.tibelian.com
 * 
 * carga la configuración 
 * y gestiona los datos básicos de la web
 * 
 */

namespace App\Model;

class WebSite extends Configuration {

    private static string $themePath;
    private static string $themeUrl;
    private static string $userIp;

    public static function init(): void {

        // load config from json file
        parent::init();
        
        // user ip
        self::setUserIp(self::loadRealIp());

        // new cookie with the web url
        setcookie("url", self::getUrl(), 0, "/");
        
    }
    
    public static function loadRealIp(){
        if (isset($_SERVER["HTTP_CLIENT_IP"])){
            return $_SERVER["HTTP_CLIENT_IP"];
        }elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        }elseif (isset($_SERVER["HTTP_X_FORWARDED"])){
            return $_SERVER["HTTP_X_FORWARDED"];
        }elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])){
            return $_SERVER["HTTP_FORWARDED_FOR"];
        }elseif (isset($_SERVER["HTTP_FORWARDED"])){
            return $_SERVER["HTTP_FORWARDED"];
        }else{
            return $_SERVER["REMOTE_ADDR"];
        }
    }

    public static function getThemePath(): string {
        return self::$themePath;
    }

    public static function getThemeUrl(): string {
        return self::$themeUrl;
    }

    public static function getUserIp(): string {
        return self::$userIp;
    }

    public static function setThemePath(string $themePath): void {
        self::$themePath = $themePath;
    }

    public static function setThemeUrl(string $themeUrl): void {
        self::$themeUrl = $themeUrl;
    }

    public static function setUserIp(string $userIp): void {
        self::$userIp = $userIp;
    }
    
}