<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220704122546 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C432DE18E50B');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C4329D86650F');
        $this->addSql('DROP INDEX IDX_8933C432DE18E50B ON favoris');
        $this->addSql('DROP INDEX IDX_8933C4329D86650F ON favoris');
        $this->addSql('ALTER TABLE favoris ADD user_id INT NOT NULL, ADD product_id INT NOT NULL, DROP user_id_id, DROP product_id_id');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C432A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C4324584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_8933C432A76ED395 ON favoris (user_id)');
        $this->addSql('CREATE INDEX IDX_8933C4324584665A ON favoris (product_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C432A76ED395');
        $this->addSql('ALTER TABLE favoris DROP FOREIGN KEY FK_8933C4324584665A');
        $this->addSql('DROP INDEX IDX_8933C432A76ED395 ON favoris');
        $this->addSql('DROP INDEX IDX_8933C4324584665A ON favoris');
        $this->addSql('ALTER TABLE favoris ADD user_id_id INT NOT NULL, ADD product_id_id INT NOT NULL, DROP user_id, DROP product_id');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C432DE18E50B FOREIGN KEY (product_id_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C4329D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8933C432DE18E50B ON favoris (product_id_id)');
        $this->addSql('CREATE INDEX IDX_8933C4329D86650F ON favoris (user_id_id)');
    }
}
