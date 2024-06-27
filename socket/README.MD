# Librairies Externes
- Côté serveur : 
	- **Cjson** - *Permet de mettre en place des réponses au format JSON* - Documentation : **https://github.com/DaveGamble/cJSON**
	- **LibPQ-fe** - *Librairie permettant les requêtes SQL* - Commande **sudo apt install libpq-dev**
- Côté client:
	- Aucune librairie n'est nécessaire.

# Execution des services
## Compilation
### Client 
Il vous suffit de faire la commande **gcc** : **gcc client.c -o client**


### Serveur 
Il vous suffit de faire la commande **gcc** : **gcc ./server.c -o server -lpq -lcjson** 
*NB : les tirets permettent de définir que vous utilisez des librairies externes*

## Execution
### Client
Il vous suffit d'executer la commande : **./serveur -d < nom du conteneur docker avec la base de données > -p < port du serveur >**

### Serveur 
Il vous suffit d'executer la commande :  **./client -i < ip de votre serveur > -p < port du serveur >**

## Note 

Si vous rencontrez des problèmes lors de son utilisation  une option --help est disponible pour ces deux commandes.
