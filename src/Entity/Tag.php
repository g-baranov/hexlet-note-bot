<?php


namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\ManyToMany(targetEntity="Note", mappedBy="tags")
     */
    private Collection $notes;

    public function __construct(string $title)
    {
        $this->title = $title;
        $this->notes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): void
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->addTag($this);
        }
    }
}