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

    // edit pages
    $router->get('/pages/home', "App\Controller\Admin\Pages@showHome");
    $router->get('/pages/about-us', "App\Controller\Admin\Pages@showAboutUs");
    $router->get('/pages/contact', "App\Controller\Admin\Pages@showContact");
    
});


$router->mount('/ajax/administrator', function() use($router) {

    // logout
    $router->post('/logout', 'App\Controller\Admin\Login@close');
    
    // save web config
    $router->post('/configuration', 'App\Controller\Admin\Configuration@do');
    
    // manage file uploads
    $router->get('/uploads/list', 'App\Controller\Admin\Uploads@list');
    $router->post('/uploads/list', 'App\Controller\Admin\Uploads@listById');
    $router->post('/uploads/add', 'App\Controller\Admin\Uploads@add');
    $router->post('/uploads/delete', 'App\Controller\Admin\Uploads@delete');
    
    // manage articles
    $router->post('/news/add', 'App\Controller\Admin\News@add');
    $router->post('/news/delete', 'App\Controller\Admin\News@delete');
    
    // modfiy mailing server
    $router->post('/contact', 'App\Controller\Admin\Contact@do');
    
    // manage gallery
    $router->post('/gallery/link', 'App\Controller\Admin\Gallery@link');
    $router->post('/gallery/unlink', 'App\Controller\Admin\Gallery@unLink');
    
    // manage links
    $router->post('/nav/add', 'App\Controller\Admin\Navigation@add');
    $router->post('/nav/delete', 'App\Controller\Admin\Navigation@delete');

});


