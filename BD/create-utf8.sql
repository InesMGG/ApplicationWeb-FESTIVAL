GRANT ALL ON festival . * TO 'festival'@'localhost' IDENTIFIED BY 'secret';

DROP DATABASE IF EXISTS Festival;
DROP TABLE IF EXISTS Attribution;
DROP TABLE IF EXISTS Groupe;
DROP TABLE IF EXISTS Etablissement;

CREATE DATABASE Festival;
USE Festival;

create table Etablissement 
(idEtab char(8) not null, 
nomEtab varchar(45) not null,
adresseRue varchar(45) not null, 
codePostal char(5) not null, 
ville varchar(35) not null,
tel varchar(13) not null,
adresseElectronique varchar(70),
type tinyint not null,
civiliteResponsable varchar(12) not null,
nomResponsable varchar(25) not null,
prenomResponsable varchar(25),
nombreChambresOffertes integer,
constraint pk_Etablissement primary key(idEtab))
ENGINE=INNODB;

create table Pays
(idPays char(3) not null, 
nomPays char(30) not null,
drapeau varchar(15) not null,
constraint pk_Attribution primary key(idPays)) 
ENGINE=INNODB;

create table Equipe
(idEquipe char(4) not null, 
nomEquipe varchar(40) not null, 
identiteResponsable varchar(40) default null,
adressePostale varchar(120) default null,
nombrePersonnes integer not null, 
idPays varchar(40) not null references Pays(idPays), 
hebergement char(1) not null,
constraint pk_Equipe primary key(idEquipe))
ENGINE=INNODB;

create table Attribution
(idEtab char(8) not null references Etablissement(idEtab), 
idEquipe char(4) not null references Equipe(idEquipe), 
nombreChambres integer not null,
constraint pk_Attribution primary key(idEtab, idEquipe)) 
ENGINE=INNODB;