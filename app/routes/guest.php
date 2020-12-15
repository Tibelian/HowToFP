<?php

/************
 * REGISTER *
 ************/
$router->get('/register', function() {
    header('Location: ' . App\Model\WebSite::getUrl() . '/user/register');
});
$router->get('/user/register', '\App\Controller\User\Register@show');

/*********
 * LOGIN *
 *********/
$router->get('/login', function() {
    header('Location: ' . App\Model\WebSite::getUrl() . '/user/login');
});
$router->get('/user/login', '\App\Controller\User\Login@show');

/*****************
 * LOST PASSWORD *
 *****************/
$router->get('/lost', function() {
    header('Location: ' . App\Model\WebSite::getUrl() . '/user/lost');
});
$router->get('/user/lost', '\App\Controller\User\Lost@show');
