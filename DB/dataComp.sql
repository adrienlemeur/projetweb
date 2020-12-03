-- remplissage de la db avec des données propres à notre site.

INSERT INTO db_genome.utilisateurs VALUES
	('ombeline.lamer@u-psud.fr', 'ombeline' ,'lamer', 0169017229, '8 rue du haras 91240 Saint michel sur Orge', DEFAULT, 'Admin','Kuran240'),
	('validateur@validetout.com','Valid1','Martin', 0101010101,'3 avenue de nul part 44666 Sous-les-etoiles',DEFAULT, 'Validateur','mdp'),
	('lecteur@litout.com','Lect1','LaFontaine', 0101010102,'5 boulevard St Michel 78000 Paris',DEFAULT, 'Lecteur','mdp'),
	('annotateur1@annotetout.com','Anno1','Molière', 0101010103,'5 rue je note tout 42600 Ville-ville',DEFAULT, 'Annotateur','mdp'),
	('annotateur2@annotetout.com','Anno2','Corneille', 0101010104,'10 chemin des poètes 94100 Ile-du-Reve',DEFAULT, 'Annotateur','mdp');

INSERT INTO db_genome.attribution_annotateur VALUES
	--annotés (et validés)
	('ASM744v1','AAN78501','annotateur1@annotetout.com',1,1),
	('ASM744v1','AAN79176','annotateur1@annotetout.com',1,1),
	('ASM666v1','AAG55546','annotateur2@annotetout.com',1,1),
	('ASM584v2','AAC73747','annotateur2@annotetout.com',1,1),
	--en cours d'annotation
	('ASM1330v1','ABG68280','annotateur1@annotetout.com',0,0),
	('ASM1330v1','ABG71480','annotateur2@annotetout.com',0,0);
