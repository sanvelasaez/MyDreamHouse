<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201007170021 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE casa (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_ciu_id INTEGER NOT NULL, id_usu_id INTEGER DEFAULT NULL, direccion VARCHAR(50) NOT NULL, cp INTEGER DEFAULT NULL, tipo_venta VARCHAR(7) DEFAULT NULL, m2 INTEGER DEFAULT NULL, precio INTEGER DEFAULT NULL, tipo_casa VARCHAR(15) DEFAULT NULL, propietario VARCHAR(25) DEFAULT NULL, telefono INTEGER DEFAULT NULL, email_casa VARCHAR(50) DEFAULT NULL, fecha_constr INTEGER DEFAULT NULL, imagen_casa VARCHAR(50) DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_7F655D1D4856300A ON casa (id_ciu_id)');
        $this->addSql('CREATE INDEX IDX_7F655D1DB7895EAF ON casa (id_usu_id)');
        $this->addSql('CREATE TABLE ciudad (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre_ciudad VARCHAR(25) NOT NULL)');
        $this->addSql('CREATE TABLE usuario (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, nombre VARCHAR(15) DEFAULT NULL, apellidos VARCHAR(25) DEFAULT NULL, fecha_nac DATE DEFAULT NULL, imagen_usu VARCHAR(50) DEFAULT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2265B05DE7927C74 ON usuario (email)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE casa');
        $this->addSql('DROP TABLE ciudad');
        $this->addSql('DROP TABLE usuario');
    }
}
