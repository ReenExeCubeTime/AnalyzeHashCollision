<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160103184110 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql([
            '
                CREATE TABLE IF NOT EXISTS `md5_map`(
                    `from` CHAR(32) NOT NULL,
                    `to` CHAR(32) NOT NULL,
                    UNIQUE KEY (`from`)
                );
            ',
            '
                INSERT INTO `md5_map`(`from`, `to`)
                VALUES (NOW(), MD5(NOW()));
            '
        ]);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
