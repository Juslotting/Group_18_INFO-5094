--File: pathsdb.sql
--Purpose: to create a user and define a database
--Author: Group 18, Andi Ausrotas

DROP DATABASE if exists paths;
CREATE DATABASE if not exists paths CHARACTER SET utf8;

DROP USER 'lamp2user'@'localhost';
CREATE USER 'lamp2user'@'localhost' IDENTIFIED BY 'info5094';
GRANT ALL PRIVILEGES ON 'paths'.* TO 'lamp2user'@'localhost';

USE paths;

drop table if exists path_info;
drop table if exists path_beginning;
drop table if exists path_ending;
drop table if exists mid_points;

CREATE TABLE if not exists path_info (
    pi_id int(11) NOT NULL AUTO_INCREMENT,
    path_name varchar(100) NOT NULL UNIQUE,
    operating_frequency float(4,1) NOT NULL,
    pi_description varchar(255) NOT NULL,
    pi_note text(65534),
    CONSTRAINT paths_info_pk PRIMARY KEY (pi_id)
);

CREATE TABLE if not exists path_beginning (
    pb_id int(11) NOT NULL AUTO_INCREMENT,
    pb_distance float NOT NULL,
    pb_ground_height float NOT NULL,
    pb_antenna float NOT NULL,
    pb_cable_type ENUM('LDF4-50A', 'LDF5-50A', 'LDF-6-50', 'LDF7-50A', 'LDF12-50'),
    pb_cable_length float NOT NULL,
    CONSTRAINT path_beginning_pk PRIMARY KEY (pb_id)

);

CREATE TABLE if not exists path_ending (
    pe_id int(11) NOT NULL AUTO_INCREMENT,
    pe_distance float NOT NULL,
    pe_ground_height float NOT NULL,
    pe_antenna float NOT NULL,
    pe_cable_type ENUM('LDF4-50A', 'LDF5-50A', 'LDF-6-50', 'LDF7-50A', 'LDF12-50'),
    pe_cable_length float NOT NULL,
    CONSTRAINT path_ending_pk PRIMARY KEY (pe_id)

);

CREATE TABLE if not exists mid_points(
    md_id int(11) NOT NULL AUTO_INCREMENT,
    md_distance float NOT NULL,
    md_ground_height float NOT NULL,
    md_terrain ENUM('Grassland', 'Rough Grassland', 'Smooth rock', 'Bare Rock','Bare earth', 'Paved Surface', 'Lake', 'Ocean'),
    md_obstr_height float NOT NULL,
    md_obstr_type ENUM('None', 'Trees', 'Bush', 'Buildings', 'Webbed Towers', 'Solid Towers', 'Power Cables'),
    CONSTRAINT mid_points_pk PRIMARY KEY (md_id)
);
