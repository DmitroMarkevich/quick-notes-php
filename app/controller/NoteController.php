<?php

namespace app\controller;

use app\constants\ViewConstraints;
use app\mapper\NoteMapper;
use app\mapper\UserMapper;
use app\model\dto\NoteRequestDto;
use app\repository\NoteRepository;
use app\repository\UserRepository;
use app\service\NoteService;
use app\service\UserService;
use app\validator\NoteValidator;
use core\auth\Authentication;
use core\base\Controller;
use core\base\TemplateView;
use core\db\DBQueryBuilder;
use Exception;

class NoteController extends Controller
{
    private UserService $userService;
    private NoteService $noteService;
    private NoteValidator $noteValidator;

    public function __construct()
    {
        $userMapper = new UserMapper();
        $noteMapper = new NoteMapper();
        $dbQueryBuilder = new DBQueryBuilder();
        $noteRepository = new NoteRepository($dbQueryBuilder);
        $userRepository = new UserRepository($dbQueryBuilder);

        $this->noteValidator = new NoteValidator();
        $this->userService = new UserService($userRepository, $userMapper);
        $this->noteService = new NoteService($noteRepository, $this->userService, $noteMapper);
    }

    /**
     * Displays the authenticated user's list of notes.
     *
     * Checks user authentication status and retrieves paginated notes for the user.
     * Redirects to the login page if the user is not authenticated.
     *
     * @return string Rendered view of the user's notes.
     */
    public function actionList(): string
    {
        if (!Authentication::getInstance()->isAuthenticated()) {
            return $this->redirect("/login");
        }

        $templateView = new TemplateView(ViewConstraints::NOTE_LIST_VIEW, ViewConstraints::DEFAULT_TEMPLATE);
        $templateView->notes = $this->userService->getPaginatedUserNotes();

        return $templateView;
    }

    /**
     * Handles note creation.
     *
     * Processes POST requests to create a new note. Validates input data,
     * and if validation passes, stores the new note. Redirects to the note list upon successful creation.
     *
     * @return string Rendered view for creating a new note, or redirection on success.
     * @throws Exception if saving the note fails.
     */
    public function actionCreate(): string
    {
        if ($this->request->isPost()) {
            $noteRequestDto = new NoteRequestDto(
                $this->request->getPostParam('title'),
                $this->request->getPostParam('content'),
                $this->request->getPostParam('accessType')
            );

            if (!$this->noteValidator->validate($noteRequestDto)) {
                return $this->handleValidationErrors($this->noteValidator, ViewConstraints::NOTE_CREATE_VIEW);
            }

            $this->noteService->storeNote($noteRequestDto);
            return $this->redirect("/note/list");
        }

        return new TemplateView(ViewConstraints::NOTE_CREATE_VIEW, ViewConstraints::DEFAULT_TEMPLATE);
    }
}