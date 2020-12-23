<?php

/*************
 * ERROR 404 *
 *************/
$router->set404('App\Controller\Error\NotFound@show');

/*************
 * HOME PAGE *
 *************/
$router->get('/', 'App\Controller\Home@show');

/************
 * ABOUT-US *
 ************/
$router->get('/about-us', 'App\Controller\AboutUs@show');

/***********
 * CONTACT *
 ***********/
$router->get('/contact', 'App\Controller\Contact@show');

/********
 * NEWS *
 ********/
$router->get('/news/([a-z0-9_-]+)', 'App\Controller\News@showArticle');

