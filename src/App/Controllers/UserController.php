<?php

namespace App\Controllers;

use Framework\Database;
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
            $html = "<b>$username</b>, Your Code for Verification is <b>$code</b>";
            EmailController::sendEmail($email,$subject,$text,$html);
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
        $errors=[];
        if (!Validation::email($email)) $errors["email"] = "Please Enter a Valid Email Address!!!";
        if (!Validation::string($code, 6, 6)) $errors["code"] = "Code should be of 6 digits!!!";
        if(!empty($errors))
        {
            load("Verify",[
                "errors"=>$errors,
                "user"=>[
                    "email"=>$email
                ]
            ]);
            exit;
        }
        else
        {
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
                    $params=[
                        "email"=>$email
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
        
    }
}
