<?php

namespace App\Core\User\Domain;

use App\Common\EventManager\EventsCollectorTrait;
use Doctrine\ORM\Mapping as ORM;
use App\Core\User\Domain\Status\UserStatus;
use App\Core\User\Domain\Event\UserCreatedEvent;

#[ORM\Entity]
#[ORM\Table(name: "users")]
class User
{
    use EventsCollectorTrait;

    #[ORM\Id]
    #[ORM\Column(type: "integer", options: ["unsigned" => true], nullable: false)]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    private ?int $id;

    #[ORM\Column(type: "string", length: 16, nullable: false, enumType: UserStatus::class)]
    private UserStatus $status;

    #[ORM\Column(type: "string", length: 300, nullable: false)]
    private string $email;

    public function __construct(string $email)
    {
        $this->id = null;
        $this->email = $email;
        $this->record(new UserCreatedEvent($this));
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getStatus(): UserStatus
    {
        return $this->status;
    }

    public function setStatus(UserStatus $status): void
    {
        $this->status = $status;
    }
}
