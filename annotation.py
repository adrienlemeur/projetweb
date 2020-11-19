#author : ombeline lamer
#date : 7 nov 2020 
# Objectif : lister les annotations possibles et voir la format (type et taille) des tags
# + : Possibilite de voir si le label de l'annotation peut etre mis sous forme de menu déroulant

#commande d'appel: python3 annotation.py listeFichier.txt

import sys

dADN={}
dADN['nom']={}
dCDS={}
dCDS['nom']={}
dPEP={}
dPEP['nom']={}

fichier=open(sys.argv[1])
fasta=fichier.readlines() #fasta contient les noms de tous les fichiers du dossier data
fichier.close()

for file in fasta:
	#pour chaque fichier, on charge ses lignes (>annotions + seq fasta)
	fichier=open("../data/"+file[:-1]) #VERIFIER LE CHEMIN !
	lignes=fichier.readlines() #lignes contient toutes les lignes du fichiers 
	fichier.close
	
	#lecture des lignes
	for line in lignes: #pour toutes les lignes du fichier
		if line[0]==">":
			
			#si la ligne (du fichier) est une annotation, on la découpe
			line=line.split() #chaque mot est séparé
			
			#choix du dictionnaire en fonction du type de fichier
			if  line[1][0:3]=="dna":
				#stockage data dans dADN
				
				if line[0][1:] not in dADN['nom']:
					dADN['nom'][line[0][1:]]=1
				else : #in dADN['nom']
					dADN['nom'][line[0][1:]]=dADN['nom'][line[0][1:]]+1
					#comptage de fois où (ce) nom apparait
				
				for i in range(1,len(line)): #pour chq mot de ligne apres le >nom
					#check si la valeur existe ds le dico
						#si non, on cree l'espace dico et mise à 1
						#si oui, on ajoute 1
						
					detach=line[i].split(":") #decoupe la ligne à chq ":"
					
					if detach[0] not in dADN : #le tag n'est pas entré
						dADN[detach[0]]={}
						dADN[detach[0]][line[i][len(detach[0]):]]=1
						
					else : #le tag est déjà rentré
						
						#le label n'est pas rentré
						if line[i][len(detach[0]):] not in dADN[detach[0]]:
							dADN[detach[0]][line[i][len(detach[0]):]]=1
						else : #le label est rentré
							dADN[detach[0]][line[i][len(detach[0]):]]=dADN[detach[0]][line[i][len(detach[0]):]]+1
			
			
			elif line[1]=="cds":
				#stockage data dans dCDS
				
				if line[0][1:] not in dCDS['nom']:
					dCDS['nom'][line[0][1:]]=1
				else :
					dCDS['nom'][line[0][1:]]=dCDS['nom'][line[0][1:]]+1
					#comptage de fois où (ce) nom apparait
				
				#trouver où se trouve la description
				locDes=0
				i=0
				while i!=len(line)-1 and line[i][:11]!="description":
					locDes=locDes+1
					i=i+1
				#et si absence de description ?
				if locDes==len(line)-1:
					end=len(line)
				else:
					end=locDes+1
				
				for i in range(1,end): #pour chq mot de ligne apres le >nom ET jusqu'a la description
					#check si la valeur existe ds le dico
						#si non, on cree l'espace dico et mise à 1
						#si oui, on ajoute 1
						
					detach=line[i].split(":") #decoupe la ligne à chq ":"
					
					if detach[0]=="description":
						#tous les mots de/apres description sont espaces
						#line[i] contient description:label1
						#line[i+1] à line[i+N] contiennent les autres labels
						#rattaché à description.
						
						#on cree le tag description si besoin
						if "description" not in dCDS:
							dCDS['description']={}
						#on ajoute le 1er mot si besoin
						#sinon on augmente son compteur
						if detach[1] not in dCDS['description']:
							dCDS['description'][detach[1]]=1
						else :
							dCDS['description'][detach[1]]=dCDS['description'][detach[1]]+1
					
						#on ajoute tout les autres mots de la ligne si besoin
						#sinon on augmente leur compteur
						for j in range(locDes+1,len(line)):
							if line[j] not in dCDS['description']:
								dCDS['description'][line[j]]=1
							else :
								dCDS['description'][line[j]]=dCDS['description'][line[j]]+1
						
					else : #detach[0]!="description"
						if detach[0] not in dCDS :
						#le tag n'est pas entré
							dCDS[detach[0]]={}
							dCDS[detach[0]][line[i][len(detach[0]):]]=1
							
						else: #le tag est déjà rentré
							#le label n'est pas rentré
							if line[i][len(detach[0]):] not in dCDS[detach[0]]:
								dCDS[detach[0]][line[i][len(detach[0]):]]=1
							else : #le label est rentré
								dCDS[detach[0]][line[i][len(detach[0]):]]=dCDS[detach[0]][line[i][len(detach[0]):]]+1
						
				
			elif line[1]=="pep": #ou bien else
				#stockage data dans dPEP
				
				#MEME CODE QUE CDS pour dPEP // OUAIS CEST MOCHE MAIS CA MARCHE
				#BrutDeDecoffrage #Bourrin #OnYCroitMemeA3hDuMat
				if line[0][1:] not in dPEP['nom']:
					dPEP['nom'][line[0][1:]]=1
				else :
					dPEP['nom'][line[0][1:]]=dPEP['nom'][line[0][1:]]+1
					#comptage de fois où (ce) nom apparait
				
				#trouver où se trouve la description
				locDes=0
				i=0
				while i!=len(line)-1 and line[i][:11]!="description":
					locDes=locDes+1
					i=i+1
				#et si absence de description ?
				if locDes==len(line)-1:
					end=len(line)
				else:
					end=locDes+1
				
				for i in range(1,end): #pour chq mot de ligne apres le >nom ET jusqu'a la description
					#check si la valeur existe ds le dico
						#si non, on cree l'espace dico et mise à 1
						#si oui, on ajoute 1
						
					detach=line[i].split(":") #decoupe la ligne à chq ":"
					
					if detach[0]=="description":
						#tous les mots de/apres description sont espaces
						#line[i] contient description:label1
						#line[i+1] à line[i+N] contiennent les autres labels
						#rattaché à description.
						
						#on cree le tag description si besoin
						if "description" not in dPEP:
							dPEP['description']={}
						#on ajoute le 1er mot si besoin
						#sinon on augmente son compteur
						if detach[1] not in dPEP['description']:
							dPEP['description'][detach[1]]=1
						else :
							dPEP['description'][detach[1]]=dPEP['description'][detach[1]]+1
					
						#on ajoute tout les autres mots de la ligne si besoin
						#sinon on augmente leur compteur
						for j in range(locDes+1,len(line)):
							if line[j] not in dPEP['description']:
								dPEP['description'][line[j]]=1
							else :
								dPEP['description'][line[j]]=dPEP['description'][line[j]]+1
						
					else : #detach[0]!="description"
						if detach[0] not in dPEP :
						#le tag n'est pas entré
							dPEP[detach[0]]={}
							dPEP[detach[0]][line[i][len(detach[0]):]]=1
							
						else: #le tag est déjà rentré
							#le label n'est pas rentré
							if line[i][len(detach[0]):] not in dPEP[detach[0]]:
								dPEP[detach[0]][line[i][len(detach[0]):]]=1
							else : #le label est rentré
								dPEP[detach[0]][line[i][len(detach[0]):]]=dPEP[detach[0]][line[i][len(detach[0]):]]+1

### Stockage des données collectées.
""" un document texte par dictionnaire contenant
	les différentes tags en colonne
	les possibles annotations listées et/ou comptées (?)"""

noms=["ADN","CDS","PEP"]
dico=[dADN,dCDS,dPEP]

#dCDS.keys()
#['nom', 'cds', 'chromosome', 'gene', 'gene_biotype', 'transcript_biotype', 'gene_symbol', 'plasmid']
#dPEP.keys()
#['nom', 'pep', 'chromosome', 'gene', 'transcript', 'gene_biotype', 'transcript_biotype', 'gene_symbol', 'description', 'plasmid']
#dADN.keys()
#['nom', 'dna', 'chromosome', 'REF']

for i in range (0,3):
	#ouverture du fichier pour stockage des informations
	f = open("Annotations_"+noms[i]+".txt","w")
	
	## EN-TETE
	f.write("###################\n")
	
	tmp=noms[i]
	f.write("# Type : "+tmp+"\n")
	
	tmp=''
	for cle in dico[i].keys() :
		tmp=tmp+"\t"+cle
	f.write("# Tags présents dans les fichiers : "+tmp+"\n")
	
	f.write("###################\n")
	
	## STATISTISQUES 
	f.write("# Statistiques et types\n")
	for tag in dico[i].keys() :
		#nom du tag
		f.write("# "+tag+" : \t")
		
		tmp=0
		for label in dico[i][tag].keys():
			TYPE=type(label)
			if TYPE==type('bla') and len(label)>tmp :
				tmp=len(label)
			
		#type de donnee
		f.write("type : "+str(TYPE))
		#longueur max
		if tmp!=0:
			f.write("\tlongueur de chaine max : "+str(tmp))
		f.write("\n")
	f.write("###################\n")
	
	## liste des valeurs prises ordonnées par ordre d'occurences
	for tag in dico[i].keys() :
		f.write("### TAG:"+tag+" :\n" )
		for label, nc in sorted(dico[i][tag].items(),key=lambda x:x[1],reverse=True):
			f.write(str(label)+" "+str(nc)+"\n")
			
	f.close()
	#fermeture du fichier de travail
