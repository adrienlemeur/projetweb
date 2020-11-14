CREATE SCHEMA db_genome
	-- DOCUMENTATION : https://www.postgresql.org/docs/current/index.html
	
	CREATE TABLE utilisateurs (
		email  VARCHAR(50) PRIMARY KEY,
		prenom VARCHAR(20),
		nom VARCHAR(30),
		tel INT CHECK (tel > 0100000000), 
		adPhysique VARCHAR(100),
		dateConnexion DATE DEFAULT CURRENT_DATE,
		statut VARCHAR(10) DEFAULT ('Lecteur') CHECK in ('Admin', 'Lecteur','Annotateur','Validateur'),
		mdp VARCHAR(30) NOT NULL
	)
	
	CREATE TABLE genome (
		nom_genome VARCHAR(36) PRIMARY KEY,
		seq TEXT NOT NULL,
		espèce VARCHAR(30)
	)
	
	CREATE TABLE cds (
		nom_cds VARCHAR(10) PRIMARY KEY,
		chromosome VARCHAR(10) CHECK in ('chromosome', 'plasmid'),
		seq_start INT,
		seq_end INT,
		gene VARCHAR(10) UNIQUE,
		gene_biotype VARCHAR(20),
		gene_symbol VARCHAR(15),
		description VARCHAR(100),
		cds_sequence TEXT NOT NULL,
		nom_genome VARCHAR(35) REFERENCES genome
	)
	
	CREATE TABLE pep(
		transcript VARCHAR(10) PRIMARY KEY,
		nom_cds VARCHAR(10) REFERENCES cds,
		transcript_biotype VARCHAR(20),
		seq_pep TEXT NOT NULL
	)
	
	CREATE TABLE attribution_annotateur(
		nom_genome VARCHAR(35) REFERENCES genome,
		nom_cds VARCHAR(10) REFERENCES cds,
		mail_annot VARCHAR(50) REFERENCES utilisateurs(email) ON UPDATE CASCADE,
		valide INT,
		PRIMARY KEY (nom_genome, nom_cds, mail_annot)
	)
