DROP SCHEMA IF EXISTS sae3 CASCADE;
CREATE SCHEMA sae3;
SET SCHEMA 'sae3';

CREATE TABLE adresse (
   id_adresse serial PRIMARY KEY,
   numero_rue integer,
   nom_rue varchar(80) NOT NULL,
   code_postal varchar(10) NOT NULL,
   nom_ville varchar(60) NOT NULL,
   pays varchar(60) NOT NULL,
   complement varchar(60),
   etat varchar(60)
);

CREATE TABLE compte (
   id_compte serial PRIMARY KEY,
   civilite varchar(15),
   nom varchar(70) NOT NULL,
   prenom varchar(70) NOT NULL,
   e_mail varchar(120) NOT NULL,
   mdp varchar(50) NOT NULL,
   pseudo varchar(50) NOT NULL,
   photo_profil varchar(150),
   ddn date NOT NULL,
   C_id_adresse integer NOT NULL,
   CONSTRAINT compte_adresse_fk 
      FOREIGN KEY (C_id_adresse) REFERENCES adresse(id_adresse)
);

CREATE TABLE compte_proprietaire (
   id_compte integer PRIMARY KEY,
   identite varchar(150) NOT NULL,
   date_cni_fin_valid date NOT NULL,
   est_valide boolean NOT NULL
) INHERITS (compte);

CREATE TABLE compte_client (
   id_compte integer PRIMARY KEY,
   code_client varchar(50) NOT NULL,
   CC_id_adresse integer NOT NULL,
   CONSTRAINT compte_client_adresse_fk 
      FOREIGN KEY (CC_id_adresse) REFERENCES adresse(id_adresse)
) INHERITS (compte);

CREATE TABLE numero_telephone (
   numero_tel varchar(10) NOT NULL,
   prefixe varchar(5) NOT NULL,
   id_compte integer NOT NULL,
   CONSTRAINT numero_telephone_pk 
      PRIMARY KEY (prefixe, numero_tel)
);

CREATE TABLE langue (
   id_langue serial PRIMARY KEY,
   nom_langue varchar(60) NOT NULL
);

CREATE TABLE langue_parlee (
   LP_id_compte integer NOT NULL,
   LP_id_langue integer NOT NULL,
   CONSTRAINT langue_parlee_pk
      PRIMARY KEY (LP_id_langue, LP_id_compte),
   CONSTRAINT langue_parlee_fk1
      FOREIGN KEY (LP_id_compte) REFERENCES compte_proprietaire(id_compte),
   CONSTRAINT langue_parlee_fk2
      FOREIGN KEY (LP_id_langue) REFERENCES langue(id_langue)
);

CREATE TABLE type_logement (
   id_type serial PRIMARY KEY,
   nom_type varchar(40) NOT NULL
);

CREATE TABLE categorie_logement (
   id_categorie serial PRIMARY KEY,
   nom_categorie varchar(40) NOT NULL
);

CREATE TABLE logement (
   id_logement serial PRIMARY KEY,
   titre varchar(50) NOT NULL,
   accroche varchar(100),
   personnes_max integer NOT NULL,
   image_principale varchar(150),
   description varchar(200),
   latitude integer NOT NULL,
   longitude integer NOT NULL,
   surface_hab integer NOT NULL,
   nb_chambres integer NOT NULL,
   nb_lits_simples integer NOT NULL,
   nb_lits_doubles integer NOT NULL,
   prix_nuit_ht decimal(10,2) NOT NULL,
   prix_nuit_ttc decimal(10,2) GENERATED ALWAYS AS (prix_nuit_ht * 1.10) STORED,
   statut_propriete boolean NOT NULL,
   duree_min_location integer,
   avance_resa_min integer,
   delai_annul_max integer,
   L_id_adresse integer NOT NULL,
   L_id_compte integer NOT NULL,
   L_id_type integer NOT NULL,
   L_id_categorie integer NOT NULL,
   CONSTRAINT logement_adresse_fk 
      FOREIGN KEY (L_id_adresse) REFERENCES adresse(id_adresse),
   CONSTRAINT logement_compte_proprietaire_fk 
      FOREIGN KEY (L_id_compte) REFERENCES compte_proprietaire(id_compte),
   CONSTRAINT logement_type_logement_fk 
      FOREIGN KEY (L_id_type) REFERENCES type_logement(id_type),
   CONSTRAINT logement_categorie_logement_fk 
      FOREIGN KEY (L_id_categorie) REFERENCES categorie_logement(id_categorie)
);

CREATE TABLE amenagement (
   id_amenagement serial PRIMARY KEY,
   nom_amenagement varchar(40) NOT NULL
);

CREATE TABLE amenagements_logement (
   AL_id_logement integer NOT NULL,
   AL_id_amenagement integer NOT NULL,
   CONSTRAINT amenagements_logement_pk
      PRIMARY KEY (AL_id_logement, AL_id_amenagement),
   CONSTRAINT amenagements_logement_fk1
      FOREIGN KEY (AL_id_logement) REFERENCES logement(id_logement),
   CONSTRAINT amenagements_logement_fk2
      FOREIGN KEY (AL_id_amenagement) REFERENCES amenagement(id_amenagement)
);

CREATE TABLE reservation (
   id_reservation serial PRIMARY KEY,
   nb_nuit integer NOT NULL,
   date_arrivee date NOT NULL,
   date_depart date NOT NULL,
   nb_occupant integer NOT NULL,
   total_tarif_ttc decimal(10, 2),
   frais_service decimal(10, 2),
   taxe_sejour decimal (10, 2),
   tarif_total decimal(10, 2),
   date_reservation date NOT NULL,
   en_annulation boolean NOT NULL,
   R_id_logement integer NOT NULL,
   R_id_compte integer NOT NULL,
   CONSTRAINT reservation_logement_fk 
      FOREIGN KEY (R_id_logement) REFERENCES logement(id_logement),
   CONSTRAINT reservation_compte_client_fk 
      FOREIGN KEY (R_id_compte) REFERENCES compte_client(id_compte)
);

CREATE TABLE activite (
   id_activite serial PRIMARY KEY,
   nom_activite varchar(70) NOT NULL
);

CREATE TABLE activite_dispo (
   AD_id_logement integer NOT NULL,
   AD_id_activite integer NOT NULL,
   eloignement varchar(50) NOT NULL,
   CONSTRAINT activite_dispo_pk 
      PRIMARY KEY (AD_id_logement, AD_id_activite),
   CONSTRAINT activite_dispo_logement_fk 
      FOREIGN KEY (AD_id_logement) REFERENCES logement(id_logement),
   CONSTRAINT activite_dispo_activites_fk
      FOREIGN KEY (AD_id_activite) REFERENCES activite(id_activite)
);

CREATE TABLE avis (
   id_avis serial PRIMARY KEY,
   note_avis integer NOT NULL,
   commentaire varchar(150),
   AV_id_reservation integer NOT NULL,
   CONSTRAINT avis_reservation_fk 
      FOREIGN KEY (AV_id_reservation) REFERENCES reservation(id_reservation)
);
