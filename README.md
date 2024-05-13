# APOC-AlHaIZ-Breizh
Projet de SAE 3 &amp; 4 IUT de Lannion
-------------------------------------------------------------------------
Push & Commits

> [!CAUTION]
> Règles pour nommer un commit :
> ```
> Ajout :       "US-000 ADD <nom_fichier>"
> Mise à jour : "US-000 UPD <nom_fichier>"
> Suppression : "US-000 DEL <nom_fichier>"
> ```

Pour les push, il faut le faire en plusieurs commits en fonction de ce qui à été fait :
- Exemple : On veut push un commit qui contient une suppression dans un dossier et un ajout dans un autre
- On sépare le commit en deux :
  - Pour le premier : "US-000 DEL <nom_fichier>" puis push
  - Pour le second :  "US-000 ADD <nom_fichier>" puis push
-------------------------------------------------------------------------
Modifications BDD

S'il y a des modifs à la BDD, il faut ajouter les fichiers modifiés dans [Migrations](APOC-AlHaIZ-Breizh/Migrations) en les renommant :
```
"jour-mois-année_<nom_fichier>"
```
