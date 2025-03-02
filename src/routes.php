<?php

$router->get("/","HomeController@signin",["guest"]);
$router->get("/signup","HomeController@signup",["guest"]);
$router->get("/forgot-password","HomeController@forgotPassword",["guest"]);