#define _XOPEN_SOURCE
// Gestion du Socket
#include <sys/types.h>
#include <sys/socket.h>
#include <netinet/in.h>
// Gestion de la BDD
#include <postgresql/libpq-fe.h>
// Bases
#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <string.h>
#include <stdbool.h>
#include <time.h>
// Gestion du JSON 
#include <cjson/cJSON.h>
// Permet la gestion des options notamment --help 
#include <getopt.h>

// Clé admin 
const char ADMINKEY[] = "3086da87fe06e2b024cd8e294616cfc4019e57f6212ecd48a3321c738bb7aa75";

// Définition des variables
int sock;
int ret;
int size;
int cnx;
int max_attempts = 3;
PGconn *connection;
struct sockaddr_in conn_addr;
struct sockaddr_in addr;

// Structure du token pour la simplicité du stockage
struct token {
    int id_proprio;
    char cle[256];
};

bool connexionCle(const char *cle, struct token *t) {
    bool valid = false;
    char sql[256];
    char token[256];

    // Copier la clé dans le token
    strncpy(token, cle, sizeof(token) - 1);
    token[sizeof(token) - 1] = '\0'; // Assurer la terminaison nulle

    // Retirer les caractères de contrôle (comme '\n' et '\r') s'ils existent
    token[strcspn(token, "\r\n")] = '\0';

    if (strcmp(token, ADMINKEY) == 0){
        valid = true;
        t->id_proprio = 0;
        strncpy(t->cle, token, sizeof(t->cle) - 1);
        t->cle[sizeof(t->cle) - 1] = '\0';
        return valid;
    }

    snprintf(sql, sizeof(sql), "SELECT c_id_proprio FROM sae3.cle_api WHERE cle = '%s'", token);

    PGresult *resultat = PQexec(connection, sql);
    if (PQresultStatus(resultat) != PGRES_TUPLES_OK) {
        fprintf(stderr, "Erreur de requête SQL : %s\n", PQerrorMessage(connection));
        PQclear(resultat);
        return valid;
    }

    if (PQntuples(resultat) > 0) {
        const char *id_proprio_str = PQgetvalue(resultat, 0, 0);
        if (id_proprio_str != NULL) {
            t->id_proprio = atoi(id_proprio_str);
            strncpy(t->cle, token, sizeof(t->cle) - 1);
            t->cle[sizeof(t->cle) - 1] = '\0';
            valid = true;
        } 
    }

    PQclear(resultat);
    return valid;
}

bool isValidDate(const char *date) {
    struct tm tm;
    memset(&tm, 0, sizeof(struct tm));
    char *result = strptime(date, "%Y-%m-%d", &tm);
    return result != NULL && *result == '\0';
}

void sendReponse(PGresult *data) {
    cJSON *json = cJSON_CreateArray();
    int nblignes = PQntuples(data);
    int nbchamps = PQnfields(data);

    for (int i = 0; i < nblignes; i++) {
        cJSON *row = cJSON_CreateObject();
        for (int j = 0; j < nbchamps; j++) {
            char *nomchamp = PQfname(data, j);
            char *valchamp = PQgetvalue(data, i, j);
            cJSON_AddStringToObject(row, nomchamp, valchamp);
        }
        cJSON_AddItemToArray(json, row);
    }
    
    char *json_string = cJSON_Print(json);
    write(cnx, json_string, strlen(json_string));
    free(json_string);
    cJSON_Delete(json);
}


void helper() {
    printf("Exemple: <nom_programme> -d <conteneur> -p <port>\n");
    printf("Options:\n");
    printf("  -d <ip>       Spécifie le conteneur docker de votre base de donnée\n");
    printf("  -p <port>     Spécifie le port du serveur\n");
    printf("  --help        Affiche ce message d'aide\n");
    printf("Une fois lancé il vous suffit de laisser le processus tourner ainsi tout le monde pourra effectuer des requêtes\n");
}


void showDisponibiliteByLogement(struct token *t) {
    char buffer[1024];
    int bytes_read;

    // Requête pour récupérer les logements du propriétaire
    char sql[1024];
    snprintf(sql, sizeof(sql), "SELECT id_logement, titre FROM sae3.logement WHERE l_id_compte = %d", t->id_proprio);

    PGresult *resultat = PQexec(connection, sql);
    if (PQresultStatus(resultat) != PGRES_TUPLES_OK) {
        fprintf(stderr, "Erreur de requête SQL : %s\n", PQerrorMessage(connection));
        PQclear(resultat);
        return;
    }

    int nblignes = PQntuples(resultat);
    if (nblignes == 0) {
        write(cnx, "Aucun logement trouvé pour ce propriétaire.\n", 45);
        PQclear(resultat);
        return;
    }

    // Envoyer la liste des logements à l'utilisateur
    snprintf(buffer, sizeof(buffer), "%d\n", nblignes);
    write(cnx, buffer, strlen(buffer));
    for (int i = 0; i < nblignes; i++) {
        snprintf(buffer, sizeof(buffer), "%d) %s\n", i + 1, PQgetvalue(resultat, i, 1));
        write(cnx, buffer, strlen(buffer));
    }

    // Lire le choix de l'utilisateur
    bytes_read = read(cnx, buffer, sizeof(buffer) - 1);
    if (bytes_read <= 0) {
        write(cnx, "Erreur de lecture. Veuillez réessayer.\n", 40);
        PQclear(resultat);
        return;
    }
    buffer[bytes_read] = '\0';
    buffer[strcspn(buffer, "\r\n")] = '\0';
    int choix_logement = atoi(buffer);
    if (choix_logement < 1 || choix_logement > nblignes) {
        write(cnx, "Choix invalide. Veuillez réessayer.\n", 37);
        PQclear(resultat);
        return;
    }

    // Obtenir l'ID du logement choisi
    char *id_logement = PQgetvalue(resultat, choix_logement - 1, 0);
    PQclear(resultat);

    // Lire la date de début
    bytes_read = read(cnx, buffer, sizeof(buffer) - 1);
    if (bytes_read <= 0) {
        write(cnx, "Erreur de lecture. Veuillez réessayer.\n", 40);
        return;
    }
    buffer[bytes_read] = '\0';
    buffer[strcspn(buffer, "\r\n")] = '\0';
    char dateDeb[11];
    strncpy(dateDeb, buffer, sizeof(dateDeb) - 1);
    dateDeb[sizeof(dateDeb) - 1] = '\0';

    // Valider la date de début
    if (!isValidDate(dateDeb)) {
        write(cnx, "Date de début invalide. Veuillez réessayer.\n", 43);
        return;
    }

    // Lire la date de fin
    bytes_read = read(cnx, buffer, sizeof(buffer) - 1);
    if (bytes_read <= 0) {
        write(cnx, "Erreur de lecture. Veuillez réessayer.\n", 40);
        return;
    }
    buffer[bytes_read] = '\0';
    buffer[strcspn(buffer, "\r\n")] = '\0';
    char dateFin[11];
    strncpy(dateFin, buffer, sizeof(dateFin) - 1);
    dateFin[sizeof(dateFin) - 1] = '\0';

    // Valider la date de fin
    if (!isValidDate(dateFin)) {
        write(cnx, "Date de fin invalide. Veuillez réessayer.\n", 39);
        return;
    }

    // Requête pour récupérer les réservations qui chevauchent la période spécifiée
    char sql2[1024];
    snprintf(sql2, sizeof(sql2), "SELECT date_arrivee, date_depart FROM sae3.reservation WHERE R_id_logement = %s AND NOT (date_depart <= '%s' OR date_arrivee >= '%s') ORDER BY date_arrivee", id_logement, dateDeb, dateFin);

    PGresult *resultat2 = PQexec(connection, sql2);
    if (PQresultStatus(resultat2) != PGRES_TUPLES_OK) {
        fprintf(stderr, "Erreur de requête SQL : %s\n", PQerrorMessage(connection));
        write(cnx, "Erreur, veuillez réessayer.\n", 28);
        PQclear(resultat2);
        return;
    }

    // Créer un tableau JSON pour les plages de disponibilité
    cJSON *dispo = cJSON_CreateArray();

    int nbReservations = PQntuples(resultat2);
    if (nbReservations == 0) {
        // Si aucune réservation ne chevauche la période spécifiée, le logement est entièrement disponible
        cJSON *plage = cJSON_CreateObject();
        cJSON_AddStringToObject(plage, "debut_dispo", dateDeb);
        cJSON_AddStringToObject(plage, "fin_dispo", dateFin);
        cJSON_AddItemToArray(dispo, plage);
    } else {
        // Si des réservations chevauchent la période spécifiée, calculer les plages de disponibilité

        // Vérifier la disponibilité avant la première réservation
        char *date_arrivee = PQgetvalue(resultat2, 0, 0);
        if (strcmp(dateDeb, date_arrivee) < 0) {
            cJSON *plage = cJSON_CreateObject();
            cJSON_AddStringToObject(plage, "debut_dispo", dateDeb);
            cJSON_AddStringToObject(plage, "fin_dispo", date_arrivee);
            cJSON_AddItemToArray(dispo, plage);
        }

        // Vérifier la disponibilité entre les réservations
        for (int i = 0; i < nbReservations - 1; i++) {
            char *date_depart = PQgetvalue(resultat2, i, 1);
            char *prochaine_date_arrivee = PQgetvalue(resultat2, i + 1, 0);
            if (strcmp(date_depart, prochaine_date_arrivee) < 0) {
                cJSON *plage = cJSON_CreateObject();
                cJSON_AddStringToObject(plage, "debut_dispo", date_depart);
                cJSON_AddStringToObject(plage, "fin_dispo", prochaine_date_arrivee);
                cJSON_AddItemToArray(dispo, plage);
            }
        }

        // Vérifier la disponibilité après la dernière réservation
        char *derniere_date_depart = PQgetvalue(resultat2, nbReservations - 1, 1);
        if (strcmp(derniere_date_depart, dateFin) < 0) {
            cJSON *plage = cJSON_CreateObject();
            cJSON_AddStringToObject(plage, "debut_dispo", derniere_date_depart);
            cJSON_AddStringToObject(plage, "fin_dispo", dateFin);
            cJSON_AddItemToArray(dispo, plage);
        }
    }

    // Convertir le tableau JSON en chaîne et l'envoyer à l'utilisateur
    char *json_str = cJSON_Print(dispo);
    write(cnx, json_str, strlen(json_str));
    free(json_str);
    cJSON_Delete(dispo);

    PQclear(resultat2);
}


void showAllLogements() {
    char sql[256];
    snprintf(sql, sizeof(sql), "SELECT * FROM sae3.logement");

    PGresult *resultat = PQexec(connection, sql);
    if (PQresultStatus(resultat) != PGRES_TUPLES_OK) {
        fprintf(stderr, "Erreur de requête SQL : %s\n", PQerrorMessage(connection));
        write(cnx, "Erreur, Veuillez réessayer", 28);
        PQclear(resultat);
    } else {
        sendReponse(resultat);
    }
    PQclear(resultat);
}

void showLogementByProprio(struct token *t) {
    char sql[256];
    snprintf(sql, sizeof(sql), "SELECT * FROM sae3.logement WHERE l_id_compte = '%d'", t->id_proprio);

    PGresult *resultat = PQexec(connection, sql);
    if (PQresultStatus(resultat) != PGRES_TUPLES_OK) {
        fprintf(stderr, "Erreur de requête SQL : %s\n", PQerrorMessage(connection));
        write(cnx, "Erreur, Veuillez réessayer", 28);
        PQclear(resultat);
    } else {
        sendReponse(resultat);
    }
    PQclear(resultat);
}

void handleClientConnection(int client_sock) {
    struct token t;
    cnx = client_sock;

    char buffer[1024];
    bool validite = false;
    int attempts = 0;

    while (attempts < max_attempts && !validite) {
        int bytes_read = read(cnx, buffer, sizeof(buffer) - 1);
        if (bytes_read == -1) {
            perror("Échec de la lecture");
            close(cnx);
            return;
        }
        buffer[bytes_read] = '\0'; // Ajoute un caractère de fin de ligne à la chaîne lue
        validite = connexionCle(buffer, &t);
        if (!validite) {
            write(cnx, "Clé incorrecte. Merci d'essayer à nouveau.\n", 44);
            attempts++;
        }
    }

    if (validite) {
        if(strcmp(t.cle, ADMINKEY) == 0){
            write(cnx, "1/Admin", 8);
        } else {
            write(cnx, "1/User", 7);
        }


        while (1) {
            if (strcmp(t.cle, ADMINKEY) == 0) {

                write(cnx, "Que souhaitez-vous faire ?\n1) Afficher tout les logements sur le site \n\n0) Quitter l'API", 89);

                int bytes_read = read(cnx, buffer, sizeof(buffer) - 1);
                if (bytes_read == -1) {
                    perror("Échec de la lecture");
                    break;
                }

                buffer[bytes_read] = '\0';
                buffer[strcspn(buffer, "\r\n")] = '\0';

                int choix = atoi(buffer);

                switch (choix) {
                case 0:
                    // deconnexion();
                    close(cnx);
                    return;
                case 1:
                    showAllLogements();
                    break;
                default:
                    write(cnx, "Vous n'avez pas tapé de bonne commande", 40);
                    break;
                }
            } else {
                int bytes_read = read(cnx, buffer, sizeof(buffer) - 1);
                if (bytes_read == -1) {
                    perror("Échec de la lecture");
                    break;
                }

                buffer[bytes_read] = '\0';
                buffer[strcspn(buffer, "\r\n")] = '\0';

                int choix = atoi(buffer);
                switch (choix) {
                case 1:
                    showLogementByProprio(&t);
                    break;
                case 2:
                    showDisponibiliteByLogement(&t);
                    break;
                default:
                    write(cnx, "Vous n'avez pas tapé de bonne commande", 40);
                    break;
                }
            }
        }
    } else {
        write(cnx, "Clé incorrecte. Nombre maximum de tentatives atteint.\n", 54);
        close(cnx);
    }
    close(cnx);
}

int main(int argc, char **argv) {
    char *nomdb = NULL;
    int port = 0;
    int opt;
    int option_index = 0;

        // Permet de prendre en considération une option longue --help
    struct option long_options[] = {
        {"help", no_argument, 0,  0 },
        {0, 0, 0, 0}
    };

    // Traitement des arguments avec getopt_long pour le --help
    while ((opt = getopt_long(argc, argv, "d:p:", long_options, &option_index)) != -1) {
        switch (opt) {
            case 0:
                if (strcmp(long_options[option_index].name, "help") == 0) {
                    helper();
                    return EXIT_SUCCESS;
                }
                break;
            case 'd':
                nomdb = optarg;
                break;
            case 'p':
                port = atoi(optarg);
                break;
            case '--help':
                helper();
                break;
            default:
                helper();
                return EXIT_FAILURE;
        }
    }

    if (nomdb == NULL || port == 0) {
        printf("Veuillez renseigner les paramètres nécessaires au fonctionnement du programme :\n");
        helper();
        return EXIT_FAILURE;
    }

    char cmd[256];
    snprintf(cmd, sizeof(cmd), "docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' %s", nomdb);

    FILE *fp = popen(cmd, "r");
    if (!fp) {
        perror("Erreur lors de l'exécution de docker inspect");
        return EXIT_FAILURE;
    }

    char ipdb[100];
    if (fgets(ipdb, sizeof(ipdb), fp) == NULL) {
        perror("Erreur lors de la lecture de l'adresse IP du conteneur");
        pclose(fp);
        return EXIT_FAILURE;
    }
    pclose(fp);

    char conninfo[256];
    snprintf(conninfo, sizeof(conninfo), "hostaddr=%s port=5432 dbname=apoc user=sae password=4ABWKV8wcd4qmgBQGiTb connect_timeout=10", ipdb);

    // Connexion à PostgreSQL
    connection = PQconnectdb(conninfo);
    if (PQstatus(connection) == CONNECTION_BAD) {
        fprintf(stderr, "Connexion à la base de données échouée : %s\n", PQerrorMessage(connection));
        PQfinish(connection);
        return EXIT_FAILURE;
    }

    // Création du socket
    sock = socket(AF_INET, SOCK_STREAM, 0);
    if (sock == -1) {
        perror("Échec de la création du socket");
        return EXIT_FAILURE;
    }

    addr.sin_family = AF_INET;
    addr.sin_port = htons(port);
    addr.sin_addr.s_addr = INADDR_ANY;

    // Liaison du socket à l'adresse
    ret = bind(sock, (struct sockaddr *)&addr, sizeof(addr));
    if (ret == -1) {
        perror("Échec de la liaison");
        close(sock);
        return EXIT_FAILURE;
    }

    // Écoute des connexions
    ret = listen(sock, 1);
    if (ret == -1) {
        perror("Échec de l'écoute");
        close(sock);
        return EXIT_FAILURE;
    }

    printf("Écoute sur le port %d\n", port);

    while (1) {
        size = sizeof(conn_addr);
        cnx = accept(sock, (struct sockaddr *)&conn_addr, (socklen_t *)&size);
        if (cnx == -1) {
            perror("Échec de l'acceptation");
            continue;
        }

        pid_t pid = fork();
        if (pid < 0) {
            perror("Erreur lors du fork");
            close(cnx);
            continue;
        }

        if (pid == 0) {  
            close(sock);  
            handleClientConnection(cnx);
            exit(EXIT_SUCCESS);
        } else {  
            close(cnx);  
        }
    }

    close(sock);
    PQfinish(connection);
    return EXIT_SUCCESS;
}
