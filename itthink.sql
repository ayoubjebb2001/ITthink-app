-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 20, 2024 at 10:42 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `itthink`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id_categorie` int NOT NULL,
  `nom_categorie` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id_categorie`, `nom_categorie`) VALUES
(1, 'Développement web'),
(2, 'Design graphique'),
(3, 'Marketing digital');

-- --------------------------------------------------------

--
-- Table structure for table `freelances`
--

CREATE TABLE `freelances` (
  `id_freelance` int NOT NULL,
  `nom_freelance` varchar(55) NOT NULL,
  `competences` text,
  `id_utilisateur` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offres`
--

CREATE TABLE `offres` (
  `id_offre` int NOT NULL,
  `montant` decimal(10,2) DEFAULT NULL,
  `delai` date DEFAULT NULL,
  `id_freelance` int NOT NULL,
  `id_projet` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projets`
--

CREATE TABLE `projets` (
  `id_projet` int NOT NULL,
  `titre_projet` varchar(55) NOT NULL,
  `descriptioon` text,
  `date_creation` date NOT NULL,
  `id_categorie` int NOT NULL,
  `id_sous_categorie` int NOT NULL,
  `id_utilisateur` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sous_categories`
--

CREATE TABLE `sous_categories` (
  `id_sous_categorie` int NOT NULL,
  `nom_sous_categorie` varchar(32) NOT NULL,
  `id_categorie` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sous_categories`
--

INSERT INTO `sous_categories` (`id_sous_categorie`, `nom_sous_categorie`, `id_categorie`) VALUES
(1, 'Frontend', 1),
(2, 'Backend', 1),
(3, 'UI/UX', 2),
(4, 'SEO', 3),
(5, 'Publicité', 3);

-- --------------------------------------------------------

--
-- Table structure for table `temoignages`
--

CREATE TABLE `temoignages` (
  `id_temoignage` int NOT NULL,
  `commentaire` text NOT NULL,
  `id_utilisateur` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id_utilisateur` int NOT NULL,
  `nom_utilisateur` varchar(50) NOT NULL,
  `mot_de_passe` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(50) NOT NULL,
  `role` enum('admin','user','freelancer') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `nom_utilisateur`, `mot_de_passe`, `email`, `role`) VALUES
(21, 'ayoub', '$2y$10$yBhFpMJPR7Ckhff0oV45KuF7UQR/l2OCgzyOPnV5gqcBXCc1D21Iq', 'jebbouri1968@gmail.com', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id_categorie`);

--
-- Indexes for table `freelances`
--
ALTER TABLE `freelances`
  ADD PRIMARY KEY (`id_freelance`),
  ADD KEY `fk_freelances_utilisateur` (`id_utilisateur`);

--
-- Indexes for table `offres`
--
ALTER TABLE `offres`
  ADD PRIMARY KEY (`id_offre`),
  ADD KEY `fk_offres_freelance` (`id_freelance`),
  ADD KEY `fk_offres_projet` (`id_projet`);

--
-- Indexes for table `projets`
--
ALTER TABLE `projets`
  ADD PRIMARY KEY (`id_projet`),
  ADD KEY `fk_projets_categorie` (`id_categorie`),
  ADD KEY `fk_projets_sous_categorie` (`id_sous_categorie`),
  ADD KEY `fk_projets_utilisateur` (`id_utilisateur`);

--
-- Indexes for table `sous_categories`
--
ALTER TABLE `sous_categories`
  ADD PRIMARY KEY (`id_sous_categorie`),
  ADD KEY `fk_sous_categories_categorie` (`id_categorie`);

--
-- Indexes for table `temoignages`
--
ALTER TABLE `temoignages`
  ADD PRIMARY KEY (`id_temoignage`),
  ADD KEY `fk_temoignages_utilisateur` (`id_utilisateur`);

--
-- Indexes for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id_utilisateur`),
  ADD UNIQUE KEY `nom_utilisateur` (`nom_utilisateur`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id_categorie` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `freelances`
--
ALTER TABLE `freelances`
  MODIFY `id_freelance` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `offres`
--
ALTER TABLE `offres`
  MODIFY `id_offre` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `projets`
--
ALTER TABLE `projets`
  MODIFY `id_projet` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sous_categories`
--
ALTER TABLE `sous_categories`
  MODIFY `id_sous_categorie` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `temoignages`
--
ALTER TABLE `temoignages`
  MODIFY `id_temoignage` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id_utilisateur` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `freelances`
--
ALTER TABLE `freelances`
  ADD CONSTRAINT `fk_freelances_utilisateur` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `offres`
--
ALTER TABLE `offres`
  ADD CONSTRAINT `fk_offres_freelance` FOREIGN KEY (`id_freelance`) REFERENCES `freelances` (`id_freelance`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_offres_projet` FOREIGN KEY (`id_projet`) REFERENCES `projets` (`id_projet`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `projets`
--
ALTER TABLE `projets`
  ADD CONSTRAINT `fk_projets_categorie` FOREIGN KEY (`id_categorie`) REFERENCES `categories` (`id_categorie`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_projets_sous_categorie` FOREIGN KEY (`id_sous_categorie`) REFERENCES `sous_categories` (`id_sous_categorie`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_projets_utilisateur` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sous_categories`
--
ALTER TABLE `sous_categories`
  ADD CONSTRAINT `fk_sous_categories_categorie` FOREIGN KEY (`id_categorie`) REFERENCES `categories` (`id_categorie`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `temoignages`
--
ALTER TABLE `temoignages`
  ADD CONSTRAINT `fk_temoignages_utilisateur` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
