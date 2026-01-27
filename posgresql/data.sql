-- ----------------------------------------------------------
-- Jeu de test BDD
-- ----------------------------------------------------------

-- ----------------------------
-- Table: pays
-- ----------------------------
INSERT INTO pays (nom_pays, nb_hbts_pays, pib_pays, monnaie_pays, taux_de_change_pays, langue_pays, capitale_pays) VALUES
('France', 67000000, 2930000, 'Euro', 1.0, 'Français', 'Paris'),
('États-Unis', 331000000, 21430000, 'Dollar', 1.08, 'Anglais', 'Washington'),
('Allemagne', 83000000, 3846000, 'Euro', 1.0, 'Allemand', 'Berlin'),
('Japon', 125800000, 5082000, 'Yen', 142.0, 'Japonais', 'Tokyo'),
('Canada', 38000000, 1937000, 'Dollar canadien', 1.44, 'Anglais/Français', 'Ottawa');

-- ----------------------------
-- Table: user
-- ----------------------------
INSERT INTO user (id_user, nom_user, mail_user, mdp_user, date_nais_user) VALUES
(1, 'Alice Dupont', 'alice.dupont@email.com', 'mdpAlice123', '1995-06-12'),
(2, 'Bob Martin', 'bob.martin@email.com', 'mdpBob456', '1990-11-03'),
(3, 'Carla Silva', 'carla.silva@email.com', 'mdpCarla789', '1998-02-25'),
(4, 'David Nguyen', 'david.nguyen@email.com', 'mdpDavid321', '1985-09-17'),
(5, 'Emma Rossi', 'emma.rossi@email.com', 'mdpEmma654', '1992-12-08');

-- ----------------------------
-- Table: entreprise
-- ----------------------------
INSERT INTO entreprise (id_national_entreprise, nom_entreprise, nb_employes_entreprise, secteur_activite_entreprise, pays_entreprise, nom_pays) VALUES
(101, 'TechNova', 500, 'Informatique', 'France', 'France'),
(102, 'GreenEnergy', 1200, 'Énergie renouvelable', 'Allemagne', 'Allemagne'),
(103, 'Foodies Inc', 300, 'Agroalimentaire', 'États-Unis', 'États-Unis'),
(104, 'AutoMakers', 15000, 'Automobile', 'Japon', 'Japon'),
(105, 'MapleTech', 450, 'Informatique', 'Canada', 'Canada');

-- ----------------------------
-- Table: stage
-- ----------------------------
INSERT INTO stage (id_stage, id_national_entreprise_stage, date_publication_stage, date_debut_stage, duree_jours_stage, id_national_entreprise) VALUES
(1001, '101', '2026-01-15', '2026-02-01', 90, 101),
(1002, '102', '2026-01-20', '2026-03-01', 120, 102),
(1003, '103', '2026-01-18', '2026-02-15', 60, 103),
(1004, '104', '2026-01-25', '2026-03-10', 180, 104),
(1005, '105', '2026-01-22', '2026-02-20', 75, 105);
