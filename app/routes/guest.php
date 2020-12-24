<?php

/************
 * REGISTER *
 ************/
//$router->get('/administrator/register', 'App\Controller\Admin\Register@show');

/*********
 * LOGIN *
 *********/
$router->get('/administrator', 'App\Controller\Admin\Login@show');
$router->post('/ajax/administrator/login', 'App\Controller\Admin\Login@do');

/*****************
 * LOST PASSWORD *
 *****************/
$router->get('/administrator/lost', 'App\Controller\Admin\Lost@show');
$router->post('/ajax/administrator/lost', 'App\Controller\Admin\Lost@do');
$router->get('/administrator/lost/(\w+)/(\w+)', 'App\Controller\Admin\Lost@showRecover');
$router->post('/ajax/administrator/recover', 'App\Controller\Admin\Lost@recover');
