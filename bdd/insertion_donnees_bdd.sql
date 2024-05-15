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
INSERT INTO adresse (numero_rue, nom_rue, code_postal, nom_ville, pays) 
VALUES 
 (21, 'rue de Villeneuve', 22300, 'Lannion', 'France');
INSERT INTO adresse (numero_rue, nom_rue, code_postal, nom_ville, pays) 
VALUES 
 (7, 'avenue Charles de Gaulle', 22300, 'Lannion', 'France');
INSERT INTO adresse (numero_rue, nom_rue, code_postal, nom_ville, pays, complement) 
VALUES 
 (1, 'rue Victor Hugo', 29200, 'Brest', 'France', 'bis');
INSERT INTO adresse (numero_rue, nom_rue, code_postal, nom_ville, pays) 
VALUES 
 (5, 'rue des tournesols', 29200, 'Brest', 'France');
INSERT INTO adresse (numero_rue, nom_rue, code_postal, nom_ville, pays) 
VALUES 
 (14, 'rue des ajoncs', 29800, 'Landerneau', 'France');
INSERT INTO adresse (numero_rue, nom_rue, code_postal, nom_ville, pays) 
VALUES 
 (11, 'rue des bleuets', 29600, 'Morlaix', 'France');


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


INSERT INTO compte(civilite, nom, prenom, e_mail, mdp, pseudo, photo_profil, ddn, c_id_adresse)
VALUES ('Mr', 'Neymar', 'Jean', 'Jean.Neymar@gmail.com', 'jeje92NEY', 'Jejean','./images/jean_neymar.png', '10/08/1992', '1');
INSERT INTO compte(civilite, nom, prenom, e_mail, mdp, pseudo, photo_profil, ddn, c_id_adresse)
VALUES ('Mme', 'Waxson', 'Emmi', 'emmmi.waxson@outlook.com', 'Wemmimi19', 'Wemimi', './images/emmi_waxson.png', '15/04/1990', '2');
INSERT INTO compte(civilite, nom, prenom, e_mail, mdp, pseudo, photo_profil, ddn, c_id_adresse)
VALUES ('Mr', 'Daip', 'Jauni', 'Daip.Jauni@wanadoo.com', 'jaujau12', 'JauniPaid','./images/jauni_daip.png', '09/06/1963', '3');
INSERT INTO compte(civilite, nom, prenom, e_mail, mdp, pseudo, photo_profil, ddn, c_id_adresse)
VALUES ('Mme', 'Kniglait', 'Keira', 'Keira.Kniglait@gmail.fr', 'keirakni89', 'KeiraSwann','./images/keira_kniglait.png', '26/05/1985', '4');
INSERT INTO compte(civilite, nom, prenom, e_mail, mdp, pseudo, photo_profil, ddn, c_id_adresse)
VALUES ('Mr', 'Toman', 'Ks', 'toman.ks@apple.us', 'totom11111', 'TomanWar','./images/Toman_ks.png', '09/07/1956','5');
INSERT INTO compte(civilite, nom, prenom, e_mail, mdp, pseudo, photo_profil, ddn, c_id_adresse)
VALUES ('Non spécifié', 'Magi', 'Renou', 'magi.renou@gmail.eu', 'magi1234', 'MagiRenou','./images/renou_magi.png', '23/02/2000','6');
INSERT INTO compte(civilite, nom, prenom, e_mail, mdp, pseudo, photo_profil, ddn, c_id_adresse)
VALUES ('Mr', 'Renault', 'Guillaume', 'guillaume.renault@gmail.com', 'magi1234', 'MagiRenou','./images/guillaume_renou.png', '23/02/2000','6');
INSERT INTO compte(civilite, nom, prenom, e_mail, mdp, pseudo, photo_profil, ddn, c_id_adresse)
VALUES ('Non spécifié', 'Magi', 'Renou', 'magi.renou@gmail.eu', 'magi1234', 'MagiRenou','./images/renou_magi.png', '23/02/2000','6');
INSERT INTO compte(civilite, nom, prenom, e_mail, mdp, pseudo, photo_profil, ddn, c_id_adresse)
VALUES ('Non spécifié', 'Magi', 'Renou', 'magi.renou@gmail.eu', 'magi1234', 'MagiRenou','./images/renou_magi.png', '23/02/2000','6');

INSERT INTO compte_client(code_client, cc_id_adresse)
VALUES ('NEYJEAN01', 1);
INSERT INTO compte_client(code_client, cc_id_adresse)
VALUES ('WAXEMMI02', 2);
INSERT INTO compte_client(code_client, cc_id_adresse)
VALUES ('DAIJAUNI03', 3);
INSERT INTO compte_client(code_client, cc_id_adresse)
VALUES ('MAGRENOU06', 6);

INSERT INTO compte_proprietaire(identite, date_cni_fin_valid, est_valide)
VALUES ('./images/cni/identite_01','21/12/2025', true );
INSERT INTO compte_proprietaire(identite, date_cni_fin_valid, est_valide)
VALUES ('./images/cni/identite_02', '27/05/2027', true );
INSERT INTO compte_proprietaire(identite, date_cni_fin_valid, est_valide)
VALUES ('./images/cni/identite_03', '27/05/2020', false );
INSERT INTO compte_proprietaire(identite, date_cni_fin_valid, est_valide)
VALUES ('./images/cni/identite_04', '27/05/2029', true );
INSERT INTO compte_proprietaire(identite, date_cni_fin_valid, est_valide)
VALUES ('./images/cni/identite_05', '27/05/2022', false );

INSERT INTO reservation (nb_nuit, date_arrivee, date_depart, nb_occupant, date_reservation, en_annulation, R_id_logement, R_id_client) VALUES
(3, '2024-06-01', '2024-06-04', 2, '2024-05-15', FALSE, 1, 1);

INSERT INTO reservation (nb_nuit, date_arrivee, date_depart, nb_occupant, date_reservation, en_annulation, R_id_logement, R_id_client) VALUES
(5, '2024-06-10', '2024-06-15', 4, '2024-05-20', FALSE, 2, 2);

INSERT INTO reservation (nb_nuit, date_arrivee, date_depart, nb_occupant, date_reservation, en_annulation, R_id_logement, R_id_client) VALUES
(2, '2024-06-18', '2024-06-20', 1, '2024-05-25', FALSE, 3, 3);

INSERT INTO reservation (nb_nuit, date_arrivee, date_depart, nb_occupant, date_reservation, en_annulation, R_id_logement, R_id_client) VALUES
(7, '2024-06-05', '2024-06-12', 3, '2024-05-18', FALSE, 4, 4);

INSERT INTO reservation (nb_nuit, date_arrivee, date_depart, nb_occupant, date_reservation, en_annulation, R_id_logement, R_id_client) VALUES
(4, '2024-06-22', '2024-06-26', 2, '2024-05-30', TRUE, 5, 3);

INSERT INTO reservation (nb_nuit, date_arrivee, date_depart, nb_occupant, date_reservation, en_annulation, R_id_logement, R_id_client) VALUES
(6, '2024-06-13', '2024-06-19', 5, '2024-05-21', FALSE, 1, 2);

INSERT INTO reservation (nb_nuit, date_arrivee, date_depart, nb_occupant, date_reservation, en_annulation, R_id_logement, R_id_client) VALUES
(1, '2024-06-25', '2024-06-26', 1, '2024-06-01', FALSE, 3, 1);

INSERT INTO reservation (nb_nuit, date_arrivee, date_depart, nb_occupant, date_reservation, en_annulation, R_id_logement, R_id_client) VALUES
(3, '2024-07-01', '2024-07-04', 2, '2024-06-05', FALSE, 5, 4);

INSERT INTO reservation (nb_nuit, date_arrivee, date_depart, nb_occupant, date_reservation, en_annulation, R_id_logement, R_id_client) VALUES
(2, '2024-07-08', '2024-07-10', 3, '2024-06-10', TRUE, 1, 3);

INSERT INTO reservation (nb_nuit, date_arrivee, date_depart, nb_occupant, date_reservation, en_annulation, R_id_logement, R_id_client) VALUES
(5, '2024-07-15', '2024-07-20', 7, '2024-06-15', FALSE, 2, 6);


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

INSERT INTO numero_telephone(numero_tel, prefixe)
VALUES ('658964722','+33');
INSERT INTO numero_telephone(numero_tel, prefixe)
VALUES ('658964562','+33');
INSERT INTO numero_telephone(numero_tel, prefixe)
VALUES ('658964562','+33');


INSERT INTO logement(titre, accroche, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_proprietaire, L_id_type, L_id_categorie)
VALUES ('Cabanon rustique', 'Retrouvez le charme du paysage breton avec notre cabanon rustique, parfait pour une escapade tranquille au cœur de la nature.', 2, './image/logements/image_1', 48.0275, -2.2163, 48, 1, 0, 1, 80, 1, 2, 7, 7, 1, 1, 4, 4);

INSERT INTO logement(titre, accroche, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_proprietaire, L_id_type, L_id_categorie)
VALUES ('Maisonnette bord de mer', 'Profitez de la vue imprenable sur la mer avec notre maisonnette bord de mer, idéale pour des vacances en famille ou entre amis.', 3, './image/logements/image_2', 0, 0, 68, 2, 1, 1, 60, 1, 7, 3, 3, 2, 2, 2, 5);

INSERT INTO logement(titre, accroche, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_proprietaire, L_id_type, L_id_categorie)
VALUES ('Maison', 'Profitez d''un séjour en pleine nature dans notre maison bretonne traditionnelle.', 6, './image/logements/image_3', 48.2345, -2.4567, 60, 3, 2, 1, 120, 1, 4, 6, 7, 3, 3, 2, 2);

INSERT INTO logement(titre, accroche, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_proprietaire, L_id_type, L_id_categorie)
VALUES ('Appartement moderne', 'Appartement moderne et confortable, parfait pour un séjour en couple ou entre amis.', 4, './image/logements/image_4', 48.3456, -2.5678, 45, 1, 0, 1, 90, 1, 2, 4, 7, 4, 4, 3, 3);

INSERT INTO logement(titre, accroche, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_proprietaire, L_id_type, L_id_categorie)
VALUES ('Studio design', 'Studio design et élégant, idéal pour un séjour à la découverte de la Bretagne.', 2, './image/logements/image_5', 48.4567, -2.6789, 30, 0, 0, 1, 70, 1, 1, 3, 7, 5, 5, 4, 4);

INSERT INTO logement(titre, accroche, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_proprietaire, L_id_type, L_id_categorie)
VALUES ('Maison', 'Profitez d''un séjour en pleine nature dans notre maison bretonne traditionnelle.', 6, './image/logements/image_6', 48.2345, -2.4567, 60, 3, 2, 1, 120, 1, 4, 6, 7, 4, 4, 3, 3);

INSERT INTO logement(titre, accroche, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_proprietaire, L_id_type, L_id_categorie)
VALUES ('Maison de vacances', 'Maison de vacances avec jardin, parfait pour des vacances en famille ou entre amis.', 8, './image/logements/image_8', 48.5678, -2.7890, 70, 4, 2, 2, 150, 1, 5, 7, 7, 5, 5, 5, 5);

INSERT INTO logement(titre, accroche, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_proprietaire, L_id_type, L_id_categorie)
VALUES ('Appartement', 'Appartement spacieux et bien équipé, idéal pour un séjour en couple.', 3, './image/logements/image_9', 48.6789, -2.8901, 40, 1, 0, 1, 80, 1, 3, 5, 7, 6, 6, 6, 6);

INSERT INTO logement(titre, accroche, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_proprietaire, L_id_type, L_id_categorie)
VALUES ('Gîte écologique', 'Gîte écologique, au cœur de la nature, parfait pour un séjour éco-responsable.', 4, './image/logements/image_10', 48.7890, -3.0000, 50, 2, 1, 1, 100, 1, 4, 6, 7, 7, 7, 7, 7);

INSERT INTO logement(titre, accroche, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_proprietaire, L_id_type, L_id_categorie)
VALUES ('Maison typique bretonne', 'Maison typique bretonne, au cœur du paysage breton, idéale pour une escapade tranquille.', 6, './image/logements/image_11', 48.8901, -3.1111, 60, 3, 2, 1, 120, 1, 5, 7, 7, 8, 8, 8, 8);

INSERT INTO logement(titre, accroche, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_proprietaire, L_id_type, L_id_categorie)
VALUES ('Appartement', 'Appartement moderne et confortable, parfait pour un séjour en couple ou entre amis.', 4, './image/logements/image_12', 48.9012, -3.2222, 45, 1, 0, 1, 90, 1, 2, 4, 7, 9, 9, 9, 9);

INSERT INTO logement(titre, accroche, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_proprietaire, L_id_type, L_id_categorie)
VALUES ('Gîte familial', 'Gîte familial, spacieux et bien équipé, idéal pour un séjour en famille.', 8, './image/logements/image_13', 48.9123, -3.3333, 70, 4, 2, 2, 150, 1, 6, 8, 7, 10, 10, 10, 10);


/* Insertion sans les descriptions et accroches */
INSERT INTO logement(titre, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_proprietaire, L_id_type, L_id_categorie)
VALUES ('Cabanon rustique', 2, './image/logements/image_1', 48.0275, -2.2163, 15, 1, 0, 1, 80, false, 2, 7, 7, 1, 1, 4, 4);

INSERT INTO logement(titre, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, 
statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_proprietaire, L_id_type, L_id_categorie)
VALUES ('Maisonnette bord de mer', 3, './image/logements/image_2', 0.5, 1.2, 170, 2, 1, 1, 60, true, 7, 3, 3, 2, 2, 2, 5);

INSERT INTO logement(titre, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_proprietaire, L_id_type, L_id_categorie)
VALUES ('Maison', 6, './image/logements/image_3', 48.2345, -2.4567, 110, 3, 2, 1, 120, true, 4, 6, 7, 3, 3, 2, 2);

INSERT INTO logement(titre, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_proprietaire, L_id_type, L_id_categorie)
VALUES ('Appartement moderne', 4, './image/logements/image_4', 48.3456, -2.5678, 60, 1, 0, 1, 90, true, 2, 4, 7, 4, 4, 3, 3);

INSERT INTO logement(titre, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_proprietaire, L_id_type, L_id_categorie)
VALUES ('Studio design', 2, './image/logements/image_5', 48.4567, -2.6789, 20, 1, 0, 1, 70, false, 1, 3, 7, 5, 5, 4, 4);

INSERT INTO logement(titre, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_proprietaire, L_id_type, L_id_categorie)
VALUES ('Maison', 6, './image/logements/image_6', 48.2345, -2.4567, 90, 4, 2, 1, 120, true, 4, 6, 7, 4, 4, 3, 3);

INSERT INTO logement(titre, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_proprietaire, L_id_type, L_id_categorie)
VALUES ('Maison de vacances', 8, './image/logements/image_8', 48.5678, -2.7890, 130, 4, 2, 2, 150, true, 5, 7, 7, 5, 5, 5, 5);

INSERT INTO logement(titre, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_proprietaire, L_id_type, L_id_categorie)
VALUES ('Appartement', 3, './image/logements/image_9', 48.6789, -2.8901, 50, 1, 0, 1, 80, true, 3, 5, 7, 6, 5, 6, 6);


INSERT INTO langue_parlee(LP_id_proprietaire, LP_id_langue)
VALUES (1,2);
INSERT INTO langue_parlee(LP_id_proprietaire, LP_id_langue)
VALUES (2,3);
INSERT INTO langue_parlee(LP_id_proprietaire, LP_id_langue)
VALUES (2,4);
INSERT INTO langue_parlee(LP_id_proprietaire, LP_id_langue)
VALUES (3,5);
INSERT INTO langue_parlee(LP_id_proprietaire, LP_id_langue)
VALUES (3,1);
INSERT INTO langue_parlee(LP_id_proprietaire, LP_id_langue)
VALUES (4,1);
INSERT INTO langue_parlee(LP_id_proprietaire, LP_id_langue)
VALUES (5,3);

INSERT INTO amenagements_logement(al_id_logement, al_id_amenagement)
VALUES (5,3);
