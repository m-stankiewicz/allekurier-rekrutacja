<?php

namespace App\Core\User\Application\Query\GetInactiveUsers;

use App\Core\User\Application\DTO\UserDTO;
use App\Core\User\Domain\Repository\UserRepositoryInterface;
use App\Core\User\Domain\User;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetInactiveUsersHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    )
    {
    }

    public function __invoke(GetInactiveUsersQuery $query): array
    {
        $inactiveUsers = $this->userRepository->getInactiveUsers();
        $userData = array_map(function (User $inactiveUser) {
            return new UserDTO(
                $inactiveUser->getEmail()
            );

        }, $inactiveUsers);

        return $userData;
    }
}