-- remplissage de la db avec des données propres à notre site.

INSERT INTO db_genome.utilisateurs VALUES
	('annotateur@u-psud.fr', 'Michel' ,'Hanazouf', 0169017229, 'Le Caire, nid despion', DEFAULT, 'Annotateur','$2y$10$FINFfiZs7sPSl2hPXoTJrO7/bTfbAZLfUTOwL8Yyk7EZLpTsOG3yS'),
	('validateur@u-psud.fr', 'Marylin' ,'Mirnov', 0169017229, '214 rue Barbitruc', DEFAULT, 'Validateur','$2y$10$FINFfiZs7sPSl2hPXoTJrO7/bTfbAZLfUTOwL8Yyk7EZLpTsOG3yS'),
	('administrateur@u-psud.fr', 'Jean' ,'Castoux', 0169017229, '214 rue Elysion', DEFAULT, 'Admin','$2y$10$FINFfiZs7sPSl2hPXoTJrO7/bTfbAZLfUTOwL8Yyk7EZLpTsOG3yS'),
	('lecteur@u-psud.fr', 'Léonard' ,'Discipe', 0141307212, 'Italie', DEFAULT, 'Lecteur','$2y$10$FINFfiZs7sPSl2hPXoTJrO7/bTfbAZLfUTOwL8Yyk7EZLpTsOG3yS');

INSERT INTO db_genome.attribution_annotateur VALUES
	--annotés (et validés)
	('ASM744v1','AAN78501','annotateur@u-psud.fr',1,1),
	('ASM744v1','AAN79176','annotateur@u-psud.fr',1,1),
	('ASM666v1','AAG55546','annotateur@u-psud.fr',1,1),
	('ASM584v2','AAC73747','annotateur@u-psud.fr',1,1),
	--en cours d'annotation
	('ASM1330v1','ABG68280','annotateur@u-psud.fr',0,0),
	('ASM1330v1','ABG71480','annotateur@u-psud.fr',0,0);
