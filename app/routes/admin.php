<?php

// autoload admin classes ------------
require __DIR__ . '/../autoload-admin.php';


/****
 * 
 */
$router->mount('/administrator', function() use($router) {
    
    // server - website summary
    $router->get('/', 'App\View\Admin\Summary@show');
    
    // change theme
    $router->get('/appearance', "App\View\Admin\Appearance@show");
    
    // web config
    $router->get('/configuration', "App\View\Admin\Configuration@show");
    
    // languages
    $router->get('/languages', "App\View\Admin\Languages@show");
    
    // logs
    $router->get('/logs', "App\View\Admin\Logs@show");
    
    // pages
    $router->get('/pages', "App\View\Admin\Pages@show");
    
    // navigation
    $router->get('/navigation', "App\View\Admin\Navigation@show");
    
    // news
    $router->get('/web/news', "App\View\Admin\Web\News@show");
    
    // media gallery
    $router->get('/web/gallery', "App\View\Admin\Web\Gallery@show");
    
    // downloads
    $router->get('/web/downloads', "App\View\Admin\Web\Downloads@show");
    
    // donation
    $router->get('/donation', "App\View\Admin\Donation@show");
    
    // votation
    $router->get('/votation', "App\View\Admin\Votation@show");
        
    /********
     * AJAX *
     ********/
    require __DIR__ . "/admin-ajax.php";
    
});


