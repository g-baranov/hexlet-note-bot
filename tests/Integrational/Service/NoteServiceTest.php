<?php


namespace App\Tests\Integrational\Service;


use App\Service\NoteService;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class NoteServiceTest extends KernelTestCase
{
    /**
     * @var NoteService|object|null
     */
    private $noteService;

    protected function setUp(): void
    {
        self::bootKernel();

        // (2) use static::getContainer() to access the service container
        $container = static::getContainer();

        $this->noteService = $container->get(NoteService::class);
        parent::setUp();
    }

    public function testAddNote()
    {
        $this->noteService->add(123, 'Заплатить налоги #финансы #бюджет');
    }

}