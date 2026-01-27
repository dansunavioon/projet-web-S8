-- ----------------------------------------------------------
-- Suppression des tables (ordre inverse des dépendances)
-- ----------------------------------------------------------
DROP TABLE IF EXISTS stage;
DROP TABLE IF EXISTS entreprise;
DROP TABLE IF EXISTS pays;
DROP TABLE IF EXISTS user;

-- ----------------------------------------------------------
-- Table: user
-- ----------------------------------------------------------
CREATE TABLE user (
  id_user INT NOT NULL AUTO_INCREMENT,
  nom_user VARCHAR(50) NOT NULL,
  mail_user VARCHAR(100) NOT NULL,
  mdp_user VARCHAR(100) NOT NULL,
  date_nais_user DATE NOT NULL,
  CONSTRAINT user_PK PRIMARY KEY (id_user)
) ENGINE=InnoDB;

-- ----------------------------------------------------------
-- Table: pays
-- ----------------------------------------------------------
CREATE TABLE pays (
  nom_pays VARCHAR(50) NOT NULL,
  nb_hbts_pays INT NOT NULL,
  pib_pays INT NOT NULL,
  monnaie_pays VARCHAR(50) NOT NULL,
  taux_de_change_pays FLOAT NOT NULL,
  langue_pays VARCHAR(50) NOT NULL,
  capitale_pays VARCHAR(50) NOT NULL,
  CONSTRAINT pays_PK PRIMARY KEY (nom_pays)
) ENGINE=InnoDB;

-- ----------------------------------------------------------
-- Table: entreprise
-- ----------------------------------------------------------
CREATE TABLE entreprise (
  id_national_entreprise INT NOT NULL AUTO_INCREMENT,
  nom_entreprise VARCHAR(255) NOT NULL,
  nb_employes_entreprise INT NOT NULL,
  secteur_activite_entreprise VARCHAR(255) NOT NULL,
  nom_pays VARCHAR(50) NOT NULL,
  CONSTRAINT entreprise_PK PRIMARY KEY (id_national_entreprise),
  CONSTRAINT entreprise_nom_pays_FK 
    FOREIGN KEY (nom_pays) REFERENCES pays (nom_pays)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ----------------------------------------------------------
-- Table: stage
-- ----------------------------------------------------------
CREATE TABLE stage (
  id_stage INT NOT NULL AUTO_INCREMENT,
  date_publication_stage DATE NOT NULL,
  date_debut_stage DATE NOT NULL,
  duree_jours_stage INT NOT NULL,
  id_national_entreprise INT NOT NULL,
  CONSTRAINT stage_PK PRIMARY KEY (id_stage),
  CONSTRAINT stage_entreprise_FK 
    FOREIGN KEY (id_national_entreprise) 
    REFERENCES entreprise (id_national_entreprise)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB;
