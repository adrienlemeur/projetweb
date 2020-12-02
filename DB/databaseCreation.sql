CREATE SCHEMA db_genome
	-- DOCUMENTATION : https://www.postgresql.org/docs/current/index.html
	
	CREATE TABLE utilisateurs (
		email  VARCHAR(50) PRIMARY KEY,
		prenom VARCHAR(20),
		nom VARCHAR(30),
		tel INT CHECK (tel > 0100000000), 
		adPhysique VARCHAR(100),
		dateConnexion DATE DEFAULT CURRENT_DATE,
		statut VARCHAR(10) DEFAULT ('Lecteur') CHECK (statut='Admin'or statut='Lecteur' or statut='Annotateur' or statut='Validateur'),
		mdp VARCHAR(30) NOT NULL
	)
	
	CREATE TABLE genome (
		nom_genome VARCHAR(36) PRIMARY KEY,
		seq TEXT NOT NULL,
		espece VARCHAR(50)
	)
	
	CREATE TABLE cds (
		nom_cds VARCHAR(15) PRIMARY KEY,
		chromosome VARCHAR(15) CHECK (chromosome='chromosome' or chromosome='plasmid'),
		seq_start INT,
		seq_end INT,
		gene VARCHAR(15) UNIQUE,
		gene_biotype VARCHAR(20),
		gene_symbol VARCHAR(15),
		description VARCHAR(1000),
		cds_sequence TEXT NOT NULL,
		nom_genome VARCHAR(35) REFERENCES genome
	)
	
	CREATE TABLE pep(
		nom_cds VARCHAR(15) PRIMARY KEY REFERENCES cds, --ATTENTION ICI ! voir si ça marche
		transcript VARCHAR(15) UNIQUE,
		transcript_biotype VARCHAR(20),
		seq_pep TEXT NOT NULL
	)
	
	CREATE TABLE attribution_annotateur(
		nom_genome VARCHAR(35) REFERENCES genome,
		nom_cds VARCHAR(15) REFERENCES cds,
		mail_annot VARCHAR(50) REFERENCES utilisateurs(email) ON UPDATE CASCADE,
		valide INT,
		PRIMARY KEY (nom_genome, nom_cds, mail_annot)
	);

--chargement des donnees dans la base

COPY db_genome.genome FROM '/home/ombeline/Documents/ProjetWeb/projetweb/DB/genome.csv' DELIMITERS ';' CSV HEADER;
COPY db_genome.cds FROM '/home/ombeline/Documents/ProjetWeb/projetweb/DB/cds.csv' DELIMITERS ';' CSV HEADER;
COPY db_genome.pep FROM '/home/ombeline/Documents/ProjetWeb/projetweb/DB/pep.csv' DELIMITERS ';' CSV HEADER;

