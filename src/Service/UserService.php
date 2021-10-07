<?php


namespace App\Service;


use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{
    private UserRepository $userRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }

    public function findOrCreate(int $externalId, string $username = null): User
    {
        $user = $this->userRepository->findOneBy(['externalId' => $externalId]);
        if (!$user) {
            $user = new User($username, $externalId);
            $this->userRepository->add($user);
            $this->entityManager->flush();
        }

        return $user;
    }
}