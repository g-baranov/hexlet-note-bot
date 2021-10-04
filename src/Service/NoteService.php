<?php


namespace App\Service;


use App\Entity\Note;
use App\Entity\Tag;
use App\Repository\NoteRepository;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use TgBotApi\BotApiBase\BotApiInterface;
use TgBotApi\BotApiBase\Method\SendMessageMethod;

class NoteService
{
    private TextParser $textParser;
    private NoteRepository $noteRepository;
    private TagRepository $tagRepository;
    private EntityManagerInterface $entityManager;
    private BotApiInterface $botApi;

    public function __construct(
        TextParser $textParser,
        NoteRepository $noteRepository,
        TagRepository $tagRepository,
        EntityManagerInterface $entityManager,
        BotApiInterface $botApi
    )
    {
        $this->textParser = $textParser;
        $this->noteRepository = $noteRepository;
        $this->tagRepository = $tagRepository;
        $this->entityManager = $entityManager;
        $this->botApi = $botApi;
    }

    public function add(int $chatId, string $text): void
    {
        $noteData = $this->textParser->parseNoteAndTags($text);

        $note = new Note($noteData['text']);
        $this->noteRepository->add($note);

        $tags = $this->tagRepository->findBy(['title' => $noteData['tags']]);
        $tagsMap = [];
        foreach ($tags as $tag) {
            $tagsMap[$tag->getTitle()] = $tag;
        }

        foreach ($noteData['tags'] as $tagTitle) {
            if (array_key_exists($tagTitle, $tagsMap)) {
                $tag = $tagsMap[$tagTitle];
            } else {
                $tag = new Tag($tagTitle);
                $this->tagRepository->add($tag);
            }
            $note->addTag($tag);
        }

        $this->entityManager->flush();

        $method = SendMessageMethod::create($chatId, 'Заметка сохранена!');
        $this->botApi->send($method);
    }
}