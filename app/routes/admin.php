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

// logout
$router->post('/ajax/administrator/logout', 'App\Controller\Admin\Login@close');

// save web config
$router->post('/ajax/administrator/configuration', 'App\Controller\Admin\Configuration@do');

// manage file uploads
$router->get('/ajax/administrator/uploads/list', 'App\Controller\Admin\Uploads@list');
$router->post('/ajax/administrator/uploads/list', 'App\Controller\Admin\Uploads@listById');
$router->post('/ajax/administrator/uploads/add', 'App\Controller\Admin\Uploads@add');
$router->post('/ajax/administrator/uploads/delete', 'App\Controller\Admin\Uploads@delete');

// manage articles
$router->post('/ajax/administrator/news/add', 'App\Controller\Admin\News@add');
$router->post('/ajax/administrator/news/delete', 'App\Controller\Admin\News@delete');

// modfiy mailing server
$router->post('/ajax/administrator/contact', 'App\Controller\Admin\Contact@do');

// manage gallery
$router->post('/ajax/administrator/gallery/link', 'App\Controller\Admin\Gallery@link');
$router->post('/ajax/administrator/gallery/unlink', 'App\Controller\Admin\Gallery@unLink');
