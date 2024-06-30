# APOC-AlHaIZ-Breizh
Projet de SAE 3 et 4 IUT de Lannion

## Architecture du projet
Le projet est organisée sous le principe de Model-View-Controller (MVC) voici l'architecture du projet expliquée : 
```
html
|_ assets
    |_ imgs : images / icones utilisés dans le projet
    |_ JS : 
        |_ Front : Fichiers Javascript du Front-Office du projet 
        |_ Back : Fichiers Javascript du Back-Office du projet 
        |_ *.js : fichiers js communs et utilisés dans les codes / pages js du Front et du Back office 
    |_ SCSS : 
        |_ Front : Fichiers .scss et .css du Front-Office du projet 
        |_ Back : Fichiers .scss et .css du Back-Office du projet 
        |_ *.scss : fichiers scss communs et utilisés dans les codes / pages scss du Front et du Back office 
|_ Controllers:  Fonctions appelées par le routeur qui doient utiliser les Services / Models pour traiter / récupérer des données,puis rediriger vers d'autres pages
|_ icalfiles :Dossier où se trouvent les fichiers ics générés par l'application par l'outil Icalator
|_ Models
    |_ les fichiers de models contiennent les fonctions qui permettent de faire des requetes sur la BDD
|_ Service
    |_ Fichiers où sont stockés des fonctions / objets qui peuvent potentiellement être utiles à différents endroits de l'application
|_ Views
    |_ Front : Fichiers de vue (code html dans fichiers .php) de l'application
    |_ Back : Fichiers de vue (code html dans fichiers .php) de l'application
    |_ *.php : fichier de vue qui sont communs au Front et au Back office
|_ index.php : Routeur
```

## Routeur
Le site utilise un routeur (code qui est présent dans le index.php). 
Toutes les url qui appelent le site sont redirigées vers le index.php, si l'url n'est pas connue par ce fichier, une erreur 404 est renvoyée.  

## Liaison automatique du css/js
Le composant php 'header.php', sert en partie (pour le back et le front) à lier le fichier .php de vue à des fichiers css et js du moment qu'ils portent le même nom que lui, ainsi si un fichier de vue s'appelle 'maVue.php', si des fichiers css et js appelés 'maVue.css' et 'maVue.js' existent, ils seront liés au fichier php, si celui-ci inclue le head.php

## Données affichés en JS
Le site utilise beaucoup le JS avec des appels ajax pour afficher les données qui doient être récupérées en BDD. 
Les fichiers de vue servent principalement à afficher les données statiques de la page. L'affichage des données calculées ou requétées est géré en js. 
Les requetes ajax utilisent elles aussi le routeur, ce dernier contient tout un bloc concernant les 'routes api' qui servent à faire des requetes en BDD et à renvoyer des données au format json. 

## Installation du projet
Pour installer le projet, créer un dossier 'Config.php' dans le dossier Service, et le remplir ainsi : 

```
<?php
    define("DB_DSN","pgsql:host={votre host};dbname={nom de database};port={votre port}");
    define("DB_USERNAME","{utilisateur de votre bdd}");
    define("DB_PASSWORD","{password de votre bdd}");
?>
```

Il faut également compiler les fichiers .sass en .css dans les même répertoires que les fichiers .sass. 
