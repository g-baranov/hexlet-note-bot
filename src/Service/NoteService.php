<?php


namespace App\Service;


use App\Entity\Note;
use App\Entity\Tag;
use App\Repository\NoteRepository;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use TgBotApi\BotApiBase\Method\SendMessageMethod;

class NoteService
{

    /**
     * @var TextParser
     */
    private $textParser;
    private NoteRepository $noteRepository;
    private TagRepository $tagRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(
        TextParser $textParser,
        NoteRepository $noteRepository,
        TagRepository $tagRepository,
        EntityManagerInterface $entityManager
    )
    {
        $this->textParser = $textParser;
        $this->noteRepository = $noteRepository;
        $this->tagRepository = $tagRepository;
        $this->entityManager = $entityManager;
    }

    public function add(int $chatId, string $text): void
    {
        $noteData = $this->textParser->parseNoteAndTags($text);

        $note = new Note($noteData['text']);
        $this->noteRepository->add($note);

        foreach ($noteData['tags'] as $tagData) {
            $tag = new Tag($tagData);
            $note->addTag($tag);
            $this->tagRepository->add($tag);
        }

        $this->entityManager->flush();
//        $note = [
//            'text' => '12312312',
//            'tags' => ['работа', 'отдых']
//        ];
//        $text = '';
//        $method = SendMessageMethod::create($chatId, $text);
//        $botApi->send($method);
    }
}