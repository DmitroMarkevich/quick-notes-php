<?php

namespace app\controller;

use core\base\Controller;
use core\auth\Authentication;

class MainController extends Controller
{
    public function actionIndex(): string
    {
        if (Authentication::getInstance()->isAuthenticated()) {
            return $this->redirect("/note/list");
        }

        return $this->redirect("/login");
    }
}