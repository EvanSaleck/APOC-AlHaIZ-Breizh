# APOC-AlHaIZ-Breizh
Projet de SAE 3 &amp; 4 IUT de Lannion

-------------------------------------------------------------------------

Commentaires

> [!NOTE]
> Tous les commentaires seront écrits en français.

-------------------------------------------------------------------------

Commandes GIT

Setup :
- Pour récupérer les fichiers du repository, se positionner dans son dossier de travail puis faire : 
  ```
  git clone https://github.com/EvanSaleck/APOC-AlHaIZ-Breizh.git
  ```

- Installer les extension suivantes sous VSC :
  ```
  Live Server (Five Server)
  Live Sass Compiler
  Sass (.sass only)
  ```

- Pour créer une branche :
  ```
  git checkout -b <nom_branche>
  ```

- Pour se déplacer :
  ```
  git checkout <nom_branche_destination>
  ```
  
-------------------------------------------------------------------------

Procédure de pull / push :
- Avant toute action, faire la commande suivante pour récupérer les fichiers à jour :
  ```
  git pull
  ```

> [!CAUTION]
> En case de conflit de fichier (proposition de merge), en discuter avec les autres membres puis merge


- Pour commit :
  - Pour ajouter les fichier :
    ```
    git add .
    ```

  - Pour commit les fichiers à ajouter :
    ```
    git commit -m "Message qui explique le but du commit"
    ```

> [!CAUTION]
> Règles pour nommer un commit :
> ```
> Ajout :       "ADD <nom_fichier>"
> Mise à jour : "UPD <nom_fichier>"
> Suppression : "DEL <nom_fichier>"
> ```

- Pour pusher, il est nécessaire de le faire avec plusieurs commits différent, en fonction de ce qui à été fait :
- Exemple : On veut push un commit qui contient une suppression dans un dossier et un ajout dans un autre
- On sépare le commit en deux :
  - Pour le premier : "DEL <nom_fichier>" puis push
  - Pour le second :  "ADD <nom_fichier>" puis push
  ```
  git push <nom_branche>
  ```

> [!CAUTION]
> Il ne faut JAMAIS push su la branche main, sauf si tout le monde s'est concerté

-------------------------------------------------------------------------

Modifications BDD

S'il y a des modifs à la BDD, il faut ajouter le fichier modifié dans [Migrations](APOC-AlHaIZ-Breizh/Migrations) en le renommant :
```
"jour-mois-année_<nom_fichier>"
```
