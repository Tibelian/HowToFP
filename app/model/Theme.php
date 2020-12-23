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
use App\Model\DataBase;

class Theme {

    private static Template $engine;
    private static string $name;
    private static string $version;
    private static string $author;

    public static function init(): void {

        self::change(WebSite::getTheme());

    }
    
    public static function change(string $themeName, bool $configName = true): void {

        if($configName) {
            WebSite::setTheme($themeName);
        }
        
        WebSite::setThemeUrl(WebSite::getUrl() . '/themes/' . $themeName);
        WebSite::setThemePath(__DIR__ . '/../../themes/' . $themeName . '/template');

        $loader = new TemplateLoader(WebSite::getThemePath());
        self::$engine = new Template($loader);

        $themeFile = DataBase::load('/../../themes/' . $themeName . '/template/../loader');

        self::$name = $themeFile['name'];
        self::$version = $themeFile['version'];
        self::$author = $themeFile['author'];

        setcookie("theme_url", WebSite::getThemeUrl());
        
    }

    public static function getTemplate(): Template {
        return self::$engine;
    }

}