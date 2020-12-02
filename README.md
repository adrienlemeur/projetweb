# projetweb

## Installation
Please clone this folder onto your computer and follow the instructions below.

* Preparer le projet pour la navigation du site web
```
#inside the clone repository, launch terminal then run :

#require apache !
```

* Creation et remplissage de la DB depuis un terminal
```
sudo -i -u postrgres pqsl #devrait voir : postgres=#

#changer les 3 chemins dans le fichier databaseCreation.sql
\i /home/ombeline/Documents/ProjetWeb/projetweb/DB/databaseCreation.sql #changer chemin
#Et voilà : les data sont chargées ! Les requetes peuvent commencer...

```
## Package and File Description


## Contribution
1. Adrien LE MEUR
* UML
* inscription.php & css
* main_utilisateur.php
* page_de_garde.php & css


2. Ombeline LAMER
* UML and RELATIONNEL (see at: https://lucid.app/invitations/accept/15776db4-76a9-4431-ba44-1af80971d515)
* databaseCreation.sql
* annotation.py (and output files : Annotation-ADN.txt Annotation-CDS.txt Annotation-pep.txt)
* formattage.py (and output files: genome.csv, cds.csv, pep.csv)
* README.md

## Licence
Permission is hereby granted, free of charge, to any person obtaining a copy
of this project to deal without restriction, including without limitation the
rights to use, copy, modify, merge, publish, distribute copies of the project
with the only restriction of being free-to-use if not modified.
