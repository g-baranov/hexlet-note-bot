<?php


namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use App\Repository\TagRepository;

/**
 * @ORM\Entity(repositoryClass=TagRepository::class)
 */
class Tag
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @var string
     * @ORM\Column(name="title", type="string", nullable=false)
     */
    private string $title;

    public function __construct(string $title)
    {
        $this->title = $title;
    }
}