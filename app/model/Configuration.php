<?php

namespace App\Model;

/**
 * @author Tibelian
 * @see www.tibelian.com
 * 
 * aquí solamente se guardan los datos de configuración
 * para una mejor gestión
 * 
 */

class Configuration {
    
    private static string $title;
    private static string $url;
    private static string $favicon;
    private static string $theme;
    private static string $cdn;
    private static string $adminEmail;
    
    public static function init() {
        $config = DataBase::load("website/config");
        self::setTitle($config['title']);
        self::setUrl($config['url']);
        self::setFavicon($config['favicon']);
        self::setTheme($config['theme']);
        self::setCdn($config['cdn']);  // HTTP_CF_CONNECTING_IP / REMOTE_ADDR
        self::setAdminEmail($config['admin_email']);
    }
    
    public static function getTitle(): string {
        return self::$title;
    } 
    public static function getUrl(): string {
        return self::$url;
    }
    public static function getFavicon(): string {
        return self::$favicon;
    }
    public static function getTheme(): string {
        return self::$theme;
    }
    public static function getCdn(): string {
        return self::$cdn;
    }
    public static function getAdminEmail(): string {
        return self::$adminEmail;
    }

    public static function setTitle($title): void {
        self::$title = $title;
    }
    public static function setUrl($url): void {
        self::$url = $url;
    }
    public static function setFavicon($favicon): void {
        self::$favicon = $favicon;
    }
    public static function setTheme($theme): void {
        self::$theme = $theme;
    }
    public static function setCdn($cdn): void {
        self::$cdn = $cdn;
    }
    public static function setAdminEmail($adminEmail): void {
        self::$adminEmail = $adminEmail;
    }

}