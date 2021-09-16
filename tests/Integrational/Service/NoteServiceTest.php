<?php


namespace App\Tests\Integrational\Service;


use App\Entity\Note;
use App\Entity\Tag;
use App\Service\NoteService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class NoteServiceTest extends KernelTestCase
{
    /**
     * @var NoteService|object|null
     */
    private $noteService;
    private ?EntityManagerInterface $em;

    protected function setUp(): void
    {
        self::bootKernel();

        // (2) use static::getContainer() to access the service container
        $container = static::getContainer();

        $this->noteService = $container->get(NoteService::class);
        $this->em = $container->get(EntityManagerInterface::class);

        $this->em->beginTransaction();
    }

    protected function tearDown(): void
    {
        $this->em->rollback();
        parent::tearDown();

        $this->em->close();
        $this->em = null;
    }


    public function testAddNote(): void
    {
        $text = 'Заплатить налоги #финансы #бюджет';
        $this->noteService->add(123, $text);

        $this->em->clear();

        $noteRepository = $this->em->getRepository(Note::class);
        $expectedText = 'Заплатить налоги';
        /** @var Note $note */
        $note = $noteRepository->findOneBy(['text' => $expectedText]);
        $this->assertEquals($expectedText, $note->getText());

        $resultTags = $note->getTags();

        $this->assertCount(2, $resultTags);
        $titles = [];
        foreach ($resultTags as $resultTag) {
            $titles[] = $resultTag->getTitle();
        }

        $this->assertEquals(['финансы', 'бюджет'], $titles);
    }

}