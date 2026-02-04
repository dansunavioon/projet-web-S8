-- ----------------------------------------------------------
-- Jeu de test PostgreSQL pour la base de données
-- ----------------------------------------------------------

-- ----------------------------------------------------------
-- Vider les tables pour un nouveau jeu de test (PostgreSQL)
-- ----------------------------------------------------------
TRUNCATE TABLE stage RESTART IDENTITY CASCADE;
TRUNCATE TABLE entreprise RESTART IDENTITY CASCADE;
TRUNCATE TABLE pays RESTART IDENTITY CASCADE;
TRUNCATE TABLE utilisateur RESTART IDENTITY CASCADE;

-- ----------------------------
-- Table: utilisateur
-- ----------------------------
INSERT INTO utilisateur (nom_user, mail_user, mdp_user, date_nais_user) VALUES
('Alice Dupont', 'alice.dupont@email.com', 'mdpAlice123', '1995-06-12'),
('Bob Martin', 'bob.martin@email.com', 'mdpBob456', '1990-11-03'),
('Carla Silva', 'carla.silva@email.com', 'mdpCarla789', '1998-02-25'),
('David Nguyen', 'david.nguyen@email.com', 'mdpDavid321', '1985-09-17'),
('Emma Rossi', 'emma.rossi@email.com', 'mdpEmma654', '1992-12-08');

-- ----------------------------------------------------------
-- Jeu de test PostgreSQL pour la base de données (grande échelle)
-- ----------------------------------------------------------

-- ----------------------------
-- Table: pays
-- ----------------------------
INSERT INTO pays (nom_pays, nb_hbts_pays, pib_pays, monnaie_pays, taux_de_change_pays, langue_pays, capitale_pays) VALUES
('France', 67000000, 2930000, 'Euro', 1.0, 'Français', 'Paris'),
('États-Unis', 331000000, 21430000, 'Dollar', 1.08, 'Anglais', 'Washington'),
('Allemagne', 83000000, 3846000, 'Euro', 1.0, 'Allemand', 'Berlin'),
('Japon', 125800000, 5082000, 'Yen', 142.0, 'Japonais', 'Tokyo'),
('Canada', 38000000, 1937000, 'Dollar canadien', 1.44, 'Anglais/Français', 'Ottawa'),
('Brésil', 213000000, 1445000, 'Real', 5.2, 'Portugais', 'Brasília'),
('Chine', 1412000000, 16930000, 'Yuan', 7.0, 'Chinois', 'Pékin'),
('Inde', 1393000000, 2875000, 'Roupie', 90.0, 'Hindi/Anglais', 'New Delhi'),
('Australie', 25600000, 1393000, 'Dollar australien', 1.6, 'Anglais', 'Canberra'),
('Russie', 146000000, 1699000, 'Rouble', 90.0, 'Russe', 'Moscou'),
('Royaume-Uni', 68000000, 3100000, 'Livre sterling', 0.88, 'Anglais', 'Londres'),
('Italie', 60000000, 2074000, 'Euro', 1.0, 'Italien', 'Rome'),
('Espagne', 47000000, 1400000, 'Euro', 1.0, 'Espagnol', 'Madrid'),
('Mexique', 128000000, 1260000, 'Peso', 21.0, 'Espagnol', 'Mexico'),
('Pays-Bas', 17400000, 991000, 'Euro', 1.0, 'Néerlandais', 'Amsterdam'),
('Belgique', 11500000, 616000, 'Euro', 1.0, 'Français/Néerlandais/Allemand', 'Bruxelles'),
('Suède', 10300000, 627000, 'Couronne suédoise', 11.0, 'Suédois', 'Stockholm'),
('Norvège', 5400000, 536000, 'Couronne norvégienne', 11.0, 'Norvégien', 'Oslo'),
('Suisse', 8600000, 824000, 'Franc suisse', 1.0, 'Allemand/Français/Italien', 'Berne'),
('Autriche', 8900000, 480000, 'Euro', 1.0, 'Allemand', 'Vienne'),
('Pologne', 38000000, 680000, 'Zloty', 4.7, 'Polonais', 'Varsovie'),
('Irlande', 5000000, 520000, 'Euro', 1.0, 'Anglais', 'Dublin'),
('Portugal', 10200000, 270000, 'Euro', 1.0, 'Portugais', 'Lisbonne'),
('Grèce', 10700000, 250000, 'Euro', 1.0, 'Grec', 'Athènes'),
('Hongrie', 9700000, 210000, 'Forint', 386.0, 'Hongrois', 'Budapest'),
('République tchèque', 10700000, 270000, 'Couronne tchèque', 24.0, 'Tchèque', 'Prague'),
('Finlande', 5500000, 300000, 'Euro', 1.0, 'Finnois/Swedish', 'Helsinki'),
('Danemark', 5800000, 410000, 'Couronne danoise', 7.5, 'Danois', 'Copenhague'),
('Singapour', 5700000, 540000, 'Dollar singapourien', 1.45, 'Anglais/Malais', 'Singapour'),
('Corée du Sud', 51800000, 1800000, 'Won', 1350.0, 'Coréen', 'Séoul'),
('Nouvelle-Zélande', 5100000, 250000, 'Dollar néo-zélandais', 1.7, 'Anglais/Maori', 'Wellington'),
('Argentine', 45100000, 500000, 'Peso', 210.0, 'Espagnol', 'Buenos Aires'),
('Afrique du Sud', 60000000, 350000, 'Rand', 18.0, 'Anglais/Afrikaans', 'Pretoria'),
('Turquie', 84000000, 815000, 'Livre turque', 23.0, 'Turc', 'Ankara'),
('Arabie Saoudite', 34800000, 833000, 'Riyal', 4.0, 'Arabe', 'Riyad'),
('Émirats Arabes Unis', 9890000, 421000, 'Dirham', 3.67, 'Arabe', 'Abou Dabi'),
('Thaïlande', 70000000, 505000, 'Baht', 36.5, 'Thaï', 'Bangkok'),
('Malaisie', 32700000, 397000, 'Ringgit', 4.8, 'Malais', 'Kuala Lumpur'),
('Indonésie', 273000000, 1119000, 'Roupie indonésienne', 15600.0, 'Indonésien', 'Jakarta'),
('Philippines', 109000000, 402000, 'Peso', 56.0, 'Tagalog', 'Manille');

-- ----------------------------
-- Table: entreprise
-- ----------------------------
INSERT INTO entreprise (nom_entreprise, nb_employes_entreprise, secteur_activite_entreprise, nom_pays) VALUES
('TechNova', 500, 'Informatique', 'France'),
('GreenEnergy', 1200, 'Énergie renouvelable', 'Allemagne'),
('Foodies Inc', 300, 'Agroalimentaire', 'États-Unis'),
('AutoMakers', 15000, 'Automobile', 'Japon'),
('MapleTech', 450, 'Informatique', 'Canada'),
('SolarSolutions', 900, 'Énergie solaire', 'Brésil'),
('Dragon Electronics', 7000, 'Électronique', 'Chine'),
('Infosys Global', 2500, 'Informatique', 'Inde'),
('AussieTech', 800, 'Informatique', 'Australie'),
('RusOil', 12000, 'Pétrole', 'Russie'),
('BritSoft', 600, 'Logiciel', 'Royaume-Uni'),
('ItalFood', 500, 'Agroalimentaire', 'Italie'),
('IberiaAir', 15000, 'Transport aérien', 'Espagne'),
('DutchLogistics', 2000, 'Transport', 'Pays-Bas'),
('BelgiumTech', 700, 'Informatique', 'Belgique'),
('SwedeSolutions', 550, 'Informatique', 'Suède'),
('NorwayEnergy', 650, 'Énergie', 'Norvège'),
('SwissFinance', 1200, 'Finance', 'Suisse'),
('ViennaConsult', 300, 'Conseil', 'Autriche'),
('PolishFoods', 400, 'Agroalimentaire', 'Pologne'),
('IrishTech', 350, 'Informatique', 'Irlande'),
('PortoTech', 500, 'Informatique', 'Portugal'),
('AthensServices', 300, 'Services', 'Grèce'),
('BudapestSolutions', 250, 'Informatique', 'Hongrie'),
('PragueSoft', 400, 'Logiciel', 'République tchèque'),
('HelsinkiTech', 200, 'Informatique', 'Finlande'),
('CopenhagenLog', 300, 'Transport', 'Danemark'),
('SingaporeGlobal', 600, 'Finance', 'Singapour'),
('SeoulElectronics', 7000, 'Électronique', 'Corée du Sud'),
('NZTech', 250, 'Informatique', 'Nouvelle-Zélande'),
('ArgFood', 500, 'Agroalimentaire', 'Argentine'),
('SAEnergy', 1200, 'Énergie', 'Afrique du Sud'),
('TurkTextiles', 800, 'Textile', 'Turquie'),
('SaudiPetro', 9000, 'Pétrole', 'Arabie Saoudite'),
('UAEFinance', 400, 'Finance', 'Émirats Arabes Unis'),
('ThaiFoods', 700, 'Agroalimentaire', 'Thaïlande'),
('MalaysiaTech', 600, 'Informatique', 'Malaisie'),
('IndoFoods', 1200, 'Agroalimentaire', 'Indonésie'),
('PhilippineLog', 500, 'Logistique', 'Philippines'),
('GlobalServices', 850, 'Services numériques', 'France');

-- ----------------------------
-- Table: stage (avec description)
-- ----------------------------
-- On suppose que les IDs des entreprises générées vont de 1 à 40
INSERT INTO stage (date_publication_stage, date_debut_stage, duree_jours_stage, id_national_entreprise, description_stage) VALUES
('2026-01-01','2026-02-01',90,1,'Développement d’une application web pour la gestion interne'),
('2026-01-02','2026-02-05',60,2,'Analyse de données pour un projet de panneaux solaires'),
('2026-01-03','2026-02-10',120,3,'Stage en production agroalimentaire et contrôle qualité'),
('2026-01-04','2026-03-01',180,4,'Participation à la conception d’un nouveau modèle de voiture électrique'),
('2026-01-05','2026-02-15',75,5,'Développement d’outils informatiques internes'),
('2026-01-06','2026-03-05',90,6,'Étude de marché pour projets solaires au Brésil'),
('2026-01-07','2026-03-10',60,7,'Assistance à la production de composants électroniques'),
('2026-01-08','2026-04-01',120,8,'Support au développement logiciel et maintenance de systèmes'),
('2026-01-09','2026-04-15',180,9,'Développement et optimisation de solutions logicielles'),
('2026-01-10','2026-05-01',75,10,'Analyse de données et reporting financier'),
('2026-01-11','2026-02-20',90,11,'Développement d’une application mobile pour le marché britannique'),
('2026-01-12','2026-03-10',60,12,'Stage en production agroalimentaire italienne'),
('2026-01-13','2026-03-25',120,13,'Support logistique pour transport aérien Espagne'),
('2026-01-14','2026-04-05',180,14,'Optimisation de la chaîne logistique aux Pays-Bas'),
('2026-01-15','2026-04-10',75,15,'Développement d’une application pour clients B2B'),
('2026-01-16','2026-04-20',90,16,'Stage R&D sur énergies renouvelables en Suède'),
('2026-01-17','2026-05-01',60,17,'Audit énergétique pour projets norvégiens'),
('2026-01-18','2026-05-10',120,18,'Analyse financière et reporting pour clients suisses'),
('2026-01-19','2026-05-15',180,19,'Consulting et support en gestion d’entreprise à Vienne'),
('2026-01-20','2026-06-01',75,20,'Amélioration de la production agroalimentaire en Pologne'),
('2026-01-21','2026-06-10',90,21,'Développement logiciel pour PME irlandaises'),
('2026-01-22','2026-06-15',60,22,'Projet informatique pour start-up portugaise'),
('2026-01-23','2026-06-20',120,23,'Support aux services clients à Athènes'),
('2026-01-24','2026-06-25',180,24,'Développement d’un logiciel interne en Hongrie'),
('2026-01-25','2026-07-01',75,25,'Développement de modules logiciels à Prague'),
('2026-01-26','2026-07-05',90,26,'Stage en informatique et automatisation à Helsinki'),
('2026-01-27','2026-07-10',60,27,'Optimisation de la logistique danoise'),
('2026-01-28','2026-07-15',120,28,'Projet financier et gestion de données à Singapour'),
('2026-01-29','2026-07-20',180,29,'Assistance technique en électronique à Séoul'),
('2026-01-30','2026-07-25',75,30,'Développement de logiciels pour PME en Nouvelle-Zélande'),
('2026-01-31','2026-08-01',90,31,'Stage production agroalimentaire Argentine'),
('2026-02-01','2026-08-05',60,32,'Projet énergétique Afrique du Sud'),
('2026-02-02','2026-08-10',120,33,'Stage dans le textile en Turquie'),
('2026-02-03','2026-08-15',180,34,'Optimisation de la production pétrolière Arabie Saoudite'),
('2026-02-04','2026-08-20',75,35,'Projet financier et audit UAE'),
('2026-02-05','2026-08-25',90,36,'Développement de solutions agroalimentaires en Thaïlande'),
('2026-02-06','2026-08-30',60,37,'Stage IT et développement logiciel Malaisie'),
('2026-02-07','2026-09-05',120,38,'Optimisation des processus agroalimentaires Indonésie'),
('2026-02-08','2026-09-10',180,39,'Stage logistique aux Philippines'),
('2026-02-09','2026-09-15',75,40,'Développement d’une application interne pour l’entreprise 40'),
('2026-02-10','2026-09-20',60,1,'Support technique sur projet web interne'),
('2026-02-11','2026-09-25',90,2,'Analyse de performance des panneaux solaires'),
('2026-02-12','2026-10-01',120,3,'Stage en production et sécurité alimentaire'),
('2026-02-13','2026-10-05',180,4,'Développement de prototype automobile'),
('2026-02-14','2026-10-10',75,5,'Maintenance d’outils informatiques internes'),
('2026-02-15','2026-10-15',90,6,'Étude d’impact environnemental projet solaire'),
('2026-02-16','2026-10-20',60,7,'Contrôle qualité composants électroniques'),
('2026-02-17','2026-10-25',120,8,'Développement logiciel et tests unitaires'),
('2026-02-18','2026-10-30',180,9,'Optimisation des systèmes informatiques'),
('2026-02-19','2026-11-05',75,10,'Reporting et analyse financière'),
('2026-02-20','2026-11-10',90,11,'Création d’applications mobiles B2B'),
('2026-02-21','2026-11-15',60,12,'Stage production agroalimentaire italienne'),
('2026-02-22','2026-11-20',120,13,'Optimisation logistique transport Espagne'),
('2026-02-23','2026-11-25',180,14,'Amélioration chaîne logistique'),
('2026-02-24','2026-11-30',75,15,'Développement appli B2B'),
('2026-02-25','2026-12-05',90,16,'R&D sur énergies renouvelables'),
('2026-02-26','2026-12-10',60,17,'Audit énergétique projet norvégien'),
('2026-02-27','2026-12-15',120,18,'Analyse financière clients Suisse'),
('2026-02-28','2026-12-20',180,19,'Consulting et gestion d’entreprise'),
('2026-02-28','2026-12-25',75,20,'Amélioration production agroalimentaire Pologne'),
('2026-03-01','2027-01-01',90,21,'Développement logiciel PME irlandaises'),
('2026-03-02','2027-01-05',60,22,'Projet informatique start-up Portugal'),
('2026-03-03','2027-01-10',120,23,'Support services clients Grèce'),
('2026-03-04','2027-01-15',180,24,'Développement logiciel interne Hongrie'),
('2026-03-05','2027-01-20',75,25,'Développement modules logiciels Prague'),
('2026-03-06','2027-01-25',90,26,'Informatique et automatisation Helsinki'),
('2026-03-07','2027-01-30',60,27,'Optimisation logistique Danemark'),
('2026-03-08','2027-02-05',120,28,'Projet financier et gestion données Singapour'),
('2026-03-09','2027-02-10',180,29,'Assistance technique électronique Séoul'),
('2026-03-10','2027-02-15',75,30,'Développement logiciels PME Nouvelle-Zélande');
