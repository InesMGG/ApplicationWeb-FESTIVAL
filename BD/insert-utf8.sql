
-- Certains établissements sont fictifs
insert into Etablissement values ('0350785N', 'College de Moka', '2 avenue AristidEquipee Briand BP 6', '35401', 'Saint-Malo', '0299206990', null,1,'M.','Dupont','Alain',20);
insert into Etablissement values ('0350123A', 'College Lamartine', '3, avenue des corsaires', '35404', 'Parame', '0299561459', null, 1,'Mme','Lefort','Anne',58);  
insert into Etablissement values ('0351234W', 'College Leonard de Vinci', '2 rue Rabelais', '35418', 'Saint-Malo', '0299117474', null, 1,'M.','Durand','Pierre',60);   
insert into Etablissement values ('11111111', 'Centre de rencontres internationales', '37 avenue du R.P. Umbricht BP 108', '35407', 'Saint-Malo', '0299000000', null, 0, 'M.','Guenroc','Guy',200);

-- Certains Equipes sont incomplètement renseignés
insert into Equipe (idEquipe, nomEquipe, nombrepersonnes, idPays, hebergement) values ('e001','Atlanta Bergamasca Calcio',40,'Ita','O');
insert into Equipe (idEquipe, nomEquipe, nombrepersonnes, idPays, hebergement) values ('e002','Los Angeles Lakers',25,'USA','O');
insert into Equipe (idEquipe, nomEquipe, nombrepersonnes, idPays, hebergement) values ('e003','All Blacks',34,'NZ','O');
insert into Equipe (idEquipe, nomEquipe, nombrepersonnes, idPays, hebergement) values ('e004','Ecurie McLaren Mercedes',38,'GB','O');
insert into Equipe (idEquipe, nomEquipe, nombrepersonnes, idPays, hebergement) values ('e005','Denvers Nuggets',22,'USA','O');
insert into Equipe (idEquipe, nomEquipe, nombrepersonnes, idPays, hebergement) values ('e006','New York Knicks',29,'USA','O');
insert into Equipe (idEquipe, nomEquipe, nombrepersonnes, idPays, hebergement) values ('e007','Boston Celtics',19,'USA','O');
insert into Equipe (idEquipe, nomEquipe, nombrepersonnes, idPays, hebergement) values ('e008','Milwaukee Bucks',5,'USA','O');
insert into Equipe (idEquipe, nomEquipe, nombrepersonnes, idPays, hebergement) values ('e009','Toronto Raptors',21,'USA','O');
insert into Equipe (idEquipe, nomEquipe, nombrepersonnes, idPays, hebergement) values ('e010','Brooklyn Nets',30,'USA','O');
insert into Equipe (idEquipe, nomEquipe, nombrepersonnes, idPays, hebergement) values ('e011','Atlanta Hawks',38,'USA','O');
insert into Equipe (idEquipe, nomEquipe, nombrepersonnes, idPays, hebergement) values ('e012','Chicago Bulls',22,'USA','O');
insert into Equipe (idEquipe, nomEquipe, nombrepersonnes, idPays, hebergement) values ('e013','Charlotte Hornets',13,'USA','O');
insert into Equipe (idEquipe, nomEquipe, nombrepersonnes, idPays, hebergement) values ('e014','Cleveland Cavaliers',26,'USA','O');
insert into Equipe (idEquipe, nomEquipe, nombrepersonnes, idPays, hebergement) values ('e015','Miami Heat',8,'USA','O');
insert into Equipe (idEquipe, nomEquipe, nombrepersonnes, idPays, hebergement) values ('e016','Detroit Pistons',40,'USA','O');
insert into Equipe (idEquipe, nomEquipe, nombrepersonnes, idPays, hebergement) values ('e017','Orlando Magic',40,'USA','O');
insert into Equipe (idEquipe, nomEquipe, nombrepersonnes, idPays, hebergement) values ('e018','Philadelphia 76ers',43,'USA','O');
insert into Equipe (idEquipe, nomEquipe, nombrepersonnes, idPays, hebergement) values ('e019','Indiana Pacers',27,'USA','O');
insert into Equipe (idEquipe, nomEquipe, nombrepersonnes, idPays, hebergement) values ('e020','Washington Wizards',34,'USA','O');
insert into Equipe (idEquipe, nomEquipe, nombrepersonnes, idPays, hebergement) values ('e021','Toronto Raptors',40,'USA','O');
insert into Equipe (idEquipe, nomEquipe, nombrepersonnes, idPays, hebergement) values ('e022','San Antonio Spurs',1,'USA','O');
insert into Equipe (idEquipe, nomEquipe, nombrepersonnes, idPays, hebergement) values ('e023','Dallas Mavericks',5,'USA','O');
insert into Equipe (idEquipe, nomEquipe, nombrepersonnes, idPays, hebergement) values ('e024','Houston Rockets',5,'USA','O');
insert into Equipe (idEquipe, nomEquipe, nombrepersonnes, idPays, hebergement) values ('e025','Paris-SG FC',2,'Fra','O');
insert into Equipe (idEquipe, nomEquipe, nombrepersonnes, idPays, hebergement) values ('e026','Olympique lyonnais',0,'Fra','N');
insert into Equipe (idEquipe, nomEquipe, nombrepersonnes, idPays, hebergement) values ('e027','Association sportive de Saint-Etienne',0,'Fra','N');
insert into Equipe (idEquipe, nomEquipe, nombrepersonnes, idPays, hebergement) values ('e028','LOSC Lille',0,'Fra','N');
insert into Equipe (idEquipe, nomEquipe, nombrepersonnes, idPays, hebergement) values ('e029','Stade Rennais football club',0,'Fra','N');
insert into Equipe (idEquipe, nomEquipe, nombrepersonnes, idPays, hebergement) values ('e030','OGC Nice',0,'Fra','N');


-- Les attributions sont fictives
insert into Attribution values ('0350785N', 'e001', 11);
insert into Attribution values ('0350785N', 'e002', 9);

insert into Attribution values ('0350123A', 'e004', 13);
insert into Attribution values ('0350123A', 'e005', 8);

insert into Attribution values ('0351234W', 'e001', 3);
insert into Attribution values ('0351234W', 'e006', 10);
insert into Attribution values ('0351234W', 'e007', 7);


insert into Pays values ('Ita', 'Italie', 'IMAGE/Ita.png');
insert into Pays values ('USA', 'Etats Unis', 'IMAGE/USA.png');
insert into Pays values ('Fra', 'France', 'IMAGE/Fra.png');
insert into Pays values ('GB', 'Grande Bretagne', 'IMAGE/GB.png');
insert into Pays values ('NZ', 'Nouvelle Zelande', 'IMAGE/NZ.png');