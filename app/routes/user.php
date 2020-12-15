<?php

/****************
 * USER PROFILE *
 ****************/
$router->get('/user', '\App\Controller\User\Panel@show');

/*******************
 * USER CHARACTERS *
 *******************/
$router->get('/user/characters', '\App\Controller\User\Characters@show');

/*****************
 * USER SETTINGS *
 *****************/
$router->get('/user/settings', '\App\Controller\User\Settings@show');
