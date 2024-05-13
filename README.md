# APOC-AlHaIZ-Breizh
Projet de SAE 3 &amp; 4 IUT de Lannion

-------------------------------------------------------------------------

Règles pour nommer un commit :
Ajout : "US-000 ADD <nom_fichier>"
Maj : "US-000 UPD <nom_fichier>"
Suppression : "US-000 DEL <nom_fichier>"

Pour les push, il faut le faire en plusieurs commits en fonction de ce qui à été fait :
- Si on veut push un commit qui contient une suppression de fichier dans un dossier et une Maj d'un fichier dans un autre
- Il faut séparer le commit en deux :
  - Le premier "US-000 DEL <nom_fichier>" puis push
  - Le second "US-000 UPD <nom_fichier>" puis push

-------------------------------------------------------------------------

S'il y a des modifs à la BDD, il faut ajouter le(s) fichier(s) modifié(s) dans [Migrations](APOC-AlHaIZ-Breizh/Migrations) en le(s) renommant :
"jour-mois-année_<nom_fichier>"
