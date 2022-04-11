<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201116161241 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fotos (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_casa_id INTEGER NOT NULL, ruta VARCHAR(255) DEFAULT NULL, principal INTEGER DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_CB8405C79EEFEAD2 ON fotos (id_casa_id)');
        $this->addSql('CREATE TABLE propietario (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(50) DEFAULT NULL, email_prop VARCHAR(100) DEFAULT NULL, telefono INTEGER DEFAULT NULL, tipo_propietario VARCHAR(50) DEFAULT NULL)');
        $this->addSql('DROP TABLE Idealista1');
        $this->addSql('DROP TABLE Idealista2');
        $this->addSql('DROP TABLE Idealista3_2');
        $this->addSql('DROP TABLE idealistaimg');
        $this->addSql('DROP INDEX IDX_7F655D1D4856300A');
        $this->addSql('DROP INDEX IDX_7F655D1DB7895EAF');
        $this->addSql('CREATE TEMPORARY TABLE __temp__casa AS SELECT id, id_ciu_id, id_usu_id, m2, precio, telefono, email_casa, direccion, cp, tipo_venta, tipo_casa, propietario, imagen_casa, titulo, descripcion FROM casa');
        $this->addSql('DROP TABLE casa');
        $this->addSql('CREATE TABLE casa (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_ciu_id INTEGER NOT NULL, id_usu_id INTEGER DEFAULT NULL, id_prop_id INTEGER DEFAULT NULL, m2 INTEGER DEFAULT NULL, precio INTEGER DEFAULT NULL, telefono INTEGER DEFAULT NULL, email_casa VARCHAR(50) DEFAULT NULL COLLATE BINARY, direccion VARCHAR(100) NOT NULL COLLATE BINARY, cp VARCHAR(5) DEFAULT NULL COLLATE BINARY, tipo_venta VARCHAR(8) DEFAULT NULL COLLATE BINARY, tipo_casa VARCHAR(25) DEFAULT NULL COLLATE BINARY, propietario VARCHAR(50) DEFAULT NULL COLLATE BINARY, imagen_casa VARCHAR(150) DEFAULT NULL COLLATE BINARY, titulo VARCHAR(100) DEFAULT NULL COLLATE BINARY, descripcion CLOB DEFAULT NULL COLLATE BINARY, habitaciones INTEGER DEFAULT NULL, banos INTEGER DEFAULT NULL, coordenadas VARCHAR(30) DEFAULT NULL, especificaciones CLOB DEFAULT NULL, prioridad INTEGER DEFAULT NULL, extra1 VARCHAR(50) DEFAULT NULL, extra2 VARCHAR(50) DEFAULT NULL, CONSTRAINT FK_7F655D1D4856300A FOREIGN KEY (id_ciu_id) REFERENCES ciudad (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_7F655D1DB7895EAF FOREIGN KEY (id_usu_id) REFERENCES usuario (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_7F655D1D2E56CD FOREIGN KEY (id_prop_id) REFERENCES propietario (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO casa (id, id_ciu_id, id_usu_id, m2, precio, telefono, email_casa, direccion, cp, tipo_venta, tipo_casa, propietario, imagen_casa, titulo, descripcion) SELECT id, id_ciu_id, id_usu_id, m2, precio, telefono, email_casa, direccion, cp, tipo_venta, tipo_casa, propietario, imagen_casa, titulo, descripcion FROM __temp__casa');
        $this->addSql('DROP TABLE __temp__casa');
        $this->addSql('CREATE INDEX IDX_7F655D1D4856300A ON casa (id_ciu_id)');
        $this->addSql('CREATE INDEX IDX_7F655D1DB7895EAF ON casa (id_usu_id)');
        $this->addSql('CREATE INDEX IDX_7F655D1D2E56CD ON casa (id_prop_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Idealista1 (tipo_venta CLOB DEFAULT NULL COLLATE BINARY, Page_URL INTEGER DEFAULT NULL, titulo CLOB DEFAULT NULL COLLATE BINARY, direccion CLOB DEFAULT NULL COLLATE BINARY, precio INTEGER DEFAULT NULL, m2 INTEGER DEFAULT NULL, tipo_casa CLOB DEFAULT NULL COLLATE BINARY, propietario CLOB DEFAULT NULL COLLATE BINARY, telefono CLOB DEFAULT NULL COLLATE BINARY, email CLOB DEFAULT NULL COLLATE BINARY, ciudad CLOB DEFAULT NULL COLLATE BINARY, img CLOB DEFAULT NULL COLLATE BINARY, descripcion CLOB DEFAULT NULL COLLATE BINARY, zona CLOB DEFAULT NULL COLLATE BINARY)');
        $this->addSql('CREATE TABLE Idealista2 (tipo_venta CLOB DEFAULT NULL COLLATE BINARY, referencia INTEGER DEFAULT NULL, titulo CLOB DEFAULT NULL COLLATE BINARY, direccion CLOB DEFAULT NULL COLLATE BINARY, ciudad CLOB DEFAULT NULL COLLATE BINARY, zona CLOB DEFAULT NULL COLLATE BINARY, habitaciones INTEGER DEFAULT NULL, baños CLOB DEFAULT NULL COLLATE BINARY, extras1 CLOB DEFAULT NULL COLLATE BINARY, extras2 CLOB DEFAULT NULL COLLATE BINARY, img CLOB DEFAULT NULL COLLATE BINARY, img_secundaria CLOB DEFAULT NULL COLLATE BINARY, coordenadas CLOB DEFAULT NULL COLLATE BINARY)');
        $this->addSql('CREATE TABLE Idealista3_2 (tipo_venta CLOB DEFAULT NULL COLLATE BINARY, referencia INTEGER DEFAULT NULL, titulo CLOB DEFAULT NULL COLLATE BINARY, ciudad CLOB DEFAULT NULL COLLATE BINARY, zona CLOB DEFAULT NULL COLLATE BINARY, descripcion CLOB DEFAULT NULL COLLATE BINARY, especificaciones CLOB DEFAULT NULL COLLATE BINARY, tipo_propietario CLOB DEFAULT NULL COLLATE BINARY, telefono INTEGER DEFAULT NULL)');
        $this->addSql('CREATE TABLE idealistaimg (referencia INTEGER DEFAULT NULL, ruta CLOB DEFAULT NULL COLLATE BINARY)');
        $this->addSql('DROP TABLE fotos');
        $this->addSql('DROP TABLE propietario');
        $this->addSql('DROP INDEX IDX_7F655D1D4856300A');
        $this->addSql('DROP INDEX IDX_7F655D1DB7895EAF');
        $this->addSql('DROP INDEX IDX_7F655D1D2E56CD');
        $this->addSql('CREATE TEMPORARY TABLE __temp__casa AS SELECT id, id_ciu_id, id_usu_id, direccion, cp, tipo_venta, m2, precio, tipo_casa, propietario, telefono, email_casa, imagen_casa, titulo, descripcion FROM casa');
        $this->addSql('DROP TABLE casa');
        $this->addSql('CREATE TABLE casa (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_ciu_id INTEGER NOT NULL, id_usu_id INTEGER DEFAULT NULL, direccion VARCHAR(100) NOT NULL, cp VARCHAR(5) DEFAULT NULL, tipo_venta VARCHAR(8) DEFAULT NULL, m2 INTEGER DEFAULT NULL, precio INTEGER DEFAULT NULL, tipo_casa VARCHAR(25) DEFAULT NULL, propietario VARCHAR(50) DEFAULT NULL, telefono INTEGER DEFAULT NULL, email_casa VARCHAR(50) DEFAULT NULL, imagen_casa VARCHAR(150) DEFAULT NULL, titulo VARCHAR(100) DEFAULT NULL, descripcion CLOB DEFAULT NULL)');
        $this->addSql('INSERT INTO casa (id, id_ciu_id, id_usu_id, direccion, cp, tipo_venta, m2, precio, tipo_casa, propietario, telefono, email_casa, imagen_casa, titulo, descripcion) SELECT id, id_ciu_id, id_usu_id, direccion, cp, tipo_venta, m2, precio, tipo_casa, propietario, telefono, email_casa, imagen_casa, titulo, descripcion FROM __temp__casa');
        $this->addSql('DROP TABLE __temp__casa');
        $this->addSql('CREATE INDEX IDX_7F655D1D4856300A ON casa (id_ciu_id)');
        $this->addSql('CREATE INDEX IDX_7F655D1DB7895EAF ON casa (id_usu_id)');
    }
}
