<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table("users")
 */
class User
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @var string
     * @ORM\Column(name="username", type="string", nullable=false, unique=true)
     */
    private string $username;

    /**
     * @var int
     * @ORM\Column(name="external_id", type="integer", nullable=false, unique=true)
     */
    private int $externalId;

    public function __construct(string $username, int $externalId)
    {
        $this->username = $username;
        $this->externalId = $externalId;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getExternalId(): int
    {
        return $this->externalId;
    }
}