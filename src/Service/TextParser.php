<?php


namespace App\Service;


use Exception;
use Symfony\Component\String\UnicodeString;

class TextParser
{
    /**
     * Парсит текст в заметку и теги(есть хештеги #финансы)
     * @param string $text
     * @return array
     * @throws Exception
     */
    public function parseNoteAndTags(string $text): array
    {
        $parts = explode('#', $text);
        if (count($parts) === 0) {
            throw new Exception("Текст не содержит заметку '{$text}'");
        }
        $noteText = array_shift($parts);
        $noteText = trim($noteText);

        $tags = [];
        foreach ($parts as $tag) {
            $tags[] = trim($tag);
        }

        return [
            'text' => $noteText,
            'tags' => $tags
        ];
    }
}