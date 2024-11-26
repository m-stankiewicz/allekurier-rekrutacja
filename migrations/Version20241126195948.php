<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use App\Core\User\Domain\Status\UserStatus;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241126195948 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add status column to users table with UserStatus enum';
    }

    public function up(Schema $schema): void
    {
        $defaultStatus = UserStatus::INACTIVE->value;

        $this->addSql("ALTER TABLE users ADD status VARCHAR(16) NOT NULL DEFAULT '$defaultStatus'");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("ALTER TABLE users DROP COLUMN status");
    }
}
