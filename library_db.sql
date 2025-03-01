-- Création de la base de données
CREATE DATABASE IF NOT EXISTS library_db;
USE library_db;

-- Table structure for table `livres`
CREATE TABLE livres (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(30) DEFAULT NULL,
    auteur VARCHAR(30) DEFAULT NULL,
    categorie VARCHAR(30) DEFAULT NULL,
    status ENUM('disponible', 'non disponible') NOT NULL DEFAULT 'disponible',
    annee YEAR NOT NULL,
    image VARCHAR(255) NOT NULL
);

-- Table structure for table `utilisateurs`
CREATE TABLE utilisateurs (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    nom VARCHAR(20) NOT NULL,
    prenom VARCHAR(20) DEFAULT NULL,
    password VARCHAR(255) NOT NULL
);

-- Table structure for table `commentaires`
CREATE TABLE commentaires (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_livre INT(11) DEFAULT NULL,
    id_utilisateur INT(11) DEFAULT NULL,
    commentaire TEXT NOT NULL,
    date_publication DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY id_livre (id_livre),
    KEY id_utilisateur (id_utilisateur),
    CONSTRAINT commentaires_ibfk_1 FOREIGN KEY (id_livre) REFERENCES livres (id) ON DELETE CASCADE,
    CONSTRAINT commentaires_ibfk_2 FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs (id) ON DELETE CASCADE
);
