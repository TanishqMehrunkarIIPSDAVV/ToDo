<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Session;
use Framework\Validation;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

class UserController
{
    protected $db;

    public function __construct()
    {
        $config = require_once basePath("config/db.php");
        $this->db = new Database($config);
    }
    /**
     * Create a new user
     * @return void
     */
    public function create()
    {
        //Get the data from the form
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $confirmPassword = $_POST["confirm-password"];

        $errors = [];

        if (!Validation::email($email)) $errors["email"] = "Please Enter a Valid Email Address!!!";
        if (!Validation::string($username, 8, 20)) $errors["name"] = "Name length should be between 8 to 20 characters!!!";
        if (!Validation::string($password, 6, 20)) $errors["password"] = "Password length should be between 6 to 20 characters!!!";
        if (!Validation::match($password, $confirmPassword)) $errors["confirm-password"] = "Passwords do not match!!!";

        if (!empty($errors)) {
            load("Signup", [
                "errors" => $errors,
                "user" =>
                [
                    "username" => $username,
                    "email" => $email
                ]
            ]);
        } else {
            $params = [
                "email" => $email,
            ];
            $user = $this->db->query("SELECT * from users where email = :email", $params)->fetch();
            if ($user) {
                $errors["email"] = "Email is Already Registered!!!";
                load(
                    "Signup",
                    [
                        "errors" => $errors,
                        "user" =>
                        [
                            "username" => $username
                        ]
                    ]
                );
                exit;
            }
            $user = $this->db->query("SELECT * from users_temp where email = :email", $params)->fetch();
            if ($user) {
                $errors["email"] = "Email is Already Registered!!!";
                load(
                    "Signup",
                    [
                        "errors" => $errors,
                        "user" =>
                        [
                            "username" => $username
                        ]
                    ]
                );
                exit;
            }
            $code = rand(100000, 999999);
            $params =
                [
                    "username" => $username,
                    "email" => $email,
                    "password" => password_hash($password, PASSWORD_BCRYPT),
                    "code" => password_hash($code, PASSWORD_BCRYPT)
                ];
            $query = "INSERT into users_temp(username,email,password,code) values(:username,:email,:password,:code)";
            $this->db->query($query, $params);
            //Email Sending
            $subject = "Email Verification";
            $text = "Please Verify Your Email Address!!!";
            $html = '
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Email Verification</title>
                <style>
                    :root {
                        color-scheme: light dark;
                    }
                    body {
                        font-family: Arial, sans-serif;
                        padding: 20px;
                        background-color: #f8f9fa; /* Light theme background */
                        color: #212529; /* Light theme text */
                    }
                    .container {
                        max-width: 500px;
                        margin: 0 auto;
                        padding: 20px;
                        border-radius: 10px;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                        background-color: #ffffff; /* Light theme card background */
                    }
                    h1 {
                        font-size: 24px;
                    }
                    .code {
                        font-size: 20px;
                        font-weight: bold;
                        padding: 10px;
                        background-color: #e9ecef; /* Light theme code box */
                        color: #212529; /* Light theme text */
                        border-radius: 5px;
                        display: inline-block;
                    }
                    .footer {
                        margin-top: 20px;
                        font-size: 12px;
                        color: #6c757d; /* Light theme footer text */
                    }

                    /* Dark Mode */
                    @media (prefers-color-scheme: dark) {
                        body {
                            background-color: #121212; /* Dark theme background */
                            color: #e0e0e0; /* Dark theme text */
                        }
                        .container {
                            background-color: #1e1e1e; /* Dark theme card background */
                            box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
                        }
                        .code {
                            background-color: #333333; /* Dark theme code box */
                            color: #ffffff; /* Dark theme text */
                        }
                        .footer {
                            color: #bbbbbb; /* Dark theme footer text */
                        }
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <h1>Hello, ' . htmlspecialchars($username) . '</h1>
                    <p>Your verification code is:</p>
                    <p class="code">' . htmlspecialchars($code) . '</p>
                    <p>Please enter this code to verify your email.</p>
                    <p class="footer">If you didn\'t request this, please ignore this email.</p>
                </div>
            </body>
            </html>
            ';
            EmailController::sendEmail($email, $subject, $text, $html);
            load("Verify", ["msg" => "To Register Successfully, Please Verify Your Email Address. An Email has been sent to you!!!"]);
        }
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
     * Authenticate the User
     * @return void
     */
    public function authenticate()
    {
        $email = $_POST["signin-email"];
        $password = $_POST["signin-password"];
        $errors = [];
        if (!Validation::email($email)) $errors["email"] = "Please Enter a Valid Email Address!!!";
        if (!Validation::string($password, 6, 20)) $errors["password"] = "Password length should be between 6 to 20 characters!!!";
        if (!empty($errors)) {
            load("Signin", [
                "errors" => $errors,
                "user"=>[
                    "email"=>$email
                ]
            ]);
            exit;
        } else {
            $params = [
                "email" => $email
            ];
            $user = $this->db->query("SELECT * from users where email = :email", $params)->fetch();
            if ($user) {
                if (password_verify($password, $user->password)) {
                    Session::set("user", [
                        "id" => $user->id,
                        "email" => $user->email,
                        "username" => $user->username
                    ]);                    
                    redirect("/home");
                } else {
                    $errors["password"] = "Invalid Password!!!";
                    load("Signin", [
                        "errors" => $errors,
                        "user"=>[
                            "email"=>$email
                        ]
                    ]);
                }
            } else {
                $errors["email"] = "Email is not Registered!!!";
                load("Signin", [
                    "errors" => $errors
                ]);
            }
        }
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
     * Verify Page
     * @return void
     */
    public function verify()
    {
        load("Verify");
    }

    /**
     * Verify the User
     * @return void
     */
    public function verification()
    {
        $email = $_POST["verify_email"];
        $code = $_POST["verify_code"];
        $errors = [];
        if (!Validation::email($email)) $errors["email"] = "Please Enter a Valid Email Address!!!";
        if (!Validation::string($code, 6, 6)) $errors["code"] = "Code should be of 6 digits!!!";
        if (!empty($errors)) {
            load("Verify", [
                "errors" => $errors,
                "user" => [
                    "email" => $email
                ]
            ]);
            exit;
        } else {
            $params = [
                "email" => $email
            ];
            $user = $this->db->query("SELECT * from users_temp where email = :email", $params)->fetch();
            if ($user) {
                if (password_verify($code, $user->code)) {
                    $params = [
                        "username" => $user->username,
                        "email" => $user->email,
                        "password" => $user->password
                    ];
                    $query = "INSERT into users(username,email,password) values(:username,:email,:password)";
                    $this->db->query($query, $params);
                    $params = [
                        "email" => $email
                    ];
                    $this->db->query("DELETE from users_temp where email = :email", $params);
                    load("Signin", ["msg" => "You have been Registered Successfully!!!"]);
                } else {
                    $errors["code"] = "Invalid Code!!!";
                    load("Verify", [
                        "errors" => $errors,
                        "user" => [
                            "email" => $email
                        ]
                    ]);
                }
            } else {
                $errors["email"] = "Email is not Registered!!!";
                load("Verify", [
                    "errors" => $errors,
                    "user" => [
                        "email" => $email
                    ]
                ]);
            }
        }
    }

    /**
     * Reset Password Page
     * @return void
     */
    public function resetPassword()
    {
        load("ResetPassword");
    }

    /**
     * Change Password
     * @return void
     */
    public function changePassword()
    {
        $email = $_POST["forgot-email"];
        $errors = [];
        if (!Validation::email($email)) $errors["email"] = "Please Enter a Valid Email Address!!!";
        if (!empty($errors)) {
            load("ForgotPassword", [
                "errors" => $errors
            ]);
            exit;
        } else {
            $params = [
                "email" => $email
            ];
            $user = $this->db->query("SELECT * from users where email = :email", $params)->fetch();
            if ($user) {
                $code = rand(100000, 999999);
                $params = [
                    "email" => $email,
                    "code" => password_hash($code, PASSWORD_BCRYPT)
                ];
                $query = "UPDATE users set forgot_code=:code where email=:email";
                $this->db->query($query, $params);
                //Email Sending
                $subject = "Password Reset";
                $text = "Please Reset Your Password!!!";
                $html = '
                <!DOCTYPE html>
                <html>
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Email Verification</title>
                    <style>
                        :root {
                            color-scheme: light dark;
                        }
                        body {
                            font-family: Arial, sans-serif;
                            padding: 20px;
                            background-color: #f8f9fa; /* Light theme background */
                            color: #212529; /* Light theme text */
                        }
                        .container {
                            max-width: 500px;
                            margin: 0 auto;
                            padding: 20px;
                            border-radius: 10px;
                            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                            background-color: #ffffff; /* Light theme card background */
                        }
                        h1 {
                            font-size: 24px;
                        }
                        .code {
                            font-size: 20px;
                            font-weight: bold;
                            padding: 10px;
                            background-color: #e9ecef; /* Light theme code box */
                            color: #212529; /* Light theme text */
                            border-radius: 5px;
                            display: inline-block;
                        }
                        .footer {
                            margin-top: 20px;
                            font-size: 12px;
                            color: #6c757d; /* Light theme footer text */
                        }

                        /* Dark Mode */
                        @media (prefers-color-scheme: dark) {
                            body {
                                background-color: #121212; /* Dark theme background */
                                color: #e0e0e0; /* Dark theme text */
                            }
                            .container {
                                background-color: #1e1e1e; /* Dark theme card background */
                                box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
                            }
                            .code {
                                background-color: #333333; /* Dark theme code box */
                                color: #ffffff; /* Dark theme text */
                            }
                            .footer {
                                color: #bbbbbb; /* Dark theme footer text */
                            }
                        }
                    </style>
                </head>
                <body>
                    <div class="container">
                        <h1>Hello, ' . htmlspecialchars($user->username) . '</h1>
                        <p>Your verification code for <b>Password Reset</b> is:</p>
                        <p class="code">' . htmlspecialchars($code) . '</p>
                        <p>Please enter this code to verify your email.</p>
                        <p class="footer">If you didn\'t request this, please ignore this email.</p>
                    </div>
                </body>
                </html>';
                EmailController::sendEmail($email, $subject, $text, $html);
                load("ResetPassword", ["msg" => "To Reset Your Password, Please Check Your Email Address. An Email has been sent to you!!!"]);
            } else {
                $errors["email"] = "Email is not Registered!!!";
                load("ForgotPassword", [
                    "errors" => $errors
                ]);
            }
        }
    }
}
