<?php

namespace App;

use App\Model\Session;
use App\Model\WebSite;
use App\Model\Theme;
use Bramus\Router\Router;

require 'app/autoload.php';

try{

    // manage the user
    Session::init();

    // manage the web configuration
    WebSite::init();

    // current page template
    Theme::init();

    // pages
    $router = new Router();
    include 'app/routes/public.php';
    if(Session::isLoggedIn()){
        include 'app/routes/user.php';
        if(Session::getUser()->isAdmin()){
            include 'app/routes/admin.php';
        }
    }else{
        include 'app/routes/guest.php';
    }
    $router->run();


}catch(\App\Model\WebSiteException $we){
    
    echo "CLASS: WebSiteException <br>";
    echo "ERROR: " . $we->getMessage() . "<br>";
    echo "LOCATION: " . $we->getLocation() . "<br>";

}catch(\Exception $e){
    
    echo "CLASS: " . get_class($e) . "<br>";
    echo "ERROR: " . $e->getMessage() . "<br>";

}