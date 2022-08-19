<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220819205302 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Пересоздал таблицу User.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE "user" (id UUID NOT NULL, email VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, enabled BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE "user"');
    }
}
