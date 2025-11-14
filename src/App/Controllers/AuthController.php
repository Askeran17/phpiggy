<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Services\{ValidatorService, UserService};
use Framework\Exceptions\ValidationException;
use Exception;

class AuthController
{
    public function __construct(
        private TemplateEngine $view,
        private ValidatorService $validatorService,
        private UserService $userService
    ) {
        
    }

    public function registerView() {
        echo $this->view->render('register.php');
    }

    public function register() 
    {
       $this->validatorService->validateRegister($_POST);

         $this->userService->isEmailTaken($_POST['email']);

         $this->userService->create($_POST);

         redirectTo('/');
    }

    public function loginView() {
        echo $this->view->render('login.php');
    }

    public function login() 
    {
        try {
            $this->validatorService->validateLogin($_POST);
            $this->userService->login($_POST);
            
            $_SESSION['flash'] = 'Welcome! You have successfully logged in.';
            redirectTo('/');
        } catch (ValidationException $e) {
            $_SESSION['errors'] = $e->errors;
            $_SESSION['old'] = $_POST;
            redirectTo('/login');
        } catch (Exception $e) {
            $_SESSION['errors'] = ['general' => ['Произошла ошибка при входе в систему. Попробуйте еще раз.']];
            $_SESSION['old'] = $_POST;
            redirectTo('/login');
        }
    }

    public function logout() 
    {
        $this->userService->logout();

        redirectTo('/login');
    }

}