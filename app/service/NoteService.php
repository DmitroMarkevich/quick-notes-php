<?php

namespace app\service;

use app\mapper\NoteMapper;
use app\model\dto\NoteRequestDto;
use app\repository\NoteRepository;
use Exception;

class NoteService
{
    private NoteMapper $noteMapper;
    private UserService $userService;
    private NoteRepository $noteRepository;

    public function __construct(NoteRepository $noteRepository, UserService $userService, NoteMapper $noteMapper)
    {
        $this->noteMapper = $noteMapper;
        $this->userService = $userService;
        $this->noteRepository = $noteRepository;
    }

    /**
     * Stores a new note in the repository.
     *
     * This method retrieves the user ID based on the authenticated user's email,
     * creates a new note object, and saves it to the repository.
     *
     * @throws Exception If the note cannot be saved.
     */
    public function storeNote(NoteRequestDto $noteRequestDto): void
    {
        $email = $this->userService->getAuthenticatedUserEmail();

        $note = $this->noteMapper->mapRequestDtoToEntity($noteRequestDto);
        $note->setUserId($this->userService->getUserIdByEmail($email));

        $this->noteRepository->save($note);
    }
}