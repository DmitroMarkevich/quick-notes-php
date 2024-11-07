<?php

namespace app\controller;

use app\constants\ViewConstraints;
use app\mapper\UserMapper;
use app\repository\UserRepository;
use app\service\UserService;
use core\base\Controller;
use core\base\TemplateView;
use core\db\DBQueryBuilder;
use Exception;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct()
    {
        $userMapper = new UserMapper();
        $userRepository = new UserRepository(new DBQueryBuilder());

        $this->userService = new UserService($userRepository, $userMapper);
    }

    /**
     * Displays the settings view for the authenticated user.
     *
     * Retrieves the authenticated user's data and renders the settings template.
     *
     * @return TemplateView The view template for user settings.
     * @throws Exception if retrieving the authenticated user data fails.
     */
    public function actionSettings(): TemplateView
    {
        $authenticatedUser = $this->userService->getAuthenticatedUser();

        $templateView = new TemplateView(ViewConstraints::USER_SETTINGS_VIEW, ViewConstraints::DEFAULT_TEMPLATE);
        $templateView->authenticatedUser = $authenticatedUser;

        return $templateView;
    }
}