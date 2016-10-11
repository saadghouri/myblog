<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
        $this->load->library('template');
    }

    function index() {
        echo 'Access Denied';
        exit;
    }

    
    /**
     * This function creates a user session. It gets email and password.
     * First it checks if user email exists. If email exists it checks if the user status is active.
     * If user status is not active it sends the activation email to the user. Otherwise, it validates 
     * users email, password and creates a session.
     * Data Required: email, password
     */
    function loginUser() {
        $errors = array();
        $success = array();

        $email = @$_POST['email'];
        $password = @$_POST['password'];
        
        $emailExists = $this->user_model->emailExists($email);
        if ($emailExists) {//check if email exists. If so, send activation email. Otherwise, validate user and create user session.
            if ($emailExists->status == 0) {//if user is already registered with that email and his status is not active, send activation email.
                $this->user_model->sendActivationEmail($emailExists->userId, $emailExists->email);
                $errors['message'] = "You already registered with that email, but you never activated the account. We just sent you another confirmation email (please check your spam/junk in case you don't see it.";
                $errors['data'] = array('userId' => $emailExists->userId, 'email' => $emailExists->email);
                $errors['inActiveEmail'] = true;
            } else {//validate user, create session and load operator profiles attached to this user
                $isValidUser = $this->user_model->isValidUser($email, $password);
                if ($isValidUser) {
                    $sessionArray = array(
                        'userId' => $isValidUser->userId,
                        'email' => $isValidUser->email,
                        'userName' => $isValidUser->firstName,
                        'isAdmin' => $isValidUser->isAdmin
                    );
                    $this->session->set_userdata('logged_in', $sessionArray);
                    //get operator profile attached to user - getOperatorProfileAttachedToUser
                    $operatorsAttachedToUser = $this->common_model->getRowsWhereArr('operators','*',array('ownerId'=>$isValidUser->userId));
                    $data['operatorProfile'] = $operatorsAttachedToUser;


                    if (count($operatorsAttachedToUser) > 0) {//Check if there is atleast one operator profile attached to this user. If so, set isOperator profile to true. Otherwise, set it to false.
                        $isOperator = true;
                    } else {
                        $isOperator = false;
                    }

                    $success['message'] = "User logged in successfully.";
                    $success['data'] = array('userId' => $isValidUser->userId, 'isOperator' => $isOperator);
                } else {
                    $errors['message'] = "Invalid Password";
                    $errors['data'] = $email;
                }
            }
        } else {
            $errors['message'] = "That email is not registered yet. <a href='" . base_url('register') . "'>Click Here</a> to Register";
            $errors['data'] = $email;
        }

        if (count($errors) != 0)
            $success = false;

        $data['errors'] = $errors;
        $data['success'] = $success;

        $this->common_model->response_json($data);
    }

    /**
     * This functions adds a new user in the database. It gets user data.
     * First it checks if user email exists. If email exists it checks if the user status is active.
     * If user status is not active it sends the activation email to the user. Otherwise, it adds
     * a new user to the database.<br/>
     * Data Required: first_name, last_name, email, password
     * <br/>Validates email
     */
    function registerUser() {
        $errors = array();
        $success = array();

        $firstName = @$_POST['first_name'];
        $lastName = @$_POST['last_name'];
        $email = strtolower(@$_POST['email']);
        $password = @$_POST['password'];


        $emailExists = $this->user_model->emailExists($email);
        if ($emailExists) {//check if email exists. If so, send activation email. Otherwise, validate user and create user session.
            if ($emailExists->status == 0) {//check if user status is not active, send activation email. Otherwise, display loggin message.
                
                $errors['message'] = "You already registered with that email, but you never activated the account. We just sent you another confirmation email (please check your spam/junk in case you don't see it.";
                $errors['data'] = array('user_id' => $emailExists->userId, 'email' => $emailExists->email);
                $errors['inActiveEmail'] = true;
            } else {//if user is already registered and status = 1, show login message
                $errors['message'] = "You already registered with that email. <a href='" . base_url('login') . "'>Click Here</a> to Login";
                $errors['data'] = array('userId' => $emailExists->userId, 'email' => $emailExists->email);
            }
        } else {//if user doesn't exists in the db.
            $data = array(
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'password' => md5($password),
                'status' => 0,
                'isadmin' => 0,
                'timestampCreated' => date("Y-m-d H:i:s")
            );
            
            
            // add new user to the users table
            $userId = $this->common_model->insertRow('users',$data);
            if ($userId != 0) {//if user is successfully registered
                $data = array(
                    'referralCode' => '1000' . $userId
                );
                $this->user_model->updateUserInfo($userId, $data);
                //$this->user_model->sendActivationEmail($userId, $email);

                $success['message'] = "User registered successfully. Click activation link in email to activate the user";
                $success['data'] = array('userId' => $userId);
            }
        }

        if (count($errors) != 0)
            $success = false;

        $data['errors'] = $errors;
        $data['success'] = $success;

        $this->common_model->response_json($data);
    }

    

    /**
     * This functions resets user password. It gets user new password and reset password token.
     * First it checks if resetPassworToken exists. If so, it checks if the user status is active.
     * If user status is not active it sends the activation email to the user. Otherwise, it sends password
     * reset email to user.<br/>
     * Data Required: password, resetPasswordToken
     */
    function resetPassword() {
        $errors = array();
        $success = array();

        $password = @$_POST['password'];
        $resetPasswordToken = @$_POST['resetPasswordToken'];

        $checkPasswordResetToken = $this->user_model->checkPasswordResetToken($resetPasswordToken);
        if ($checkPasswordResetToken) {//if resetPasswordToken is valid.
            if ($checkPasswordResetToken->status == 0) {//if user is already registered with that email and his status is not active, resend activation email. otherwise, update users password in db.
                $this->user_model->sendActivationEmail($checkPasswordResetToken->userId, $checkPasswordResetToken->email);
                $errors['message'] = "You already registered with that email, but you never activated the account. We just sent you another confirmation email (please check your spam/junk in case you don't see it.";
                $errors['data'] = array('userId' => $checkPasswordResetToken->userId, 'email' => $checkPasswordResetToken->email);
                $errors['inActiveEmail'] = true;
            } else {//if user is already registered with that email and his status is active, update password.
                $data = array(
                    'password' => md5($password)
                );
                $this->user_model->updateUserInfo($checkPasswordResetToken->userId, $data);

                $success['message'] = "New password saved. <a href='" . base_url('login') . "'>Click here</a> to login";
                $success['data'] = array('userId' => $checkPasswordResetToken->userId);
            }
        } else {
            $errors['message'] = "Link expired";
            $errors['data'] = $resetPasswordToken;
        }

        if (count($errors) != 0)
            $success = false;

        $data['errors'] = $errors;
        $data['success'] = $success;

        $this->common_model->response_json($data);
    }

    /**
     * This functions unsets user login session
     */
    function logout() {
        $this->session->unset_userdata('logged_in');
        session_destroy();
        redirect('login');
    }

}
