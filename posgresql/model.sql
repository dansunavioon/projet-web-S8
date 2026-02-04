-- ----------------------------------------------------------
-- Suppression des tables (cascade PostgreSQL)
-- ----------------------------------------------------------
DROP TABLE IF EXISTS stage CASCADE;
DROP TABLE IF EXISTS entreprise CASCADE;
DROP TABLE IF EXISTS pays CASCADE;
DROP TABLE IF EXISTS utilisateur CASCADE;

-- ----------------------------------------------------------
-- Table: utilisateur
-- ----------------------------------------------------------
CREATE TABLE utilisateur (
  id_user INT GENERATED ALWAYS AS IDENTITY,
  nom_user VARCHAR(50) NOT NULL,
  mail_user VARCHAR(100) NOT NULL,
  mdp_user VARCHAR(100) NOT NULL,
  date_nais_user DATE NOT NULL,
  CONSTRAINT utilisateur_pk PRIMARY KEY (id_user)
);

-- ----------------------------------------------------------
-- Table: pays
-- ----------------------------------------------------------
CREATE TABLE pays (
  nom_pays VARCHAR(50) PRIMARY KEY,
  nb_hbts_pays INT NOT NULL,
  pib_pays INT NOT NULL,
  monnaie_pays VARCHAR(50) NOT NULL,
  taux_de_change_pays FLOAT NOT NULL,
  langue_pays VARCHAR(50) NOT NULL,
  capitale_pays VARCHAR(50) NOT NULL
);

-- ----------------------------------------------------------
-- Table: entreprise
-- ----------------------------------------------------------
CREATE TABLE entreprise (
  id_national_entreprise INT GENERATED ALWAYS AS IDENTITY,
  nom_entreprise VARCHAR(255) NOT NULL,
  nb_employes_entreprise INT NOT NULL,
  secteur_activite_entreprise VARCHAR(255) NOT NULL,
  nom_pays VARCHAR(50) NOT NULL,
  CONSTRAINT entreprise_pk PRIMARY KEY (id_national_entreprise),
  CONSTRAINT entreprise_nom_pays_fk 
    FOREIGN KEY (nom_pays)
    REFERENCES pays (nom_pays)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

-- ----------------------------------------------------------
-- Table: stage
-- ----------------------------------------------------------
CREATE TABLE stage (
  id_stage INT GENERATED ALWAYS AS IDENTITY,
  date_publication_stage DATE NOT NULL,
  date_debut_stage DATE NOT NULL,
  duree_jours_stage INT NOT NULL,
  id_national_entreprise INT NOT NULL,
  description_stage VARCHAR NOT NULL,
  CONSTRAINT stage_pk PRIMARY KEY (id_stage),
  CONSTRAINT stage_entreprise_fk
    FOREIGN KEY (id_national_entreprise)
    REFERENCES entreprise (id_national_entreprise)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);