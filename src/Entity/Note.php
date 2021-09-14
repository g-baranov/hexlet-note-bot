<?php


namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\NoteRepository;

/**
 * @ORM\Entity(repositoryClass=NoteRepository::class)
 */
class Note
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @var string
     * @ORM\Column(name="text", type="text", nullable=false)
     */
    private string $text;

    /**
     * @ORM\ManyToMany(targetEntity="Tag")
     */
    private Collection $tags;

    public function __construct(string $text)
    {
        $this->text = $text;
        $this->tags = new ArrayCollection();
    }
}