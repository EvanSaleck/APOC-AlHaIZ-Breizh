DROP SCHEMA IF EXISTS sae3 CASCADE;
CREATE SCHEMA sae3;
SET SCHEMA 'sae3';

CREATE TABLE adresse (
   id_adresse serial,
   numero_rue integer,
   nom_rue varchar(80) NOT NULL,
   code_postal varchar(10) NOT NULL,
   nom_ville varchar(60) NOT NULL,
   pays varchar(60) NOT NULL,
   complement varchar(60),
   etat varchar(60),

   CONSTRAINT adresse_pk 
   PRIMARY KEY (id_adresse)
);

CREATE TABLE compte (
   id_compte serial,
   civilite varchar(15),
   nom varchar(70) NOT NULL,
   prenom varchar(70) NOT NULL,
   e_mail varchar(120) NOT NULL,
   mdp varchar(50) NOT NULL,
   pseudo varchar(50) NOT NULL,
   photo_profil varchar(150),
   ddn date NOT NULL,
   C_id_adresse integer NOT NULL,

   CONSTRAINT compte_pk 
   PRIMARY KEY (id_compte),
   CONSTRAINT compte_adresse_fk 
   FOREIGN KEY (C_id_adresse) REFERENCES adresse(id_adresse)
);

CREATE TABLE compte_proprietaire(
   id_proprietaire serial,
   identite varchar(150) NOT NULL,
   date_cni_fin_valid date NOT NULL,
   est_valide boolean NOT NULL,

   CONSTRAINT compte_proprietaire_pk 
      PRIMARY KEY (id_proprietaire),
   CONSTRAINT heritage_compte_proprietaire_fk
   FOREIGN KEY (id_proprietaire) REFERENCES compte(id_compte) 
);

CREATE TABLE compte_client (
   id_client serial,
   code_client varchar(50) NOT NULL,
   CC_id_adresse integer NOT NULL,

   CONSTRAINT compte_client_pk 
   PRIMARY KEY (id_client),
   CONSTRAINT compte_client_adresse_fk 
   FOREIGN KEY (CC_id_adresse) REFERENCES adresse(id_adresse),
   CONSTRAINT heritage_compte_client_fk 
   FOREIGN KEY (id_client) REFERENCES compte(id_compte) 
);

CREATE TABLE numero_telephone (
   numero_tel varchar(10) NOT NULL,
   prefixe varchar(5) NOT NULL,
   NT_id_compte integer NOT NULL,

   CONSTRAINT numero_telephone_pk 
   PRIMARY KEY (prefixe, numero_tel),
   CONSTRAINT numero_telephone_compte_fk
   FOREIGN KEY (NT_id_compte) REFERENCES compte(id_compte)
);

CREATE TABLE langue (
   id_langue serial,
   nom_langue varchar(60) NOT NULL,

   CONSTRAINT langue_pk
   PRIMARY KEY (id_langue)
);

CREATE TABLE langue_parlee (
   LP_id_proprietaire integer NOT NULL,
   LP_id_langue integer NOT NULL,

   CONSTRAINT langue_parlee_pk
   PRIMARY KEY (LP_id_langue,LP_id_proprietaire),
   CONSTRAINT langue_parlee_fk1
   FOREIGN KEY (LP_id_proprietaire) REFERENCES compte_proprietaire(id_proprietaire),
   CONSTRAINT langue_parlee_fk2
   FOREIGN KEY (LP_id_langue) REFERENCES langue(id_langue)
);

CREATE TABLE type_logement (
   id_type serial,
   nom_type varchar(40) NOT NULL,

   CONSTRAINT type_logement_pk
   PRIMARY KEY (id_type)
);

CREATE TABLE categorie_logement (
   id_categorie serial,
   nom_categorie varchar(40) NOT NULL,

   CONSTRAINT categorie_logement_pk
   PRIMARY KEY (id_categorie)
);

CREATE TABLE logement (
   id_logement serial,
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
   L_id_proprietaire integer NOT NULL,
   L_id_type integer NOT NULL,
   L_id_categorie integer NOT NULL,

   CONSTRAINT logement_pk 
   PRIMARY KEY (id_logement),
   CONSTRAINT logement_adresse_fk 
   FOREIGN KEY (L_id_adresse) REFERENCES adresse(id_adresse),
   CONSTRAINT logement_compte_proprietaire_fk 
   FOREIGN KEY (L_id_proprietaire) REFERENCES compte_proprietaire(id_proprietaire),
   CONSTRAINT logement_type_logement_fk 
   FOREIGN KEY (L_id_type) REFERENCES type_logement(id_type),
   CONSTRAINT logement_categorie_logement_fk 
   FOREIGN KEY (L_id_categorie) REFERENCES categorie_logement(id_categorie)
);

CREATE TABLE amenagement (
   id_amenagement serial,
   nom_amenagement varchar(40),

   CONSTRAINT amenagement_pk 
   PRIMARY KEY (id_amenagement)
);

CREATE TABLE amenagements_logement (
   AL_id_logement integer,
   AL_id_amenagement integer,
   
   CONSTRAINT amenagements_logement_pk
   PRIMARY KEY (AL_id_logement,AL_id_amenagement),
   CONSTRAINT amenagements_logement_fk1
   FOREIGN KEY (AL_id_logement) REFERENCES logement(id_logement),
   CONSTRAINT amenagements_logement_fk2
   FOREIGN KEY (AL_id_amenagement) REFERENCES amenagement(id_amenagement)
);

CREATE TABLE reservation (
   id_reservation serial,
   nb_nuit integer,
   date_arrivee date,
   date_depart date,
   nb_occupant integer,
   total_tarif_ttc decimal(10, 2),
   frais_service decimal(10, 2),
   taxe_sejour decimal (10, 2) GENERATED ALWAYS AS (nb_occupant * nb_nuit) STORED,
   tarif_total decimal(10, 2),
   date_reservation date,
   en_annulation boolean,
   R_id_logement integer,
   R_id_client integer,

   CONSTRAINT reservation_pk 
   PRIMARY KEY (id_reservation),
   CONSTRAINT reservation_logement_fk 
   FOREIGN KEY (R_id_logement) REFERENCES logement(id_logement),
   CONSTRAINT reservation_compte_client_fk 
   FOREIGN KEY (R_id_client) REFERENCES compte_client(id_client)
);

CREATE TABLE activite (
   id_activite serial,
   nom_activite varchar(70),

   CONSTRAINT activite_pk 
   PRIMARY KEY (id_activite)
   );

   CREATE TABLE activite_dispo (
   AD_id_logement integer,
   AD_id_activite integer,
   eloignement varchar(50),

   CONSTRAINT activite_dispo_pk 
   PRIMARY KEY (AD_id_logement, AD_id_activite),
   CONSTRAINT activite_dispo_logement_fk 
   FOREIGN KEY (AD_id_logement) REFERENCES logement(id_logement),
   CONSTRAINT activite_dispo_activites_fk
   FOREIGN KEY (AD_id_activite) REFERENCES activite(id_activite)
);

CREATE TABLE avis (
   id_avis serial,
   note_avis integer,
   commentaire varchar(150),
   AV_id_reservation integer,

   CONSTRAINT avis_pk 
   PRIMARY KEY (id_avis),
   CONSTRAINT avis_reservation_fk 
   FOREIGN KEY (AV_id_reservation) REFERENCES reservation(id_reservation)
);
