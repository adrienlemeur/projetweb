# projetweb

## Implémentation et chargement des données


* Récuperer les fichiers et préparer le site
```
#dans var/www/html :
git clone https://github.com/adrienlemeur/projetweb
```

* Creation et remplissage de la DB
```
sudo -i -u postrgres

#creer une nouvelle base de données :
createdb projetweb

#connexion à la base de données:
psql -d projetweb

#creation de la BD:
\i databaseCreation.sql;

```
## Accéder au site
Afin de tester la robustesse du site, pouvez utiliser les différents utilisateurs pré-rentrés dans la base de donnée :
* utilisateur@u-psud.fr
* annotateur@u-psud.fr
* validateur@u-psud.fr
* administrateur@u-psud.fr
- Les mots de passe sont identiques : jambondeparme

Le site a été optimisé pour un affichage avec Chromium et Chrome. Il présente quelques irrégularités sur Firefox.

## Contribution
1. Adrien LE MEUR
* UML et relationnel
* global_style.css
* inscription.php
* main_utilisateur.php
* page_de_garde.php
* espace_administrateur.php
* tous les fichiers du dossier functions
* correction majeures et mise en forme du code de tous les fichiers php

2. Ombeline LAMER
* UML et relationnel (see at: https://lucid.app/invitations/accept/15776db4-76a9-4431-ba44-1af80971d515)
* databaseCreation.sql
* annotation.py (and output files : Annotation-ADN.txt Annotation-CDS.txt Annotation-pep.txt)
* formattage.py (and output files: genome.csv, cds.csv, pep.csv)
* tous les fichiers du dossier DB.
* espace_annotateur.php
* espace_validateur.php
* correction et test des fichiers de cette liste
* README.md

## Licence

Permission is hereby granted, free of charge, to any person obtaining a copy
of this project to deal without restriction, including without limitation the
rights to use, copy, modify, merge, publish, distribute copies of the project
with the only restriction of being free-to-use if not modified.
