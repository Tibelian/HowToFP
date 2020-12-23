<?php

$router->mount('/administrator', function() use($router) {
    
    // server - website summary
    $router->get('/', 'App\Controller\Admin\Summary@show');
    
    // web config
    $router->get('/configuration', "App\Controller\Admin\Configuration@show");
    
    // navigation
    $router->get('/navigation', "App\Controller\Admin\Navigation@show");
    
    // uploads
    $router->get('/uploads', "App\Controller\Admin\Uploads@show");
    
    // news
    $router->get('/news', "App\Controller\Admin\News@show");
    
    // media gallery
    $router->get('/gallery', "App\Controller\Admin\Gallery@show");

    // contact
    $router->get('/contact', "App\Controller\Admin\Contact@show");
    
});

