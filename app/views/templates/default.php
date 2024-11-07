<?php

use app\mapper\UserMapper;
use app\repository\UserRepository;
use app\service\UserService;
use core\db\DBQueryBuilder;

$userMapper = new UserMapper();
$userRepository = new UserRepository(new DBQueryBuilder());
$userService = new UserService($userRepository, $userMapper);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="/static/img/favicon.webp" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/static/css/style.css">
    <title>QuickNotes</title>
    <style>
        .main-content {
            margin-left: 200px;
            padding-top: 50px;
            height: calc(100vh - 50px);
            overflow-y: auto;
        }
    </style>
</head>
<body>
<div class="top-navbar bg-dark" style="z-index: 1"></div>
<div class="d-flex">
    <div class="sidebar bg-dark text-white" style="z-index: 2">
        <div class="user-info d-flex justify-content-between align-items-center">
            <div class="dropdown">
                <button class="btn btn-link text-white dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 0.8rem;">
                    <?= htmlspecialchars("Hi, " . $userService->getAuthenticatedUser()->getFullName()) ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="/user/settings">Settings</a></li>
                    <li><a class="dropdown-item" href="/logout">Logout</a></li>
                </ul>
            </div>

            <a href="/note/create" class="text-white">
                <i class="bi bi-pencil me-2"></i>
            </a>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="/note/list" class="nav-link text-white d-flex align-items-center">
                    <i class="bi bi-house-door me-2"></i> Home
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-white d-flex align-items-center">
                    <i class="bi bi-search me-2"></i> Search
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-white d-flex align-items-center">
                    <i class="bi bi-inbox me-2"></i> Inbox
                </a>
            </li>
        </ul>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="#" class="nav-link text-white d-flex align-items-center">
                    <i class="bi bi-file-earmark me-2"></i> Getting Started
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-white d-flex align-items-center">
                    <i class="bi bi-list-task me-2"></i> Weekly To-do List
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-white d-flex align-items-center">
                    <i class="bi bi-calendar me-2"></i> Calendar
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-white d-flex align-items-center">
                    <i class="bi bi-trash me-2"></i> Trash
                </a>
            </li>
        </ul>
        <div class="invite-section mt-4">
            <a href="#" class="text-white d-flex align-items-center">
                <i class="bi bi-person-plus me-2"></i> Invite members
            </a>
        </div>
    </div>

    <div class="main-content">
        <?= $content ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
</body>
</html>