SET SCHEMA 'sae3';
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
INSERT INTO adresse (numero_rue, nom_rue, code_postal, nom_ville, pays) 
VALUES 
 (13, 'rue du kernic', 29430, 'Plouescat', 'France');
INSERT INTO adresse (numero_rue, nom_rue, code_postal, nom_ville, pays) 
VALUES 
 (8, 'rue claire dreaunau', 56100, 'Lorient', 'France');
INSERT INTO adresse (numero_rue, nom_rue, code_postal, nom_ville, pays) 
VALUES 
 (13, 'Hent an aod', 29910 , 'Trégunc', 'France');
INSERT INTO adresse (numero_rue, nom_rue, code_postal, nom_ville, pays) 
VALUES 
 (13, 'Hent an aod', 29910 , 'Trégunc', 'France');

/* Adresses clients étrangers */
INSERT INTO adresse (numero_rue, nom_rue, code_postal, nom_ville, pays, etat) 
VALUES 
 (05, 'Columbia Street', 20001, 'Washington DC', 'USA', 'Columbia');
INSERT INTO adresse (numero_rue, nom_rue, code_postal, nom_ville, pays) 
VALUES 
 (13, 'rue du kernic', 29430, 'Plouescat', 'France');
INSERT INTO adresse (numero_rue, nom_rue, code_postal, nom_ville, pays) 
VALUES 
 (8, 'rue claire dreaunau', 56100, 'Lorient', 'France');
INSERT INTO adresse (numero_rue, nom_rue, code_postal, nom_ville, pays) 
VALUES 
 (13, 'Hent an aod', 29910 , 'Trégunc', 'France');



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
INSERT INTO langue(nom_langue)
VALUES ('Anglais');
INSERT INTO langue(nom_langue)
VALUES ('Italien');
INSERT INTO langue(nom_langue)
VALUES ('Ecossais');
INSERT INTO langue(nom_langue)
VALUES ('Irlandais');



INSERT INTO compte_client(civilite, nom, prenom, e_mail, mdp, pseudo, photo_profil, ddn, c_id_adresse, code_client, cc_id_adresse)
VALUES ('Mr', 'Neymar', 'Jean', 'Jean.Neymar@gmail.com', '$2y$10$K9Pqj5NAb9LHPaf/WDVNIurPpd5pdhO7.JDdFsSdlNXaHkTdiIDuK', 'Jejean','/assets/imgs/Profils/jean_neymar.webp', '10/08/1992', '1', 'NEYJEAN01', 1);
INSERT INTO compte_client(civilite, nom, prenom, e_mail, mdp, pseudo, photo_profil, ddn, c_id_adresse, code_client, cc_id_adresse)
VALUES ('Mme', 'Waxson', 'Emmi', 'emmmi.waxson@outlook.com', '$2y$10$K9Pqj5NAb9LHPaf/WDVNIurPpd5pdhO7.JDdFsSdlNXaHkTdiIDuK', 'Wemimi', '/assets/imgs/Profils/emmi_waxson.webp', '15/04/1990', '2', 'WAXEMMI02', 2);
INSERT INTO compte_client(civilite, nom, prenom, e_mail, mdp, pseudo, photo_profil, ddn, c_id_adresse, code_client, cc_id_adresse)
VALUES ('Mr', 'Daip', 'Jauni', 'Daip.Jauni@wanadoo.com', '$2y$10$K9Pqj5NAb9LHPaf/WDVNIurPpd5pdhO7.JDdFsSdlNXaHkTdiIDuK', 'JauniPaid','/assets/imgs/Profils/jauni_daip.webp', '09/06/1963', '3', 'DAIJAUNI03', 3);
INSERT INTO compte_client(civilite, nom, prenom, e_mail, mdp, pseudo, photo_profil, ddn, c_id_adresse, code_client, cc_id_adresse)
VALUES ('Non spécifié', 'Magi', 'Renou', 'magi.renou@gmail.eu', '$2y$10$K9Pqj5NAb9LHPaf/WDVNIurPpd5pdhO7.JDdFsSdlNXaHkTdiIDuK', 'MagiRenou','/assets/imgs/Profils/renou_magi.webp', '23/02/2000','6', 'MAGRENOU06', 6);
INSERT INTO compte_client(civilite, nom, prenom, e_mail, mdp, pseudo, photo_profil, ddn, c_id_adresse, code_client, cc_id_adresse)
VALUES ('Mr', 'Renault', 'Guillaume', 'guillaume.renault@gmail.com', '$2y$10$K9Pqj5NAb9LHPaf/WDVNIurPpd5pdhO7.JDdFsSdlNXaHkTdiIDuK', 'guiguirenault','/assets/imgs/Profils/guillaume_renault.webp', '25/04/1992','1', 'RENGUILLAUME07', 1);
INSERT INTO compte_client(civilite, nom, prenom, e_mail, mdp, pseudo, photo_profil, ddn, c_id_adresse, code_client, cc_id_adresse)
VALUES ('Mme', 'Mir', 'Ador', 'mir.ador@gmail.us', '$2y$10$K9Pqj5NAb9LHPaf/WDVNIurPpd5pdhO7.JDdFsSdlNXaHkTdiIDuK', 'mimir78','/assets/imgs/Profils/mir_ador.webp', '21/09/1999','14', 'MIRADOR09', 4);

INSERT INTO compte_proprietaire(civilite, nom, prenom, e_mail, mdp, pseudo, photo_profil, ddn, c_id_adresse, identite, date_cni_fin_valid, est_valide)
VALUES ('Mme', 'Kniglait', 'Keira', 'Keira.Kniglait@gmail.fr', '$2y$10$K9Pqj5NAb9LHPaf/WDVNIurPpd5pdhO7.JDdFsSdlNXaHkTdiIDuK', 'KeiraSwann','/assets/imgs/Profils/keira_kniglait.webp', '26/05/1985', '4', '/assets/imgs/cni/identite_01','21/12/2025', true );
INSERT INTO compte_proprietaire(civilite, nom, prenom, e_mail, mdp, pseudo, photo_profil, ddn, c_id_adresse, identite, date_cni_fin_valid, est_valide)
VALUES ('Mr', 'Toman', 'Ks', 'toman.ks@apple.us', '$2y$10$K9Pqj5NAb9LHPaf/WDVNIurPpd5pdhO7.JDdFsSdlNXaHkTdiIDuK', 'TomanWar','/assets/imgs/Profils/toman_ks.webp', '09/07/1956','5', '/assets/imgs/cni/identite_02', '27/05/2027', true );
INSERT INTO compte_proprietaire(civilite, nom, prenom, e_mail, mdp, pseudo, photo_profil, ddn, c_id_adresse, identite, date_cni_fin_valid, est_valide)
VALUES ('Non spécifié', 'Cam', 'Ailaion', 'Ailaion.cam@gmail.fr', '$2y$10$K9Pqj5NAb9LHPaf/WDVNIurPpd5pdhO7.JDdFsSdlNXaHkTdiIDuK', 'AilCamXX','/assets/imgs/Profils/ailaion_cam.webp', '31/12/1956','2', './assets/imgs/cni/identite_03', '21/05/2020', false );

INSERT INTO compte_proprietaire(civilite, nom, prenom, e_mail, mdp, pseudo, photo_profil, ddn, c_id_adresse, identite, date_cni_fin_valid, est_valide)
VALUES ('Mr', 'Le Goff', 'Yannick', 'yannick.le_goff@exemple.com', '$2y$10$K9Pqj5NAb9LHPaf/WDVNIurPpd5pdhO7.JDdFsSdlNXaHkTdiIDuK', 'YannickBreton', '/assets/imgs/Profils/yannick_le_goff.webp', '20/05/1975', 2, '/assets/imgs/cni/identite_04', '20/05/2029', true);

INSERT INTO compte_proprietaire(civilite, nom, prenom, e_mail, mdp, pseudo, photo_profil, ddn, c_id_adresse, identite, date_cni_fin_valid, est_valide)
VALUES ('Mr','Dupont', 'Paul', 'paul.dupont@example.com', '$2y$10$K9Pqj5NAb9LHPaf/WDVNIurPpd5pdhO7.JDdFsSdlNXaHkTdiIDuK', 'PaulDupont', '/assets/imgs/Profils/paul_dupont.webp', '01/01/1980', 3, '/assets/imgs/cni/identite_05', '07/05/2020', false);

/* Ensemble des logements */ 

INSERT INTO logement(titre, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_compte, L_id_type, L_id_categorie, accroche, description, prix_nuit_ttc)
VALUES ('Cabanon dans la forêt', 2, '/assets/imgs/logements/image_1.svg', 48.0275, -2.2163, 15, 1, 0, 1, 80, false, 2, 7, 7, 1, 7, 4, 4, 'Petit refuge rustique', 'Un cabanon rustique parfait pour une escapade en pleine nature, idéal pour deux personnes.', 88);

INSERT INTO logement(titre, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_compte, L_id_type, L_id_categorie, accroche, description, prix_nuit_ttc)
VALUES ('Maisonnette en plein air', 3, '/assets/imgs/logements/image_2.svg', 0.5, 1.2, 170, 2, 1, 1, 60, true, 7, 3, 3, 2, 8, 2, 5, 'Charmante maisonnette', 'Une maisonnette située en bord de mer, offrant une vue imprenable et un confort optimal pour trois personnes.', 66);

INSERT INTO logement(titre, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_compte, L_id_type, L_id_categorie, accroche, description, prix_nuit_ttc)
VALUES ('Maisonnette', 6, '/assets/imgs/logements/image_3.svg', 48.2345, -2.4567, 110, 3, 2, 1, 120, true, 4, 6, 7, 3, 7, 2, 2, 'Maison spacieuse', 'Une maison spacieuse pouvant accueillir jusquà six personnes, idéale pour les familles ou les groupes.', 132);

INSERT INTO logement(titre, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_compte, L_id_type, L_id_categorie, accroche, description, prix_nuit_ttc)
VALUES ('Maison moderne', 4, '/assets/imgs/logements/image_4.svg', 48.3456, -2.5678, 60, 1, 0, 1, 90, true, 2, 4, 7, 4, 9, 3, 3, 'Appartement moderne', 'Un appartement moderne et confortable, parfait pour quatre personnes, situé dans un quartier dynamique.', 99);

INSERT INTO logement(titre, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_compte, L_id_type, L_id_categorie, accroche, description, prix_nuit_ttc)
VALUES ('Maison familiale', 6, '/assets/imgs/logements/image_5.svg', 48.2345, -2.4567, 90, 4, 2, 1, 120, true, 4, 6, 7, 4, 11, 3, 3, 'Maison familiale', 'Une maison familiale pouvant accueillir jusquà six personnes, avec toutes les commodités nécessaires pour un séjour confortable.', 132);

INSERT INTO logement(titre, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_compte, L_id_type, L_id_categorie, accroche, description, prix_nuit_ttc)
VALUES ('Maison proche de la forêt', 8, '/assets/imgs/logements/image_6.svg', 48.5678, -2.7890, 130, 4, 2, 2, 150, true, 5, 7, 7, 5, 7, 5, 5, 'Maison à deux pas des arbres, idéales pour des balades !', 'Une grande maison de vacances parfaite pour les groupes ou les familles, pouvant accueillir jusquà huit personnes.', 165);

INSERT INTO logement(titre, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_compte, L_id_type, L_id_categorie, accroche, description, prix_nuit_ttc)
VALUES ('Maison en bord de mer', 3, '/assets/imgs/logements/image_7.jpg', 48.6789, -2.8901, 50, 1, 0, 1, 80, true, 3, 5, 7, 6, 9, 6, 6, 'Maison cosy', 'Un appartement cosy et bien équipé, idéal pour trois personnes, situé dans un quartier calme.', 88);

INSERT INTO logement(titre, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_compte, L_id_type, L_id_categorie, accroche, description, prix_nuit_ttc)
VALUES ('Chalet en montagne', 5, '/assets/imgs/logements/image_8.svg', 46.1278, 6.2160, 75, 2, 2, 1, 130, false, 3, 10, 7, 7, 8, 3, 5, 'Chalet cosy en montagne', 'Un chalet confortable et accueillant situé en pleine montagne, idéal pour des vacances de détente ou des activités de plein air.', 143);

INSERT INTO logement(titre, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_compte, L_id_type, L_id_categorie, accroche, description, prix_nuit_ttc)
VALUES ('Villa luxueuse', 10, '/assets/imgs/logements/image_9.svg', 43.7034, 7.2663, 300, 5, 0, 5, 500, true, 7, 30, 14, 8, 10, 1, 1, 'Villa de luxe avec piscine', 'Une villa luxueuse et spacieuse avec piscine privée, parfaite pour des vacances de rêve en famille ou entre amis.', 550);

INSERT INTO logement(titre, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_compte, L_id_type, L_id_categorie, accroche, description, prix_nuit_ttc)
VALUES ('Manoir', 12, '/assets/imgs/logements/image_10.svg', 75.9876, 30.1234, 200, 5, 3, 2, 500, true, 7, 14, 30, 1, 7, 6, 2, 'Manoir de luxe', 'Un manoir spacieux et luxueux, parfait pour des vacances en famille ou entre amis.', 550);

INSERT INTO logement(titre, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_compte, L_id_type, L_id_categorie, accroche, description, prix_nuit_ttc)
VALUES ('Maison luxueuse', 8, '/assets/imgs/logements/image_11.svg', 45.9876, 3.1234, 150, 4, 2, 2, 300, true, 4, 7, 14, 2, 8, 5, 2, 'Maison luxueuse', 'Une maison luxueuse offrant tout le confort moderne dans un cadre magnifique.', 330);

INSERT INTO logement(titre, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_compte, L_id_type, L_id_categorie, accroche, description, prix_nuit_ttc)
VALUES ('Maison familiale', 10, '/assets/imgs/logements/image_12.svg', 45.9876, 3.1234, 180, 5, 2, 3, 250, true, 5, 7, 14, 3, 9, 5, 2, 'Maison familiale', 'Une maison familiale spacieuse avec un grand jardin et une vue superbe.', 275);

INSERT INTO logement(titre, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_compte, L_id_type, L_id_categorie, accroche, description, prix_nuit_ttc)
VALUES ('Cabanon bord de rivière', 3, '/assets/imgs/logements/image_13.jpg', 131.9876, 56.1234, 50, 1, 1, 1, 70, false, 2, 3, 7, 4, 10, 1, 4, 'Cabanon bord de rivière', 'Un cabanon cosy et rustique au bord dune rivière paisible.', 77);

INSERT INTO logement(titre, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_compte, L_id_type, L_id_categorie, accroche, description, prix_nuit_ttc)
VALUES ('Cabane en foret', 4, '/assets/imgs/logements/image_14.jpg', 45.9876, 3.1234, 60, 2, 2, 1, 120, false, 3, 5, 10, 5, 11, 2, 4, 'Cabane en forêt', 'Une cabane en forêt, idéale pour une escapade nature en famille ou entre amis.', 132);

INSERT INTO logement(titre, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_compte, L_id_type, L_id_categorie, accroche, description, prix_nuit_ttc)
VALUES ('Grande maison familiale', 8, '/assets/imgs/logements/image_15.jpg', 45.9876, 3.1234, 140, 4, 2, 2, 350, true, 6, 14, 30, 6, 7, 4, 2, 'Grande maison familiale', 'Une grande maison parfaite pour des réunions de famille, avec de nombreuses commodités.', 385);

INSERT INTO logement(titre, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_compte, L_id_type, L_id_categorie, accroche, description, prix_nuit_ttc)
VALUES ('Maison à côté du phare', 5, '/assets/imgs/logements/image_16.jpg', 45.9876, 3.1234, 100, 3, 1, 2, 180, false, 3, 10, 14, 7, 8, 3, 4, 'Maison à côté du phare', 'Une maison pittoresque à côté dun phare, avec une vue incroyable sur la mer.', 198);

INSERT INTO logement(titre, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_compte, L_id_type, L_id_categorie, accroche, description, prix_nuit_ttc)
VALUES ('Maison de bord de mer', 6, '/assets/imgs/logements/image_17.jpg', 45.9876, 3.1234, 120, 3, 2, 1, 220, true, 5, 7, 14, 8, 9, 4, 4, 'Maison de bord de mer', 'Une maison charmante en bord de mer, parfaite pour des vacances relaxantes.', 242);

INSERT INTO logement(titre, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_compte, L_id_type, L_id_categorie, accroche, description, prix_nuit_ttc)
VALUES ('Maison ancienne de village', 5, '/assets/imgs/logements/image_18.jpg', 45.9876, 3.1234, 90, 3, 2, 1, 160, false, 4, 7, 14, 9, 10, 3, 4, 'Maison ancienne de village', 'Une maison ancienne pleine de charme située dans un village pittoresque.', 176);

INSERT INTO logement(titre, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_compte, L_id_type, L_id_categorie, accroche, description, prix_nuit_ttc)
VALUES ('Maison typique bretonne', 6, '/assets/imgs/logements/image_19.jpg', 45.9876, 3.1234, 110, 3, 2, 1, 180, true, 4, 10, 20, 10, 11, 3, 4, 'Maison typique bretonne', 'Une maison typique bretonne avec beaucoup de caractère, idéale pour des vacances en famille.', 198);

INSERT INTO logement(titre, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_compte, L_id_type, L_id_categorie, accroche, description, prix_nuit_ttc)
VALUES ('Petite maison de ville', 4, '/assets/imgs/logements/image_20.jpg', 45.9876, 3.1234, 70, 2, 1, 1, 100, false, 3, 5, 10, 11, 11, 2, 4, 'Petite maison de ville', 'Une petite maison de ville pratique et confortable, idéale pour un séjour en ville.', 110);

INSERT INTO logement(titre, personnes_max, image_principale, latitude, longitude, surface_hab, nb_chambres, nb_lits_simples, nb_lits_doubles, prix_nuit_ht, statut_propriete, duree_min_location, avance_resa_min, delai_annul_max, L_id_adresse, L_id_compte, L_id_type, L_id_categorie, accroche, description, prix_nuit_ttc)
VALUES ('Chalet dans les bois', 6, '/assets/imgs/logements/image_21.jpg', 45.9876, 3.1234, 100, 3, 1, 2, 200, true, 5, 7, 14, 12, 10, 3, 4, 'Chalet dans les bois', 'Un chalet chaleureux situé dans les bois, parfait pour une retraite paisible.', 220);


/* Reservation */



INSERT INTO reservation (nb_nuit, date_arrivee, date_depart, nb_occupant, date_reservation, en_annulation, R_id_logement, R_id_compte, total_tarif_ttc, frais_service, taxe_sejour, tarif_total) VALUES
(3, '01/06/2024', '04/06/2024', 2, '15/05/2024', FALSE, 1, 1, 528, 5.28, 6, 539.28);

INSERT INTO reservation (nb_nuit, date_arrivee, date_depart, nb_occupant, date_reservation, en_annulation, R_id_logement, R_id_compte, total_tarif_ttc, frais_service, taxe_sejour, tarif_total) VALUES
(5, '10/06/2024', '15/06/2024', 4, '20/05/2024', FALSE, 2, 2, 1320, 13.2, 20, 1353.2);

INSERT INTO reservation (nb_nuit, date_arrivee, date_depart, nb_occupant, date_reservation, en_annulation, R_id_logement, R_id_compte, total_tarif_ttc, frais_service, taxe_sejour, tarif_total) VALUES
(2, '18/06/2024', '20/06/2024', 1, '25/05/2024', FALSE, 3, 3, 264, 2.64, 2, 268.64);
INSERT INTO reservation (nb_nuit, date_arrivee, date_depart, nb_occupant, date_reservation, en_annulation, R_id_logement, R_id_compte, total_tarif_ttc, frais_service, taxe_sejour, tarif_total) VALUES
(7, '05/06/2024', '12/06/2024', 3, '18/05/2024', FALSE, 4, 4, 2073, 20.73, 21, 2114.73);

INSERT INTO reservation (nb_nuit, date_arrivee, date_depart, nb_occupant, date_reservation, en_annulation, R_id_logement, R_id_compte, total_tarif_ttc, frais_service, taxe_sejour, tarif_total) VALUES
(4, '22/06/2024', '26/06/2024', 2, '30/05/2024', TRUE, 5, 3, 1056, 10.56, 8, 1074.56);

INSERT INTO reservation (nb_nuit, date_arrivee, date_depart, nb_occupant, date_reservation, en_annulation, R_id_logement, R_id_compte, total_tarif_ttc, frais_service, taxe_sejour, tarif_total) VALUES
(6, '13/06/2024', '19/06/2024', 5, '21/05/2024', FALSE, 1, 2, 4950, 49.5, 30, 5029.5);

INSERT INTO reservation (nb_nuit, date_arrivee, date_depart, nb_occupant, date_reservation, en_annulation, R_id_logement, R_id_compte, total_tarif_ttc, frais_service, taxe_sejour, tarif_total) VALUES
(1, '25/06/2024', '26/06/2024', 1, '01/06/2024', FALSE, 3, 1, 88, 0.88, 1, 89.88);

INSERT INTO reservation (nb_nuit, date_arrivee, date_depart, nb_occupant, date_reservation, en_annulation, R_id_logement, R_id_compte, total_tarif_ttc, frais_service, taxe_sejour, tarif_total) VALUES
(3, '01/07/2024', '04/07/2024', 2, '05/06/2024', FALSE, 5, 4, 396, 3.96, 6, 405.96);

INSERT INTO reservation (nb_nuit, date_arrivee, date_depart, nb_occupant, date_reservation, en_annulation, R_id_logement, R_id_compte, total_tarif_ttc, frais_service, taxe_sejour, tarif_total) VALUES
(2, '08/07/2024', '10/07/2024', 3, '10/06/2024', TRUE, 1, 3, 792, 7.92, 6, 805.92);

INSERT INTO reservation (nb_nuit, date_arrivee, date_depart, nb_occupant, date_reservation, en_annulation, R_id_logement, R_id_compte, total_tarif_ttc, frais_service, taxe_sejour, tarif_total) VALUES
(5, '15/07/2024', '20/07/2024', 7, '15/06/2024', FALSE, 2, 6, 5775, 57.75, 35, 5867.75);

INSERT INTO reservation (nb_nuit, date_arrivee, date_depart, nb_occupant, date_reservation, en_annulation, R_id_logement, R_id_compte, total_tarif_ttc, frais_service, taxe_sejour, tarif_total) VALUES
(5, '15/07/2024', '20/07/2024', 7, '15/06/2024', FALSE, 2, 6, 5775, 57.75, 35, 5867.75);

INSERT INTO avis (note_avis, commentaire, AV_id_reservation)
VALUES ('4', 'Très bel appartement', 1);
INSERT INTO avis (note_avis, commentaire, AV_id_reservation)
VALUES ('2', 'Matelas inconfortable, à revoir...', 5);
INSERT INTO avis (note_avis, commentaire, AV_id_reservation)
VALUES ('5', 'Un palace digne des plus grands ! Le roi Louis XIV aurait rêvé de ce logement !', 3);
INSERT INTO avis (note_avis, commentaire, AV_id_reservation)
VALUES ('3', 'Peut mieux faire.', 4);
INSERT INTO avis (note_avis, commentaire, AV_id_reservation)
VALUES ('1', 'Des cafards partout ! Ce logement est misérable !', 2);
INSERT INTO avis (note_avis, commentaire, AV_id_reservation)
VALUES ('5', 'Le séjour a été fantastique, le logement était impeccable et bien situé. Je recommande vivement !', 7);
INSERT INTO avis (note_avis, commentaire, AV_id_reservation)
VALUES ('3', 'Le logement était correct, mais il y avait quelques problèmes de propreté... Les vacances familiales furent difficiles !', 8);
INSERT INTO avis (note_avis, commentaire, AV_id_reservation)
VALUES ('1', 'Le logement était sale et mal entretenu, une expérience très décevante.', 6);


INSERT INTO activite_dispo(AD_id_logement, AD_id_activite, eloignement)
VALUES (3, 1, 'Moins de 10 km');
INSERT INTO activite_dispo(AD_id_logement, AD_id_activite, eloignement)
VALUES (4, 1, '20km et plus');

INSERT INTO activite_dispo(AD_id_logement, AD_id_activite, eloignement)
VALUES (1, 2, 'Sur place');
INSERT INTO activite_dispo(AD_id_logement, AD_id_activite, eloignement)
VALUES (11, 2, 'Moins de 20 km');
INSERT INTO activite_dispo(AD_id_logement, AD_id_activite, eloignement)
VALUES (15, 2, 'Moins de 5 km');
INSERT INTO activite_dispo(AD_id_logement, AD_id_activite, eloignement)
VALUES (19, 2, 'Moins de 15 km');

INSERT INTO activite_dispo(AD_id_logement, AD_id_activite, eloignement)
VALUES (2, 4, 'Moins de 15 km');
INSERT INTO activite_dispo(AD_id_logement, AD_id_activite, eloignement)
VALUES (4, 4, 'Moins de 20 km');
INSERT INTO activite_dispo(AD_id_logement, AD_id_activite, eloignement)
VALUES (14, 4, '20km et plus');
INSERT INTO activite_dispo(AD_id_logement, AD_id_activite, eloignement)
VALUES (9, 4, 'Moins de 5 km');

INSERT INTO activite_dispo(AD_id_logement, AD_id_activite, eloignement)
VALUES (10, 5, 'Moins de 15km');
INSERT INTO activite_dispo(AD_id_logement, AD_id_activite, eloignement)
VALUES (11, 5, 'Sur place');

INSERT INTO activite_dispo(AD_id_logement, AD_id_activite, eloignement)
VALUES (6, 6, '20 km et plus');
INSERT INTO activite_dispo(AD_id_logement, AD_id_activite, eloignement)
VALUES (16, 6, 'Moins de 5 km');
INSERT INTO activite_dispo(AD_id_logement, AD_id_activite, eloignement)
VALUES (12, 6, 'Moins de 10 km');

INSERT INTO activite_dispo(AD_id_logement, AD_id_activite, eloignement)
VALUES (7, 7, 'Sur place');
INSERT INTO activite_dispo(AD_id_logement, AD_id_activite, eloignement)
VALUES (8, 7, 'Moins de 5 km');
INSERT INTO activite_dispo(AD_id_logement, AD_id_activite, eloignement)
VALUES (19, 7, 'Moins de 15 km');


INSERT INTO numero_telephone(numero_tel, prefixe, id_compte)
VALUES ('0612345678','+33', 1);
INSERT INTO numero_telephone(numero_tel, prefixe, id_compte)
VALUES ('0623456789','+33', 2);
INSERT INTO numero_telephone(numero_tel, prefixe, id_compte)
VALUES ('0634567890','+33', 3);
INSERT INTO numero_telephone(numero_tel, prefixe, id_compte)
VALUES ('0645678901','+33', 3);
INSERT INTO numero_telephone(numero_tel, prefixe, id_compte)
VALUES ('0656789012','+33', 4);
INSERT INTO numero_telephone(numero_tel, prefixe, id_compte)
VALUES ('0667890123','+33', 5);
INSERT INTO numero_telephone(numero_tel, prefixe, id_compte)
VALUES ('0678901234','+33', 5);
INSERT INTO numero_telephone(numero_tel, prefixe, id_compte)
VALUES ('2025550143','+1', 6);
INSERT INTO numero_telephone(numero_tel, prefixe, id_compte)
VALUES ('2125550198','+1', 6);






INSERT INTO langue_parlee(LP_id_compte, LP_id_langue)
VALUES (7,1);
INSERT INTO langue_parlee(LP_id_compte, LP_id_langue)
VALUES (8,1);
INSERT INTO langue_parlee(LP_id_compte, LP_id_langue)
VALUES (9,1);
INSERT INTO langue_parlee(LP_id_compte, LP_id_langue)
VALUES (10,1);
INSERT INTO langue_parlee(LP_id_compte, LP_id_langue)
VALUES (11,1);

INSERT INTO langue_parlee(LP_id_compte, LP_id_langue)
VALUES (7,2);
INSERT INTO langue_parlee(LP_id_compte, LP_id_langue)
VALUES (9,2);

INSERT INTO langue_parlee(LP_id_compte, LP_id_langue)
VALUES (7,3);
INSERT INTO langue_parlee(LP_id_compte, LP_id_langue)
VALUES (8,3);
INSERT INTO langue_parlee(LP_id_compte, LP_id_langue)
VALUES (9,3);

INSERT INTO langue_parlee(LP_id_compte, LP_id_langue)
VALUES (9,4);

INSERT INTO langue_parlee(LP_id_compte, LP_id_langue)
VALUES (10,5);
INSERT INTO langue_parlee(LP_id_compte, LP_id_langue)
VALUES (11,5);

INSERT INTO langue_parlee(LP_id_compte, LP_id_langue)
VALUES (9,6);
INSERT INTO langue_parlee(LP_id_compte, LP_id_langue)
VALUES (10,6);


INSERT INTO langue_parlee(LP_id_compte, LP_id_langue)
VALUES (8,7);
INSERT INTO langue_parlee(LP_id_compte, LP_id_langue)
VALUES (11,7);

INSERT INTO langue_parlee(LP_id_compte, LP_id_langue)
VALUES (8,8);

INSERT INTO langue_parlee(LP_id_compte, LP_id_langue)
VALUES (10,9);

INSERT INTO amenagements_logement(al_id_logement, al_id_amenagement)
VALUES (1,1);
INSERT INTO amenagements_logement(al_id_logement, al_id_amenagement)
VALUES (2,1);
INSERT INTO amenagements_logement(al_id_logement, al_id_amenagement)
VALUES (10,1);
INSERT INTO amenagements_logement(al_id_logement, al_id_amenagement)
VALUES (5,1);

INSERT INTO amenagements_logement(al_id_logement, al_id_amenagement)
VALUES (3,2);
INSERT INTO amenagements_logement(al_id_logement, al_id_amenagement)
VALUES (4,2);
INSERT INTO amenagements_logement(al_id_logement, al_id_amenagement)
VALUES (12,2);

INSERT INTO amenagements_logement(al_id_logement, al_id_amenagement)
VALUES (2,3);
INSERT INTO amenagements_logement(al_id_logement, al_id_amenagement)
VALUES (5,3);
INSERT INTO amenagements_logement(al_id_logement, al_id_amenagement)
VALUES (14,3);
INSERT INTO amenagements_logement(al_id_logement, al_id_amenagement)
VALUES (17,3);

INSERT INTO amenagements_logement(al_id_logement, al_id_amenagement)
VALUES (1,4);
INSERT INTO amenagements_logement(al_id_logement, al_id_amenagement)
VALUES (3,4);
INSERT INTO amenagements_logement(al_id_logement, al_id_amenagement)
VALUES (4,4);
INSERT INTO amenagements_logement(al_id_logement, al_id_amenagement)
VALUES (13,4);
INSERT INTO amenagements_logement(al_id_logement, al_id_amenagement)
VALUES (18,4);

INSERT INTO amenagements_logement(al_id_logement, al_id_amenagement)
VALUES (7,5);
INSERT INTO amenagements_logement(al_id_logement, al_id_amenagement)
VALUES (8,5);
INSERT INTO amenagements_logement(al_id_logement, al_id_amenagement)
VALUES (11,5);

INSERT INTO cle_api(cle, c_id_proprio)
VALUES ('769a4ba84b6b8d63d9364242ddc3f4b1f0e755580090b6015c56729a7dfe4c7f', 7);
VALUES ('0df3bf12328fbd6511b21db218c2f2cb708fda6d2a1571fa56484681f9a7e98a', 8);
VALUES ('59e4c3ba79fa4af1549347fd9a471d36e96e5a67f99e83acdfdd64618ff50fcd', 9);


