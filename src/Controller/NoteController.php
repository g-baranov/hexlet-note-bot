<?php

namespace App\Controller;

use App\Repository\NoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/note", name="note_")
 */
class NoteController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(NoteRepository $noteRepository): Response
    {
        $notes = $noteRepository->findBy([]);

        return $this->render('note/index.html.twig', ['notes' => $notes]);
    }
}