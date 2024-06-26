// Pour les Sockets
#include <sys/types.h>
#include <sys/socket.h>
#include <netinet/in.h>
#include <arpa/inet.h>
// Bases 
#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <string.h>
// Système d'options
#include <getopt.h> 

int sock;
struct sockaddr_in server_addr;

int connexionSocket(const char *ip, int port) {
    // Création du socket
    sock = socket(AF_INET, SOCK_STREAM, 0);
    if (sock == -1) {
        perror("Échec de la création du socket");
        return -1;
    }

    server_addr.sin_family = AF_INET;
    server_addr.sin_port = htons(port);
    server_addr.sin_addr.s_addr = inet_addr(ip);

    if (connect(sock, (struct sockaddr *)&server_addr, sizeof(server_addr)) == -1) {
        perror("Échec de la connexion");
        close(sock);
        return -1;
    }

    return 0;
}

void deconnexion() {
    printf("Merci d'avoir utilisé l'API\n");
    close(sock); // Ferme la connexion avec le serveur
}

void sendMessage(const char *message) {
    if (send(sock, message, strlen(message), 0) == -1) {
        perror("Erreur lors de l'envoi du message");
        deconnexion();
        exit(EXIT_FAILURE);
    }
}

void receptionMessage(char *buffer, size_t size) {
    ssize_t bytes_lus = recv(sock, buffer, size - 1, 0);
    if (bytes_lus == -1) {
        perror("Erreur lors de la réception du message");
        deconnexion();
        exit(EXIT_FAILURE);
    }
    buffer[bytes_lus] = '\0';
}

void helper() {
    printf("Exemple: <nom_programme> -i <ip> -p <port>\n");
    printf("Options:\n");
    printf("  -i <ip>       Spécifie l'adresse IP du serveur\n");
    printf("  -p <port>     Spécifie le port du serveur\n");
    printf("  --help        Affiche ce message d'aide\n");
    printf("Une fois lancé il vous suffit de suivre ce que l'interface vous dira\n");
}

int main(int argc, char *argv[]) {
    char *ip = NULL;
    int port = 0;
    int opt;
    int option_index = 0;

    // Permet de prendre en considération une option longue --help
    struct option long_options[] = {
        {"help", no_argument, 0,  0 },
        {0, 0, 0, 0}
    };

    // Traitement des arguments avec getopt_long pour le --help
    while ((opt = getopt_long(argc, argv, "i:p:", long_options, &option_index)) != -1) {
        switch (opt) {
            case 0:
                if (strcmp(long_options[option_index].name, "help") == 0) {
                    helper();
                    return EXIT_SUCCESS;
                }
                break;
            case 'i':
                ip = optarg;
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

    if (ip == NULL || port == 0) {
        printf("Veuillez renseigner les paramètres nécessaires au fonctionnement du programme :\n");
        helper();
        return EXIT_FAILURE;
    }

    int attempts = 0;
    const int max_attempts = 3;

    while (attempts < max_attempts) {
        if (connexionSocket(ip, port) == 0) {
            break;
        }
        attempts++;
        if (attempts < max_attempts) {
            printf("Nouvelle tentative de connexion...\n");
        } else {
            printf("Échec de la connexion après %d tentatives. Fin du programme.\n", max_attempts);
            return EXIT_FAILURE;
        }
    }

    char buffer[16000];

    printf("  //$$$$$$                      /$$                                     /$$                       /$$\n"                        
" /$$__  $$                    | $$                                    |__/                      | $$\n"
"| $$  \\__/ /$$   /$$ /$$$$$$$ | $$   /$$  /$$$$$$   /$$$$$$  /$$$$$$$  /$$  /$$$$$$$  /$$$$$$  /$$$$$$    /$$$$$$   /$$$$$$\n"
"|  $$$$$$ | $$  | $$| $$__  $$| $$  /$$/ /$$__  $$ /$$__  $$| $$__  $$| $$ /$$_____/ |____  $$|_  $$_/   /$$__  $$ /$$__  $$\n"
" \\____  $$| $$  | $$| $$  \\ $$| $$$$$$/ | $$  \\__/| $$  \\ $$| $$  \\ $$| $$|  $$$$$$   /$$$$$$$  | $$    | $$  \\ $$| $$  \\__/\n"
" /$$  \\ $$| $$  | $$| $$  | $$| $$_  $$ | $$      | $$  | $$| $$  | $$| $$ \\____  $$ /$$__  $$  | $$ /$$| $$  | $$| $$\n"     
"|  $$$$$$/|  $$$$$$$| $$  | $$| $$ \\  $$| $$      |  $$$$$$/| $$  | $$| $$ /$$$$$$$/|  $$$$$$$  |  $$$$/|  $$$$$$/| $$\n"     
" \\______/  \\____  $$|__/  |__/|__/  \\__/|__/       \\______/ |__/  |__/|__/|_______/  \\_______/   \\___/   \\______/ |__/\n"      
"           /$$  | $$\n"                                                                                                       
"          |  $$$$$$/\n"                                                                                                        
"           \\______/\n");
    sleep(1);

    // Envoi de la clé API
    do {
        printf("Veuillez renseigner votre clé API S'il vous plaît :\n");
        char cle[256];
        scanf("%255s", cle); // Utilisation de %255s pour éviter un dépassement de tampon
        sendMessage(cle);

        // Lecture de la réponse du serveur pour obtenir l'état de connexion et le rôle
        receptionMessage(buffer, sizeof(buffer));
        printf("%s\n", buffer);
    } while (strcmp(buffer, "Clé incorrecte. Merci d'essayer à nouveau.") ==0);



    // Traitement de la réponse pour extraire le rôle
    char *token = strtok(buffer, "/");
    if (token == NULL) {
        fprintf(stderr, "Erreur : réponse du serveur inattendue.\n");
        deconnexion();
        return EXIT_FAILURE;
    }

    token = strtok(NULL, "/");
    if (token == NULL) {
        fprintf(stderr, "Erreur : réponse du serveur inattendue.\n");
        deconnexion();
        return EXIT_FAILURE;
    }

    char role[256];
    strcpy(role, token);

    // Boucle de traitement des opérations
    while (1) {
        if (strcmp(role, "Admin") == 0) {
            printf("\nQue souhaitez-vous faire ?\n");
            printf("1) Afficher la liste des logements\n");
            printf("0) Quitter l'API\n");

        } else {
            printf("\nQue souhaitez-vous faire ?\n");
            printf("1) Afficher la liste de vos logements\n");
            printf("2) Afficher les disponibilités de vos logements\n");
            printf("0) Quitter l'API\n");

        }


        char choix[10];
        scanf("%9s", choix);
        sendMessage(choix);

        if (strcmp(choix, "0") == 0) {
            deconnexion();
            break;
        } else if (strcmp(choix, "1") == 0) {
            receptionMessage(buffer, sizeof(buffer));
            printf("Liste des logements :\n%s\n", buffer);
        } else if (strcmp(choix, "2") == 0) {
            receptionMessage(buffer, sizeof(buffer));
            printf("Choisissez le logement dont vous souhaitez connaître les disponibilités :\n%s\n", buffer);

            char choix_logement[10];
            scanf("%9s", choix_logement);
            sendMessage(choix_logement);

            printf("Veuillez entrer la date de début de votre période (format YYYY-MM-DD) :\n");
            char dateDeb[11];
            scanf("%10s", dateDeb); // Utilisation de %10s pour éviter un dépassement de tampon
            sendMessage(dateDeb);

            printf("Veuillez entrer la date de fin de votre période (format YYYY-MM-DD) :\n");
            char dateFin[11];
            scanf("%10s", dateFin); // Utilisation de %10s pour éviter un dépassement de tampon
            sendMessage(dateFin);

            receptionMessage(buffer, sizeof(buffer));
            printf("Disponibilités du logement :\n%s\n", buffer);
        }

        sleep(2);
        printf("\n\n");
    }

    return EXIT_SUCCESS;
}
