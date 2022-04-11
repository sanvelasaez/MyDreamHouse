<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201109113537 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_7F655D1DB7895EAF');
        $this->addSql('DROP INDEX IDX_7F655D1D4856300A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__casa AS SELECT id, id_ciu_id, id_usu_id, direccion, cp, tipo_venta, m2, precio, tipo_casa, propietario, telefono, email_casa, imagen_casa FROM casa');
        $this->addSql('DROP TABLE casa');
        $this->addSql('CREATE TABLE casa (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_ciu_id INTEGER NOT NULL, id_usu_id INTEGER DEFAULT NULL, m2 INTEGER DEFAULT NULL, precio INTEGER DEFAULT NULL, telefono INTEGER DEFAULT NULL, email_casa VARCHAR(50) DEFAULT NULL COLLATE BINARY, direccion VARCHAR(100) NOT NULL, cp VARCHAR(5) DEFAULT NULL, tipo_venta VARCHAR(8) DEFAULT NULL, tipo_casa VARCHAR(25) DEFAULT NULL, propietario VARCHAR(50) DEFAULT NULL, imagen_casa VARCHAR(150) DEFAULT NULL, titulo VARCHAR(100) DEFAULT NULL, descripcion CLOB DEFAULT NULL, CONSTRAINT FK_7F655D1D4856300A FOREIGN KEY (id_ciu_id) REFERENCES ciudad (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_7F655D1DB7895EAF FOREIGN KEY (id_usu_id) REFERENCES usuario (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO casa (id, id_ciu_id, id_usu_id, direccion, cp, tipo_venta, m2, precio, tipo_casa, propietario, telefono, email_casa, imagen_casa) SELECT id, id_ciu_id, id_usu_id, direccion, cp, tipo_venta, m2, precio, tipo_casa, propietario, telefono, email_casa, imagen_casa FROM __temp__casa');
        $this->addSql('DROP TABLE __temp__casa');
        $this->addSql('CREATE INDEX IDX_7F655D1DB7895EAF ON casa (id_usu_id)');
        $this->addSql('CREATE INDEX IDX_7F655D1D4856300A ON casa (id_ciu_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__ciudad AS SELECT id, nombre_ciudad FROM ciudad');
        $this->addSql('DROP TABLE ciudad');
        $this->addSql('CREATE TABLE ciudad (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre_ciudad VARCHAR(25) NOT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO ciudad (id, nombre_ciudad) SELECT id, nombre_ciudad FROM __temp__ciudad');
        $this->addSql('DROP TABLE __temp__ciudad');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8E86059E43721488 ON ciudad (nombre_ciudad)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_7F655D1D4856300A');
        $this->addSql('DROP INDEX IDX_7F655D1DB7895EAF');
        $this->addSql('CREATE TEMPORARY TABLE __temp__casa AS SELECT id, id_ciu_id, id_usu_id, direccion, cp, tipo_venta, m2, precio, tipo_casa, propietario, telefono, email_casa, imagen_casa FROM casa');
        $this->addSql('DROP TABLE casa');
        $this->addSql('CREATE TABLE casa (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_ciu_id INTEGER NOT NULL, id_usu_id INTEGER DEFAULT NULL, m2 INTEGER DEFAULT NULL, precio INTEGER DEFAULT NULL, telefono INTEGER DEFAULT NULL, email_casa VARCHAR(50) DEFAULT NULL, direccion VARCHAR(50) NOT NULL COLLATE BINARY, cp INTEGER DEFAULT NULL, tipo_venta VARCHAR(7) DEFAULT NULL COLLATE BINARY, tipo_casa VARCHAR(15) DEFAULT NULL COLLATE BINARY, propietario VARCHAR(25) DEFAULT NULL COLLATE BINARY, imagen_casa VARCHAR(50) DEFAULT NULL COLLATE BINARY, fecha_constr INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO casa (id, id_ciu_id, id_usu_id, direccion, cp, tipo_venta, m2, precio, tipo_casa, propietario, telefono, email_casa, imagen_casa) SELECT id, id_ciu_id, id_usu_id, direccion, cp, tipo_venta, m2, precio, tipo_casa, propietario, telefono, email_casa, imagen_casa FROM __temp__casa');
        $this->addSql('DROP TABLE __temp__casa');
        $this->addSql('CREATE INDEX IDX_7F655D1D4856300A ON casa (id_ciu_id)');
        $this->addSql('CREATE INDEX IDX_7F655D1DB7895EAF ON casa (id_usu_id)');
        $this->addSql('DROP INDEX UNIQ_8E86059E43721488');
        $this->addSql('CREATE TEMPORARY TABLE __temp__ciudad AS SELECT id, nombre_ciudad FROM ciudad');
        $this->addSql('DROP TABLE ciudad');
        $this->addSql('CREATE TABLE ciudad (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre_ciudad VARCHAR(25) NOT NULL)');
        $this->addSql('INSERT INTO ciudad (id, nombre_ciudad) SELECT id, nombre_ciudad FROM __temp__ciudad');
        $this->addSql('DROP TABLE __temp__ciudad');
    }
}
