INSERT INTO type_logement(nom_type) 
VALUES ('Studio');
INSERT INTO type_logement(nom_type) 
VALUES ('T1');
INSERT INTO type_logement(nom_type) 
VALUES ('T2');
INSERT INTO type_logement(nom_type) 
VALUES ('T3');
INSERT INTO type_logement(nom_type) 
VALUES ('T4');
INSERT INTO type_logement(nom_type) 
VALUES ('T5 et plus');
INSERT INTO type_logement(nom_type) 
VALUES ('F1');
INSERT INTO type_logement(nom_type) 
VALUES ('F2');
INSERT INTO type_logement(nom_type) 
VALUES ('F3');
INSERT INTO type_logement(nom_type) 
VALUES ('F4');
INSERT INTO type_logement(nom_type) 
VALUES ('F5 et plus');

INSERT INTO categorie_logement(nom_categorie)
VALUES ('appartement');
INSERT INTO categorie_logement(nom_categorie)
VALUES ('maison');
INSERT INTO categorie_logement(nom_categorie)
VALUES ('villa exception');
INSERT INTO categorie_logement(nom_categorie)
VALUES ('chalet');
INSERT INTO categorie_logement(nom_categorie)
VALUES ('bateau');
INSERT INTO categorie_logement(nom_categorie)
VALUES ('logement insolite');


INSERT INTO amenagement(nom_amenagement)
VALUES ('jardin');
INSERT INTO amenagement(nom_amenagement)
VALUES ('balcon');
INSERT INTO amenagement(nom_amenagement)
VALUES ('terrasse');
INSERT INTO amenagement(nom_amenagement)
VALUES ('piscine');
INSERT INTO amenagement(nom_amenagement)
VALUES ('jacuzzi');

INSERT INTO activite(nom_activite)
VALUES ('baignade');
INSERT INTO activite(nom_activite)
VALUES ('voile');
INSERT INTO activite(nom_activite)
VALUES ('canoë');
INSERT INTO activite(nom_activite)
VALUES ('golf');
INSERT INTO activite(nom_activite)
VALUES ('équitation');
INSERT INTO activite(nom_activite)
VALUES ('accrobranche');
INSERT INTO activite(nom_activite)
VALUES ('randonnée');


INSERT INTO adresse (numero_rue, nom_rue, code_postal, nom_ville, pays) 
VALUES 
 (12, 'rue de Blancbois', 22300, 'Lannion', 'France');
INSERT INTO adresse (numero_rue, nom_rue, code_postal, nom_ville, pays) 
VALUES 
 (17, 'rue du Pont', 22300, 'Lannion', 'France');
INSERT INTO adresse (numero_rue, nom_rue, code_postal, nom_ville, pays, complement) 
VALUES 
 (21, 'rue de Villeneuve', 22300, 'Lannion', 'France', 'Etage 3');
INSERT INTO adresse (numero_rue, nom_rue, code_postal, nom_ville, pays) 
VALUES 
 (7, 'avenue Charles de Gaulle', 22300, 'Lannion', 'France');
INSERT INTO adresse (numero_rue, nom_rue, code_postal, nom_ville, pays, complement) 
VALUES 
 (1, 'rue Victor Hugo', 29200, 'Brest', 'France', 'bis');
INSERT INTO adresse (numero_rue, nom_rue, code_postal, nom_ville, pays) 
VALUES 
 (5, 'rue des tournesols', 29200, 'Brest', 'France');
INSERT INTO adresse (numero_rue, nom_rue, code_postal, nom_ville, pays, complement) 
VALUES 
 (14, 'rue des ajoncs', 29800, 'Landerneau', 'France', 'Batiment G');
INSERT INTO adresse (numero_rue, nom_rue, code_postal, nom_ville, pays) 
VALUES 
 (11, 'rue des bleuets', 29600, 'Morlaix', 'France');
INSERT INTO adresse (numero_rue, nom_rue, code_postal, nom_ville, pays) 
VALUES 
 (17, 'rue de la marne', 50170, 'Mont Saint Michel', 'France');
INSERT INTO adresse (numero_rue, nom_rue, code_postal, nom_ville, pays, etat) 
VALUES 
 (05, 'Columbia Street', 20001, 'Washington DC', 'USA', 'Columbia');
INSERT INTO adresse (numero_rue, nom_rue, code_postal, nom_ville, pays) 
VALUES 
 (13, 'rue du kernic', 29430, 'Plouescat', 'France');



INSERT INTO langue(nom_langue)
VALUES ('Français');
INSERT INTO langue(nom_langue)
VALUES ('Brésilien');
INSERT INTO langue(nom_langue)
VALUES ('Breton');
INSERT INTO langue(nom_langue)
VALUES ('Espagnol');
INSERT INTO langue(nom_langue)
VALUES ('Allemand');


INSERT INTO compte_client(civilite, nom, prenom, e_mail, mdp, pseudo, photo_profil, ddn, c_id_adresse, code_client, cc_id_adresse)
VALUES ('Mr', 'Neymar', 'Jean', 'Jean.Neymar@gmail.com', 'jeje92NEY', 'Jejean','/assets/imgs/Profils/jean_neymar.png', '10/08/1992', '1', 'NEYJEAN01', 1);
INSERT INTO compte_client(civilite, nom, prenom, e_mail, mdp, pseudo, photo_profil, ddn, c_id_adresse, code_client, cc_id_adresse)
VALUES ('Mme', 'Waxson', 'Emmi', 'emmmi.waxson@outlook.com', 'Wemmimi19', 'Wemimi', '/assets/imgs/Profils/emmi_waxson.png', '15/04/1990', '2', 'WAXEMMI02', 2);
INSERT INTO compte_client(civilite, nom, prenom, e_mail, mdp, pseudo, photo_profil, ddn, c_id_adresse, code_client, cc_id_adresse)
VALUES ('Mr', 'Daip', 'Jauni', 'Daip.Jauni@wanadoo.com', 'jaujau12', 'JauniPaid','/assets/imgs/Profils/jauni_daip.png', '09/06/1963', '3', 'DAIJAUNI03', 3);
INSERT INTO compte_client(civilite, nom, prenom, e_mail, mdp, pseudo, photo_profil, ddn, c_id_adresse, code_client, cc_id_adresse)
VALUES ('Non spécifié', 'Magi', 'Renou', 'magi.renou@gmail.eu', 'magi1234', 'MagiRenou','/assets/imgs/Profils/renou_magi.png', '23/02/2000','6', 'MAGRENOU06', 6);
INSERT INTO compte_client(civilite, nom, prenom, e_mail, mdp, pseudo, photo_profil, ddn, c_id_adresse, code_client, cc_id_adresse)
VALUES ('Mr', 'Renault', 'Guillaume', 'guillaume.renault@gmail.com', 'guigui14', 'guiguirenault','/assets/imgs/Profils/guillaume_renault.png', '25/04/1992','1', 'RENGUILLAUME07', 1);
INSERT INTO compte_client(civilite, nom, prenom, e_mail, mdp, pseudo, photo_profil, ddn, c_id_adresse, code_client, cc_id_adresse)
VALUES ('Mme', 'Mir', 'Ador', 'mir.ador@gmail.fr', '1234567', 'mimir78','/assets/imgs/Profils/mir_ador.png', '21/09/1999','4', 'MIRADOR09', 4);

INSERT INTO compte_proprietaire(civilite, nom, prenom, e_mail, mdp, pseudo, photo_profil, ddn, c_id_adresse, identite, date_cni_fin_valid, est_valide)
VALUES ('Mme', 'Kniglait', 'Keira', 'Keira.Kniglait@gmail.fr', 'keirakni89', 'KeiraSwann','/assets/imgs/Profils/keira_kniglait.png', '26/05/1985', '4', '/assets/imgs/cni/identite_01','21/12/2025', true );
INSERT INTO compte_proprietaire(civilite, nom, prenom, e_mail, mdp, pseudo, photo_profil, ddn, c_id_adresse, identite, date_cni_fin_valid, est_valide)
VALUES ('Mr', 'Toman', 'Ks', 'toman.ks@apple.us', 'totom11111', 'TomanWar','/assets/imgs/Profils/Toman_ks.png', '09/07/1956','5', '/assets/imgs/cni/identite_02', '27/05/2027', true );
INSERT INTO compte_proprietaire(civilite, nom, prenom, e_mail, mdp, pseudo, photo_profil, ddn, c_id_adresse, identite, date_cni_fin_valid, est_valide)
VALUES ('Non spécifié', 'Cam', 'Ailaion', 'Ailaion.cam@gmail.fr', 'camAil21', 'AilCamXX','/assets/imgs/Profils/ailaion_cam.png', '31/12/1956','2', './assets/imgs/cni/identite_03', '21/05/2020', false );

INSERT INTO compte_proprietaire(civilite, nom, prenom, e_mail, mdp, pseudo, photo_profil, ddn, c_id_adresse, identite, date_cni_fin_valid, est_valide)
VALUES ('Mr', 'Le Goff', 'Yannick', 'yannick.le_goff@exemple.com', 'yg123456', 'YannickBreton', '/assets/imgs/Profils/yannick_le_goff.png', '20/05/1975', 2, '/assets/imgs/cni/identite_04', '20/05/2029', true);

INSERT INTO compte_proprietaire(civilite, nom, prenom, e_mail, mdp, pseudo, photo_profil, ddn, c_id_adresse, identite, date_cni_fin_valid, est_valide)
VALUES ('Mr','Dupont', 'Paul', 'paul.dupont@example.com', 'paul123456', 'PaulDupont', '/assets/imgs/Profils/paul_dupont.png', '01/01/1980', 3, '/assets/imgs/cni/identite_05', '07/05/2020', false);

/* Insertion donnees avec accroches et description */

INSERT INTO logement(titre, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_compte, L_id_type, L_id_categorie, accroche, description)
VALUES ('Cabanon rustique', 2, '/assets/imgs/logements/image_1', 48.0275, -2.2163, 15, 1, 0, 1, 80, false, 2, 7, 7, 1, 7, 4, 4, 'Petit refuge rustique', 'Un cabanon rustique parfait pour une escapade en pleine nature, idéal pour deux personnes.');

INSERT INTO logement(titre, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_compte, L_id_type, L_id_categorie, accroche, description)
VALUES ('Maisonnette bord de mer', 3, '/assets/imgs/logements/image_2', 0.5, 1.2, 170, 2, 1, 1, 60, true, 7, 3, 3, 2, 8, 2, 5, 'Charmante maisonnette', 'Une maisonnette située en bord de mer, offrant une vue imprenable et un confort optimal pour trois personnes.');

INSERT INTO logement(titre, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_compte, L_id_type, L_id_categorie, accroche, description)
VALUES ('Maison', 6, '/assets/imgs/logements/image_3', 48.2345, -2.4567, 110, 3, 2, 1, 120, true, 4, 6, 7, 3, 7, 2, 2, 'Maison spacieuse', 'Une maison spacieuse pouvant accueillir jusquà six personnes, idéale pour les familles ou les groupes.');

INSERT INTO logement(titre, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_compte, L_id_type, L_id_categorie, accroche, description)
VALUES ('Appartement moderne', 4, '/assets/imgs/logements/image_4', 48.3456, -2.5678, 60, 1, 0, 1, 90, true, 2, 4, 7, 4, 9, 3, 3, 'Appartement moderne', 'Un appartement moderne et confortable, parfait pour quatre personnes, situé dans un quartier dynamique.');

INSERT INTO logement(titre, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_compte, L_id_type, L_id_categorie, accroche, description)
VALUES ('Studio design', 2, '/assets/imgs/logements/image_5', 48.4567, -2.6789, 20, 1, 0, 1, 70, false, 1, 3, 7, 5, 10, 4, 4, 'Studio design', 'Un studio design et élégant, idéal pour deux personnes, offrant tout le confort nécessaire pour un séjour agréable.');

INSERT INTO logement(titre, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_compte, L_id_type, L_id_categorie, accroche, description)
VALUES ('Maison', 6, '/assets/imgs/logements/image_6', 48.2345, -2.4567, 90, 4, 2, 1, 120, true, 4, 6, 7, 4, 11, 3, 3, 'Maison familiale', 'Une maison familiale pouvant accueillir jusquà six personnes, avec toutes les commodités nécessaires pour un séjour confortable.');

INSERT INTO logement(titre, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_compte, L_id_type, L_id_categorie, accroche, description)
VALUES ('Maison de vacances', 8, '/assets/imgs/logements/image_8', 48.5678, -2.7890, 130, 4, 2, 2, 150, true, 5, 7, 7, 5, 7, 5, 5, 'Maison de vacances', 'Une grande maison de vacances parfaite pour les groupes ou les familles, pouvant accueillir jusquà huit personnes.');

INSERT INTO logement(titre, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_compte, L_id_type, L_id_categorie, accroche, description)
VALUES ('Appartement', 3, '/assets/imgs/logements/image_9', 48.6789, -2.8901, 50, 1, 0, 1, 80, true, 3, 5, 7, 6, 9, 6, 6, 'Appartement cosy', 'Un appartement cosy et bien équipé, idéal pour trois personnes, situé dans un quartier calme.');

INSERT INTO logement(titre, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_compte, L_id_type, L_id_categorie, accroche, description)
VALUES ('Chalet en montagne', 5, '/assets/imgs/logements/image_10', 46.1278, 6.2160, 75, 2, 2, 1, 130, false, 3, 10, 7, 7, 8, 3, 5, 'Chalet cosy en montagne', 'Un chalet confortable et accueillant situé en pleine montagne, idéal pour des vacances de détente ou des activités de plein air.');

INSERT INTO logement(titre, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_compte, L_id_type, L_id_categorie, accroche, description)
VALUES ('Villa luxueuse', 10, '/assets/imgs/logements/image_11', 43.7034, 7.2663, 300, 5, 0, 5, 500, true, 7, 30, 14, 8, 10, 1, 1, 'Villa de luxe avec piscine', 'Une villa luxueuse et spacieuse avec piscine privée, parfaite pour des vacances de rêve en famille ou entre amis.');

INSERT INTO logement(titre, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_compte, L_id_type, L_id_categorie, accroche, description)
VALUES ('Maison de campagne', 7, '/assets/imgs/logements/image_12', 45.9876, 3.1234, 120, 3, 3, 1, 100, false, 4, 15, 10, 11, 9, 2, 4, 'Maison de campagne charmante', 'Une maison de campagne charmante et spacieuse, idéale pour des vacances en famille ou entre amis, avec un grand jardin et une vue sur la nature environnante.');

/* Reservation */


INSERT INTO reservation (nb_nuit, date_arrivee, date_depart, nb_occupant, date_reservation, en_annulation, R_id_logement, R_id_compte) VALUES
(3, '01/06/2024', '04/06/2024', 2, '15/05/2024', FALSE, 1, 1);

INSERT INTO reservation (nb_nuit, date_arrivee, date_depart, nb_occupant, date_reservation, en_annulation, R_id_logement, R_id_compte) VALUES
(5, '10/06/2024', '15/06/2024', 4, '20/05/2024', FALSE, 2, 2);

INSERT INTO reservation (nb_nuit, date_arrivee, date_depart, nb_occupant, date_reservation, en_annulation, R_id_logement, R_id_compte) VALUES
(2, '18/06/2024', '20/06/2024', 1, '25/05/2024', FALSE, 3, 3);

INSERT INTO reservation (nb_nuit, date_arrivee, date_depart, nb_occupant, date_reservation, en_annulation, R_id_logement, R_id_compte) VALUES
(7, '05/06/2024', '12/06/2024', 3, '18/05/2024', FALSE, 4, 4);

INSERT INTO reservation (nb_nuit, date_arrivee, date_depart, nb_occupant, date_reservation, en_annulation, R_id_logement, R_id_compte) VALUES
(4, '22/06/2024', '26/06/2024', 2, '30/05/2024', TRUE, 5, 3);

INSERT INTO reservation (nb_nuit, date_arrivee, date_depart, nb_occupant, date_reservation, en_annulation, R_id_logement, R_id_compte) VALUES
(6, '13/06/2024', '19/06/2024', 5, '21/05/2024', FALSE, 1, 2);

INSERT INTO reservation (nb_nuit, date_arrivee, date_depart, nb_occupant, date_reservation, en_annulation, R_id_logement, R_id_compte) VALUES
(1, '25/06/2024', '26/06/2024', 1, '01/06/2024', FALSE, 3, 1);

INSERT INTO reservation (nb_nuit, date_arrivee, date_depart, nb_occupant, date_reservation, en_annulation, R_id_logement, R_id_compte) VALUES
(3, '01/07/2024', '04/07/2024', 2, '05/06/2024', FALSE, 5, 4);

INSERT INTO reservation (nb_nuit, date_arrivee, date_depart, nb_occupant, date_reservation, en_annulation, R_id_logement, R_id_compte) VALUES
(2, '08/07/2024', '10/07/2024', 3, '10/06/2024', TRUE, 1, 3);

INSERT INTO reservation (nb_nuit, date_arrivee, date_depart, nb_occupant, date_reservation, en_annulation, R_id_logement, R_id_compte) VALUES
(5, '15/07/2024', '20/07/2024', 7, '15/06/2024', FALSE, 2, 6);


INSERT INTO avis (note_avis, commentaire, AV_id_reservation)
VALUES ('4', 'Très bel appartement', 1);
INSERT INTO avis (note_avis, commentaire, AV_id_reservation)
VALUES ('2', 'Matelas inconfortable, à revoir...', 5);
INSERT INTO avis (note_avis, commentaire, AV_id_reservation)
VALUES ('5', 'Un palace digne des plus grands ! Le roi Louis XIV aurait rêvé de ce logement !', 3);
INSERT INTO avis (note_avis, commentaire, AV_id_reservation)
VALUES ('3', 'Peut mieux faire.', 4);
INSERT INTO avis (note_avis, commentaire, AV_id_reservation)
VALUES ('1', 'Des cafards partout ! Cet appartement est misérable !', 2);



INSERT INTO activite_dispo(AD_id_logement, AD_id_activite, eloignement)
VALUES (1, 2, 'Sur place');
INSERT INTO activite_dispo(AD_id_logement, AD_id_activite, eloignement)
VALUES (1, 5, 'Moins de 5 km');
INSERT INTO activite_dispo(AD_id_logement, AD_id_activite, eloignement)
VALUES (3, 1, 'Moins de 10 km');
INSERT INTO activite_dispo(AD_id_logement, AD_id_activite, eloignement)
VALUES (2, 4, 'Moins de 15 km');
INSERT INTO activite_dispo(AD_id_logement, AD_id_activite, eloignement)
VALUES (4, 4, 'Moins de 20 km');
INSERT INTO activite_dispo(AD_id_logement, AD_id_activite, eloignement)
VALUES (4, 1, '20km et plus');

INSERT INTO numero_telephone(numero_tel, prefixe, id_compte)
VALUES ('658964722','+33', 1);
INSERT INTO numero_telephone(numero_tel, prefixe, id_compte)
VALUES ('658964562','+33', 2);
INSERT INTO numero_telephone(numero_tel, prefixe, id_compte)
VALUES ('351212587','+1', 2);
INSERT INTO numero_telephone(numero_tel, prefixe, id_compte)
VALUES ('202121256','+1', 4);
INSERT INTO numero_telephone(numero_tel, prefixe, id_compte)
VALUES ('75689542','+66', 5);
INSERT INTO numero_telephone(numero_tel, prefixe, id_compte)
VALUES ('858662562','+33', 3);



INSERT INTO langue_parlee(LP_id_compte, LP_id_langue)
VALUES (7,2);
INSERT INTO langue_parlee(LP_id_compte, LP_id_langue)
VALUES (8,3);
INSERT INTO langue_parlee(LP_id_compte, LP_id_langue)
VALUES (9,4);
INSERT INTO langue_parlee(LP_id_compte, LP_id_langue)
VALUES (10,5);
INSERT INTO langue_parlee(LP_id_compte, LP_id_langue)
VALUES (11,1);
INSERT INTO langue_parlee(LP_id_compte, LP_id_langue)
VALUES (7,1);
INSERT INTO langue_parlee(LP_id_compte, LP_id_langue)
VALUES (9,3);

INSERT INTO amenagements_logement(al_id_logement, al_id_amenagement)
VALUES (5,3);
INSERT INTO amenagements_logement(al_id_logement, al_id_amenagement)
VALUES (2,1);
INSERT INTO amenagements_logement(al_id_logement, al_id_amenagement)
VALUES (3,4);
INSERT INTO amenagements_logement(al_id_logement, al_id_amenagement)
VALUES (3,2);
INSERT INTO amenagements_logement(al_id_logement, al_id_amenagement)
VALUES (1,4);
INSERT INTO amenagements_logement(al_id_logement, al_id_amenagement)
VALUES (5,1);
INSERT INTO amenagements_logement(al_id_logement, al_id_amenagement)
VALUES (2,3);
INSERT INTO amenagements_logement(al_id_logement, al_id_amenagement)
VALUES (4,2);