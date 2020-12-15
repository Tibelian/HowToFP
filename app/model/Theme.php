<?php

/**
 * @author Tibelian
 * @see www.tibelian.com
 * 
 * gestiona el tema(twig)
 * 
 */

namespace App\Model;

use \Twig\Environment as Template;
use \Twig\Loader\FilesystemLoader as TemplateLoader;

class Theme {

    private static Template $engine;

    public static function init(): void {

        self::changeTheme(WebSite::getTheme());

    }
    
    public static function changeTheme(string $themeName, bool $configName = true): void {

        if($configName) {
            WebSite::setTheme($themeName);
        }
        
        WebSite::setThemeUrl(WebSite::getUrl() . '/themes/' . $themeName);
        WebSite::setThemePath(__DIR__ . '/../../themes/' . $themeName . '/template');

        $loader = new TemplateLoader(WebSite::getThemePath());
        self::$engine = new Template($loader);

        setcookie("theme_url", WebSite::getThemeUrl());
        
    }

    public static function getTemplate(): Template {
        return self::$engine;
    }

}