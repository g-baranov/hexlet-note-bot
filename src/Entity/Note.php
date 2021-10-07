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
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="notes")
     */
    private Collection $tags;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     */
    private User $user;

    public function __construct(string $text, User $user)
    {
        $this->text = $text;
        $this->tags = new ArrayCollection();
        $this->user = $user;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return ArrayCollection|Collection|Tag[]
     */
    public function getTags(): ArrayCollection|Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): void
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->addNote($this);
        }
    }

    public function getUser(): User
    {
        return $this->user;
    }
}