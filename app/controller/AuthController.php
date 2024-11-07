<?php

namespace app\controller;

use app\constants\ViewConstraints;
use app\model\dto\UserRequestDto;
use app\validator\AuthValidator;
use core\auth\Credential;
use core\base\Controller;
use core\base\TemplateView;
use core\auth\Authentication;
use Exception;

class AuthController extends Controller
{
    private AuthValidator $authValidator;
    private Authentication $auth;

    public function __construct()
    {
        $this->authValidator = new AuthValidator();
        $this->auth = Authentication::getInstance();
    }

    /**
     * Processes the login action.
     *
     * Validates incoming POST requests and attempts to authenticate the user.
     * On successful authentication, redirects to the note list.
     *
     * @return string|TemplateView Redirects on success or renders the login template on failure.
     */
    public function actionLogin(): string
    {
        if ($this->request->isPost()) {
            $email = $this->request->getPostParam('email');
            $password = $this->request->getPostParam('password');

            if ($this->auth->login(new Credential($email, $password))) {
                return $this->redirect("/note/list");
            }
        }

        return new TemplateView(ViewConstraints::AUTH_LOGIN_VIEW, ViewConstraints::REGISTRATION_TEMPLATE);
    }

    /**
     * Processes the registration action.
     *
     * Checks if a user is already authenticated and redirects if so.
     * For POST requests, validates and registers a new user, then attempts to log them in.
     * On successful registration and login, redirects to the note list.
     *
     * @throws Exception if an error occurs during registration.
     * @return string|TemplateView Redirects to the note list or renders the registration view.
     */
    public function actionRegister(): string
    {
        if ($this->auth->isAuthenticated()) {
            return $this->redirect("/note/list");
        }

        if ($this->request->isPost()) {
            $userRequestDto = new UserRequestDto(
                $this->request->getPostParam('email'),
                $this->request->getPostParam('password'),
                $this->request->getPostParam('fullName'),
                $this->request->getPostParam('phone')
            );

            if (!$this->authValidator->validate($userRequestDto)) {
                return $this->handleValidationErrors(
                    $this->authValidator,
                    ViewConstraints::AUTH_REGISTER_VIEW,
                    ViewConstraints::REGISTRATION_TEMPLATE
                );
            }

            if ($this->auth->register($userRequestDto) && $this->auth->login(
                    new Credential($userRequestDto->getEmail(), $userRequestDto->getPassword())
                )) {
                return $this->redirect("/note/list");
            }
        }

        return new TemplateView(ViewConstraints::AUTH_REGISTER_VIEW, ViewConstraints::REGISTRATION_TEMPLATE);
    }

    public function actionLogout(): string
    {
        $this->auth->logout();
        return $this->redirect();
    }
}