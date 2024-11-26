<?php

namespace App\Core\User\Application\Command\CreateUser;

use App\Core\User\Domain\Repository\UserRepositoryInterface;
use App\Core\User\Domain\User;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use App\Core\User\Domain\Exception\UserAlreadyExistsException;
use App\Core\User\Domain\Status\UserStatus;
use App\Core\User\Domain\Exception\UserNotFoundException;

#[AsMessageHandler]
class CreateUserHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {
    }

    public function __invoke(CreateUserCommand $command): void
    {
        $email = $command->email;
        try {
            $this->userRepository->getByEmail($email);
            throw new UserAlreadyExistsException('Użytkownik już istnieje');
        } catch (UserNotFoundException $e) {
            // User not found, continue with user creation
        }
        
        $user = new User($email);

        $user->setStatus(UserStatus::INACTIVE);

        $this->userRepository->save($user);

        $this->userRepository->flush();
    }
}