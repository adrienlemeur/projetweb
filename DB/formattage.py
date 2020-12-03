# author : ombeline lamer
# date : 7 nov 2020 
# Objectif : formatter les fichiers fa pour remplir la base de données du site web

# commande d'appel: python3 formattage.py listeFichier.txt

import sys


fichier=open(sys.argv[1])
fasta=fichier.readlines() #fasta contient les noms de tous les fichiers du dossier data
fichier.close()

# tri des fichiers suivant leurs contenus
fileType={"adn":[],"cds":[],"pep":[]}

for fichier in fasta:
	fichier=fichier.strip()
	
	if fichier[-6:]=="pep.fa" :
		fileType['pep'].append(fichier)
	elif fichier[-6:]=="cds.fa" :
		fileType['cds'].append(fichier)
	else : #c'est un genome complet
		fileType['adn'].append(fichier)

"""Pour chaque type de fichier, on va remplir un dictionnaire dont on sauvegardera le contenu dans un fichier csv (pour remplir la DB avec un LOAD DATA FILE) """

### Pour les génomes - prise des infos d'intérêt
dgenome={"listeGenome":[]}

for genome in fileType["adn"] :
	
	fichier=open("/home/ombeline/Documents/ProjetWeb/data/"+genome) #VERIFIER LE CHEMIN !
	lignes=fichier.readlines() #lignes contient toutes les lignes du fichier
	fichier.close()
	
	dgenome["listeGenome"].append(genome)
	seq=""
	for line in lignes :
		
		espece=genome[:-3]
		if line[0]==">":
			line.strip()
			line=line.split()
			
			nomGenome=line[2].split(":")
			nomGenome=nomGenome[1]
		else :
			seq=seq+line.strip()
		
	dgenome[genome]={"nomGenome":nomGenome,"espece":espece,"seq":seq}

### Pour les genomes - creation csv
f=open("./genome.csv","w")

#HEADER
f.write("nom_genome;seq;espece\n")

#1 ligne = tous les attributs de l'individu à rentrer dans la table
for genome in dgenome["listeGenome"] :
	
	tmp=dgenome[genome]
	f.write(tmp["nomGenome"]+";"+tmp["seq"]+";"+tmp["espece"]+"\n")	
	
f.close()

del dgenome #suppression du dictionnaire devenu inutile

### Pour les cds - prise des infos d'intérêt
dCDS={"listeCDSfile":[]}

for cdsFile in fileType["cds"] :
	
	fichier=open("/home/ombeline/Documents/ProjetWeb/data/"+cdsFile) #VERIFIER LE CHEMIN !
	lignes=fichier.readlines() 
	fichier.close()
	
	dCDS["listeCDSfile"].append(cdsFile)
	dCDS[cdsFile]={}
	seq=''
	
	for line in lignes :
		
		if line[0]==">":
			
			line=line.split()
			#on veut les tags suivant :
			#nom_cds;chromosome;seq_start;seq_end;gene;gene_biotype;
			#gene_symbol;description;cds_sequence;nom_genome
			
			cds=line[0][1:]
			
			chromosome=line[2].split(":")[0]
			nom_genome=line[2].split(":")[1]
			seq_start=line[2].split(":")[3]
			seq_end=line[2].split(":")[4]
			
			gene=''
			gene_biotype=''
			gene_symbol=''
			description=''
			des=False
			
			for tag in line[2:]:
				
				if tag[:5]=="gene:":
					gene=tag.split(":")[1]
				if tag[:12]=="gene_biotype":
					gene_biotype=tag.split(":")[1]
				if tag[:11]=="gene_symbol":
					gene_symbol=tag.split(":")[1]
				if tag[:11]=="description":
					des=True
					mot1=tag.split(":")[1]
					
					description=mot1
				if des==True and mot1 not in tag :
					description=description+" "+tag
			
			seq='' #remise à zero de la sequence
			
			#enlever les ";" de la description (mortels pour le csv)
			description=description.replace(";",",")
			#description=description.replace("'"," ") #pour ne pas que ça cause des erreurs dans le dump DB
			
			dCDS[cdsFile][cds]={'chromosome':chromosome, 'seq_start':seq_start, 'seq_end':seq_end, 'gene':gene, 'gene_biotype':gene_biotype, 'gene_symbol':gene_symbol, 'description': description, 'nom_genome':nom_genome}
			
			
		else : #recuperation de la sequence
			seq=seq+line.strip()
			dCDS[cdsFile][cds]["seq"]=seq

### Pour les cds - creation csv

f=open("./cds.csv","w")

#HEADER
f.write("nom_cds;chromosome;seq_start;seq_end;gene;gene_biotype;gene_symbol;description;cds_sequence;nom_genome\n")

#1 ligne = tous les attributs de l'individu à rentrer dans la table
for fichier in dCDS["listeCDSfile"] :
	for cds in dCDS[fichier].keys() :
		#selection des données depuis le dictionnaire
		nom_cds=cds
		chromosome=dCDS[fichier][cds]['chromosome']
		seq_start=dCDS[fichier][cds]['seq_start']
		seq_end=dCDS[fichier][cds]['seq_end']
		gene=dCDS[fichier][cds]['gene']
		gene_biotype=dCDS[fichier][cds]['gene_biotype']
		gene_symbol=dCDS[fichier][cds]['gene_symbol']
		description=dCDS[fichier][cds]['description']
		cds_sequence=dCDS[fichier][cds]['seq']
		nom_genome=dCDS[fichier][cds]['nom_genome']
		
		#ecriture de la ligne/n-uplet dans le csv
		f.write(nom_cds+";"+chromosome+";"+seq_start+";"+seq_end+";"+gene+";"+gene_biotype+";"+ gene_symbol+";"+description+";"+cds_sequence+";"+nom_genome+"\n") #a modifier

f.close()

del dCDS #suppression du dictionnaire devenu inutile

### Pour les pep - prise des infos d'intérêt
dPEP={"listePEPfile":[]}

for pepFile in fileType["pep"] :
	
	fichier=open("/home/ombeline/Documents/ProjetWeb/data/"+pepFile) #VERIFIER LE CHEMIN !
	lignes=fichier.readlines() 
	fichier.close()
	
	dPEP["listePEPfile"].append(pepFile)
	dPEP[pepFile]={}
	seq=''
	
	for line in lignes :
		
		if line[0]==">":
			
			line=line.split()
			#on veut les tags suivant :
			#transcript, nom_cds, transcript_biotype, seq_pep
			
			nom_cds=line[0][1:] #meme que le nom du cds
			
			transcript='' #meme nom que le cds mais pas toujours là...
			transcript_biotype=''
			
			for tag in line[2:]:
				
				if tag[:5]=="gene:":
					transcript=tag.split(":")[1]
				if tag[:18]=="transcript_biotype":
					transcript_biotype=tag.split(":")[1]
			
			seq='' #remise à zero de la sequence
			
			dPEP[pepFile][nom_cds]={'transcript':transcript, 'transcript_biotype':transcript_biotype}
			
			
		else : #recuperation de la sequence
			seq=seq+line.strip()
			dPEP[pepFile][nom_cds]["seq"]=seq

### Pour les pep - creation csv

f=open("./pep.csv","w")

#HEADER
f.write("nom_cds;transcript;transcript_biotype;seq_pep\n")

#1 ligne = tous les attributs de l'individu à rentrer dans la table
for fichier in dPEP["listePEPfile"] :
	for pep in dPEP[fichier].keys() :
		#selection des données depuis le dictionnaire
		nom_cds=pep
		transcript=dPEP[fichier][pep]['transcript']
		transcript_biotype=dPEP[fichier][pep]['transcript_biotype']
		seq_pep=dPEP[fichier][pep]['seq']
		
		#ecriture de la ligne/n-uplet dans le csv
		f.write(nom_cds+";"+transcript+";"+transcript_biotype+";"+ seq_pep+"\n")

f.close()

del dPEP #suppression du dictionnaire devenu inutile
