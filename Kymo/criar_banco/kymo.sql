/*criar banco*/
CREATE DATABASE kymo;

USE kymo;

/*criar tabela*/
CREATE TABLE users(
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(255),
	email VARCHAR(255),
	password VARCHAR(255),
	PRIMARY KEY(id)
);