<?php

namespace App\Controllers;

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

class HomeController
{
    /**
     * Home Page
     * @return void
     */
    public static function index()
    {
        load("Home");
    }
}