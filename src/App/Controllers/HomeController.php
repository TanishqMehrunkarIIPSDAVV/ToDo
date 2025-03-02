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

    /**
     * Sign In Page
     * @return void
     */
    public function signin()
    {
        load("Signin");
    }

    /**
     * Sign Up Page
     * @return void
     */
    public function signup()
    {
        load("Signup");
    }

    /**
     * Forgot Password Page
     * @return void
     */
    public function forgotPassword()
    {
        load("ForgotPassword");
    }
    /**
     * Send an Email
     * @return void
     */
    // public function sendEmail()
    // {
    //     $user = $_ENV["email"];
    //     $pass = $_ENV["password"];
    //     $dsn = "smtp://$user:$pass@smtp.gmail.com:587";
    //     $transport = Transport::fromDsn($dsn);
    //     $mailer = new Mailer($transport);

    //     $email = (new Email())
    //         ->from('mehrunkart@gmail.com')
    //         ->to('nykay10968@gmail.com')
    //         //->cc('cc@example.com')
    //         //->bcc('bcc@example.com')
    //         //->replyTo('fabien@example.com')
    //         //->priority(Email::PRIORITY_HIGH)
    //         ->subject('Time for Symfony Mailer!')
    //         ->text('Sending emails is fun again!')
    //         ->html('
    //         <table border="2">
    //             <tr>
    //                 <th>Name</th>
    //                 <th>Age</th>
    //             </tr>
    //             <tr>
    //                 <td>Doodh Wala</td>
    //                 <td>21</td>
    //             </tr>
    //         </table>
    //         ');

    //     $mailer->send($email);
    //     echo "Email Sent";
    // }
}