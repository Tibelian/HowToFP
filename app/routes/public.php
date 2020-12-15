<?php

/*************
 * ERROR 404 *
 *************/
$router->set404('App\Controller\Error404@show');

/*************
 * HOME PAGE *
 *************/
$router->get('/', 'App\Controller\Home@show');

/************
 * ABOUT-US *
 ************/
$router->get('/', 'App\Controller\AboutUs@show');

/***********
 * CONTACT *
 ***********/
$router->get('/', 'App\Controller\Contact@show');

/********
 * NEWS *
 ********/
$router->get('/news/([a-z0-9_-]+)', 'App\Controller\News@showArticle');

