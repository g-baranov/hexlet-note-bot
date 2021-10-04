<?php


namespace App\Tests\Unit\Service;


use App\Service\TextParser;
use PHPUnit\Framework\TestCase;

class TextParserTest extends TestCase
{
    private TextParser $textParser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->textParser = new TextParser();
    }

    public function testNoteWithTags(): void
    {
        $text = 'Заплатить налоги #финансы #бюджет';
        $note = $this->textParser->parseNoteAndTags($text);

        $result = [
            'text' => 'Заплатить налоги',
            'tags' => ['финансы', 'бюджет']
        ];
        self::assertEquals($result, $note);
    }

}