# APOC-AlHaIZ-Breizh
Projet de SAE 3 &amp; 4 IUT de Lannion

-------------------------------------------------------------------------

Commentaires

> [!NOTE]
> Tous les commentaires seront écrits en français.

-------------------------------------------------------------------------

Push & Commits

> [!CAUTION]
> Règles pour nommer un commit :
> ```
> Ajout :       "ADD <nom_fichier>"
> Mise à jour : "UPD <nom_fichier>"
> Suppression : "DEL <nom_fichier>"
> ```

Pour les push, il faut le faire en plusieurs commits en fonction de ce qui à été fait :
- Exemple : On veut push un commit qui contient une suppression dans un dossier et un ajout dans un autre
- On sépare le commit en deux :
  - Pour le premier : "DEL <nom_fichier>" puis push
  - Pour le second :  "ADD <nom_fichier>" puis push
  - 
-------------------------------------------------------------------------

Modifications BDD

S'il y a des modifs à la BDD, il faut ajouter le fichier modifié dans [Migrations](APOC-AlHaIZ-Breizh/Migrations) en le renommant :
```
"jour-mois-année_<nom_fichier>"
```
