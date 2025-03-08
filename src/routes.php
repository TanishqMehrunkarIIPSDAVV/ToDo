<?php

$router->get("/","UserController@signin",["guest"]);
$router->get("/signup","UserController@signup",["guest"]);
$router->get("/forgot-password","UserController@forgotPassword",["guest"]);
$router->get("/verify","UserController@verify",["guest"]);
//Reset Password Page
$router->get("/reset-password","UserController@resetPassword",["guest"]);

//Post
$router->post("/create","UserController@create",["guest"]);
$router->post("/verification","UserController@verification",["guest"]);
//Forgot Password to Reset Password
$router->post("/change-password","UserController@changePassword",["guest"]);
//Reset Password
$router->post("/reset-password","UserController@reset",["guest"]);