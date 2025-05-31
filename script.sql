-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 31 mai 2025 à 13:32
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ticketing`
--

-- --------------------------------------------------------

--
-- Structure de la table `tp_client`
--

CREATE TABLE `tp_client` (
  `c_id` int(11) NOT NULL,
  `c_firstname` varchar(50) NOT NULL,
  `c_lastname` varchar(50) NOT NULL,
  `c_email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tp_client`
--

INSERT INTO `tp_client` (`c_id`, `c_firstname`, `c_lastname`, `c_email`) VALUES
(1, 'Alice', 'Martin', 'alice.martin@email.com'),
(2, 'Bob', 'Durand', 'bob.durand@email.com'),
(3, 'Chloé', 'Petit', 'chloe.petit@email.com'),
(4, 'David', 'Lefevre', 'david.lefevre@email.com'),
(5, 'Emma', 'Moreau', 'emma.moreau@email.com'),
(6, 'Lucas', 'Garcia', 'lucas.garcia@email.com'),
(7, 'Léa', 'Roux', 'lea.roux@email.com'),
(8, 'Hugo', 'Fournier', 'hugo.fournier@email.com'),
(9, 'Jade', 'Girard', 'jade.girard@email.com'),
(10, 'Louis', 'Andre', 'louis.andre@email.com'),
(11, 'Manon', 'Lambert', 'manon.lambert@email.com'),
(12, 'Nathan', 'Bonnet', 'nathan.bonnet@email.com'),
(13, 'Sarah', 'Francois', 'sarah.francois@email.com'),
(14, 'Tom', 'Martinez', 'tom.martinez@email.com'),
(15, 'Camille', 'Legrand', 'camille.legrand@email.com'),
(16, 'Enzo', 'Gauthier', 'enzo.gauthier@email.com'),
(17, 'Lina', 'Chevalier', 'lina.chevalier@email.com'),
(18, 'Noah', 'Perez', 'noah.perez@email.com'),
(19, 'Julie', 'Schmitt', 'julie.schmitt@email.com'),
(20, 'Maxime', 'Blanc', 'maxime.blanc@email.com');

-- --------------------------------------------------------

--
-- Structure de la table `tp_priority`
--

CREATE TABLE `tp_priority` (
  `pty_id` int(11) NOT NULL,
  `pty_name` varchar(10) NOT NULL,
  `pty_description` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tp_priority`
--

INSERT INTO `tp_priority` (`pty_id`, `pty_name`, `pty_description`) VALUES
(1, 'Low', 'Non-urgent issue, can be addressed later.'),
(2, 'Medium', 'Important, but not urgent.'),
(3, 'High', 'Significant issue, requires prompt attention.'),
(4, 'Critical', 'Urgent issue, disrupts core functionality.');

-- --------------------------------------------------------

--
-- Structure de la table `tp_project`
--

CREATE TABLE `tp_project` (
  `p_id` int(11) NOT NULL,
  `p_name` varchar(50) NOT NULL,
  `p_description` varchar(50) DEFAULT NULL,
  `p_creation` datetime NOT NULL,
  `p_due_date` datetime NOT NULL,
  `p_closed` tinyint(1) NOT NULL,
  `c_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tp_project`
--
INSERT INTO `tp_project` (`p_id`, `p_name`, `p_description`, `p_creation`, `p_due_date`, `p_closed`, `c_id`) VALUES
(1, 'Apollo', 'Cloud migration', '2025-01-10 09:00:00', '2025-06-30 18:00:00', 0, 1),
(2, 'Hermes', 'E-commerce redesign', '2025-02-15 10:00:00', '2025-07-15 18:00:00', 0, 2),
(3, 'Gaia', 'CRM deployment', '2025-03-01 11:00:00', '2025-08-01 18:00:00', 0, 3),
(4, 'Orion', 'Mobile app', '2025-01-20 09:30:00', '2025-06-20 18:00:00', 0, 4),
(5, 'Atlas', 'HR management', '2025-02-05 10:30:00', '2025-07-05 18:00:00', 0, 5),
(6, 'Helios', 'Client portal', '2025-03-10 11:30:00', '2025-08-10 18:00:00', 0, 6),
(7, 'Zeus', 'Invoice automation', '2025-01-25 09:45:00', '2025-06-25 18:00:00', 0, 7),
(8, 'Athena', 'Technical support', '2025-02-20 10:45:00', '2025-07-20 18:00:00', 0, 8),
(9, 'Poseidon', 'Stock management', '2025-03-15 11:45:00', '2025-08-15 18:00:00', 0, 9),
(10, 'Hera', 'Marketing platform', '2025-01-30 09:15:00', '2025-06-30 18:00:00', 0, 10),
(11, 'Dionysos', 'Event management', '2025-02-25 10:15:00', '2025-07-25 18:00:00', 0, 11),
(12, 'Artemis', 'Order tracking', '2025-03-20 11:15:00', '2025-08-20 18:00:00', 0, 12),
(13, 'Hestia', 'Company intranet', '2025-01-12 09:20:00', '2025-06-12 18:00:00', 0, 13),
(14, 'Ares', 'IT security', '2025-02-18 10:20:00', '2025-07-18 18:00:00', 0, 14),
(15, 'Demeter', 'Agricultural management', '2025-03-22 11:20:00', '2025-08-22 18:00:00', 0, 15),
(16, 'Persephone', 'Subscription management', '2025-01-14 09:25:00', '2025-06-14 18:00:00', 0, 16),
(17, 'Eros', 'Email campaigns', '2025-02-22 10:25:00', '2025-07-22 18:00:00', 0, 17),
(18, 'Hermione', 'Library management', '2025-03-25 11:25:00', '2025-08-25 18:00:00', 0, 18),
(19, 'Jason', 'Fleet management', '2025-01-16 09:35:00', '2025-06-16 18:00:00', 0, 19),
(20, 'Medea', 'Training management', '2025-02-28 10:35:00', '2025-07-28 18:00:00', 0, 20),
(21, 'Mercury', 'Internal messaging system', '2025-07-10 09:00:00', '2025-12-10 18:00:00', 0, 1),
(22, 'Venus', 'Customer feedback portal', '2025-07-15 10:00:00', '2025-12-15 18:00:00', 0, 2),
(23, 'Mars', 'Sales dashboard', '2025-07-20 11:00:00', '2025-12-20 18:00:00', 0, 3),
(24, 'Jupiter', 'Inventory tracking', '2025-07-25 09:30:00', '2025-12-25 18:00:00', 1, 4),
(25, 'Saturn', 'Supplier management', '2025-08-01 10:30:00', '2026-01-01 18:00:00', 1, 4),
(26, 'Neptune', 'Employee onboarding', '2025-08-05 11:30:00', '2026-01-05 18:00:00', 1, 4),
(27, 'Pluto', 'Legacy data migration', '2025-08-10 09:45:00', '2026-01-10 18:00:00', 0, 4),
(28, 'Europa', 'Mobile notifications', '2025-08-15 10:45:00', '2026-01-15 18:00:00', 0, 8),
(29, 'Titan', 'API integration', '2025-08-20 11:45:00', '2026-01-20 18:00:00', 0, 9),
(30, 'Ganymede', 'User analytics', '2025-08-25 09:15:00', '2026-01-25 18:00:00', 0, 4),
(31, 'Callisto', 'Document management', '2025-09-01 10:15:00', '2026-02-01 18:00:00', 0, 11),
(32, 'Io', 'Incident reporting', '2025-09-05 11:15:00', '2026-02-05 18:00:00', 0, 12),
(33, 'Oberon', 'Knowledge base', '2025-09-10 09:20:00', '2026-02-10 18:00:00', 0, 13),
(34, 'Miranda', 'Resource planning', '2025-09-15 10:20:00', '2026-02-15 18:00:00', 0, 14),
(35, 'Ariel', 'Meeting scheduler', '2025-09-20 11:20:00', '2026-02-20 18:00:00', 0, 15),
(36, 'Umbriel', 'Expense tracking', '2025-09-25 09:25:00', '2026-02-25 18:00:00', 0, 16),
(37, 'Triton', 'Remote access tool', '2025-10-01 10:25:00', '2026-03-01 18:00:00', 0, 17),
(38, 'Dione', 'Performance reviews', '2025-10-05 11:25:00', '2026-03-05 18:00:00', 0, 18),
(39, 'Rhea', 'Time tracking', '2025-10-10 09:35:00', '2026-03-10 18:00:00', 0, 19),
(40, 'Hyperion', 'Cloud backup', '2025-10-15 10:35:00', '2026-03-15 18:00:00', 0, 20);

-- --------------------------------------------------------

--
-- Structure de la table `tp_role`
--

CREATE TABLE `tp_role` (
  `r_id` int(11) NOT NULL,
  `r_name` varchar(30) NOT NULL,
  `r_description` varchar(100) DEFAULT NULL,
  `r_timestamp_addition` datetime NOT NULL,
  `r_timestamp_modification` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tp_role`
--

INSERT INTO `tp_role` (`r_id`, `r_name`, `r_description`, `r_timestamp_addition`, `r_timestamp_modification`) VALUES
(1, 'Administrator', 'User in charge of user and project management', '2025-05-17 18:02:57', '2025-05-17 18:02:57'),
(2, 'Developer', 'User responsible for ticket processing', '2025-05-17 18:02:57', '2025-05-17 18:02:57'),
(3, 'Reporter', 'User registering tickets', '2025-05-17 18:02:57', '2025-05-17 18:02:57');

-- --------------------------------------------------------

--
-- Structure de la table `tp_status`
--

CREATE TABLE `tp_status` (
  `s_id` int(11) NOT NULL,
  `s_name` varchar(20) NOT NULL,
  `s_description` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tp_status`
--

INSERT INTO `tp_status` (`s_id`, `s_name`, `s_description`) VALUES
(1, 'New', 'A new ticket.'),
(2, 'InProgress', 'Work is being done.'),
(3, 'Resolved', 'The issue has been fixed.'),
(4, 'Closed', 'No further actions needed.');

-- --------------------------------------------------------

--
-- Structure de la table `tp_ticket`
--

CREATE TABLE `tp_ticket` (
  `t_id` int(11) NOT NULL,
  `t_description` varchar(300) NOT NULL,
  `t_creation` datetime NOT NULL,
  `t_due_date` datetime DEFAULT NULL,
  `t_timestamp_modification` datetime DEFAULT NULL,
  `t_timestamp_closed` datetime DEFAULT NULL,
  `c_id` int(11) DEFAULT NULL,
  `pty_id` int(11) NOT NULL,
  `s_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `u_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tp_ticket`
--

INSERT INTO `tp_ticket` (`t_id`, `t_description`, `t_creation`, `t_due_date`, `t_timestamp_modification`, `t_timestamp_closed`, `c_id`, `pty_id`, `s_id`, `p_id`, `u_id`) VALUES
(1, 'User cannot log in to the portal.', '2025-05-01 09:00:00', '2025-05-10 00:00:00', '2025-05-01 09:00:00', '2025-05-25 10:00:00', 1, 3, 4, 1, 2),  -- 15 jours après, 10:00
(2, 'Invoice PDF generation fails.', '2025-05-02 10:00:00', '2025-05-12 00:00:00', '2025-05-02 10:00:00', '2025-05-23 15:30:00', 2, 2, 4, 7, 3),  -- 11 jours après, 15:30
(3, 'Mobile app crashes on launch.', '2025-05-03 11:00:00', '2025-05-13 00:00:00', '2025-05-03 11:00:00', '2025-06-01 12:00:00', 4, 4, 4, 4, 4),  -- 19 jours après, 12:00
(4, 'CRM dashboard loads slowly.', '2025-05-04 12:30:00', '2025-05-14 00:00:00', '2025-05-04 12:30:00', '2025-05-27 09:00:00', 3, 2, 4, 3, 5),   -- 13 jours après, 09:00
(5, 'HR management: cannot add new employee.', '2025-05-05 13:30:00', '2025-05-15 00:00:00', '2025-05-05 13:30:00', '2025-06-04 08:30:00', 5, 3, 4, 5, 6),  -- 20 jours après, 08:30
(6, 'Cloud migration: data sync issue.', '2025-05-06 14:45:00', '2025-05-16 00:00:00', '2025-05-06 14:45:00', '2025-06-02 14:00:00', 1, 4, 4, 1, 7),  -- 17 jours après, 14:00
(7, 'Client portal: password reset email not sent.', '2025-05-07 15:30:00', '2025-05-17 00:00:00', '2025-05-07 15:30:00', '2025-06-10 16:00:00', 6, 2, 4, 6, 8),  -- 24 jours après, 16:00
(8, 'Stock management: negative inventory allowed.', '2025-05-08 16:00:00', '2025-05-18 00:00:00', '2025-05-08 16:00:00', '2025-06-06 18:00:00', 9, 3, 4, 9, 9),  -- 19 jours après, 18:00
(9, 'Marketing platform: campaign stats incorrect.', '2025-05-09 09:00:00', '2025-05-19 00:00:00', '2025-05-09 09:00:00', '2025-06-12 09:30:00', 10, 2, 4, 10, 10),  -- 24 jours après, 09:30
(10, 'Event management: cannot upload images.', '2025-05-10 10:30:00', '2025-05-20 00:00:00', '2025-05-10 10:30:00', '2025-06-16 10:00:00', 11, 1, 4, 11, 11),  -- 27 jours après, 10:00
(11, 'Order tracking: missing notifications.', '2025-05-11 11:30:00', '2025-05-21 00:00:00', '2025-05-11 11:30:00', NULL, 12, 2, 1, 12, 12),
(12, 'Company intranet: broken links on homepage.', '2025-05-12 12:00:00', '2025-05-22 00:00:00', '2025-05-12 12:00:00', NULL, 13, 1, 2, 13, 13),
(13, 'IT security: vulnerability detected.', '2025-05-13 13:15:00', '2025-05-23 00:00:00', '2025-05-13 13:15:00', '2025-05-23 00:10:00', 14, 4, 1, 14, 14),
(14, 'Agricultural management: weather data not updating.', '2025-05-14 14:30:00', '2025-05-24 00:00:00', '2025-05-14 14:30:00', NULL, 15, 2, 2, 15, 15),
(15, 'Subscription management: duplicate invoices.', '2025-05-15 15:45:00', '2025-05-25 00:00:00', '2025-05-15 15:45:00', NULL, 16, 3, 1, 16, 16),
(16, 'Email campaigns: bounce rate too high.', '2025-05-16 09:30:00', '2025-05-26 00:00:00', '2025-05-16 09:30:00', NULL, 17, 2, 2, 17, 17),
(17, 'Library management: search not working.', '2025-05-17 10:00:00', '2025-05-27 00:00:00', '2025-05-17 10:00:00', NULL, 18, 3, 1, 18, 18),
(18, 'Fleet management: GPS tracking delayed.', '2025-05-18 11:00:00', '2025-05-28 00:00:00', '2025-05-18 11:00:00', NULL, 19, 2, 2, 19, 19),
(19, 'Training management: course progress not saved.', '2025-05-19 12:00:00', '2025-05-29 00:00:00', '2025-05-19 12:00:00', NULL, 20, 3, 1, 20, 20),
(20, 'Internal messaging: cannot send attachments.', '2025-05-20 13:30:00', '2025-05-30 00:00:00', '2025-05-20 13:30:00', NULL, 1, 2, 2, 21, 2),
(21, 'Customer feedback: form validation error.', '2025-05-21 14:30:00', '2025-05-31 00:00:00', '2025-05-21 14:30:00', NULL, 2, 1, 1, 22, 3),
(22, 'Sales dashboard: charts not loading.', '2025-05-22 15:00:00', '2025-06-01 00:00:00', '2025-05-22 15:00:00', NULL, 3, 2, 2, 23, 4),
(23, 'Inventory tracking: export to CSV fails.', '2025-05-23 08:30:00', '2025-06-02 00:00:00', '2025-05-23 08:30:00', NULL, 4, 3, 1, 24, 5),
(24, 'Supplier management: cannot add new supplier.', '2025-05-24 09:30:00', '2025-06-03 00:00:00', '2025-05-24 09:30:00', NULL, 5, 2, 2, 25, 6),
(25, 'Employee onboarding: missing welcome email.', '2025-05-25 10:30:00', '2025-06-04 00:00:00', '2025-05-25 10:30:00', NULL, 6, 1, 1, 26, 7),
(26, 'Legacy data migration: data mismatch.', '2025-05-26 11:45:00', '2025-06-05 00:00:00', '2025-05-26 11:45:00', NULL, 7, 3, 2, 27, 8),
(27, 'Mobile notifications: push not received.', '2025-05-27 12:15:00', '2025-06-06 00:00:00', '2025-05-27 12:15:00', NULL, 8, 2, 1, 28, 9),
(28, 'API integration: authentication error.', '2025-05-28 13:30:00', '2025-06-07 00:00:00', '2025-05-28 13:30:00', '2025-06-07 11:10:00', 9, 3, 2, 29, 10),
(29, 'User analytics: incorrect user count.', '2025-05-29 14:00:00', '2025-06-08 00:00:00', '2025-05-29 14:00:00', NULL, 10, 2, 1, 30, 11),
(30, 'Document management: cannot upload PDF.', '2025-05-30 15:00:00', '2025-06-09 00:00:00', '2025-05-30 15:00:00', NULL, 11, 3, 2, 31, 12),
(31, 'Incident reporting: duplicate tickets.', '2025-05-31 16:00:00', '2025-06-10 00:00:00', '2025-05-31 16:00:00', NULL, 12, 2, 1, 32, 13),
(32, 'Knowledge base: articles not saving.', '2025-06-01 17:00:00', '2025-06-11 00:00:00', '2025-06-01 17:00:00', NULL, 13, 1, 2, 33, 14),
(33, 'Resource planning: calendar not updating.', '2025-06-02 18:30:00', '2025-06-12 00:00:00', '2025-06-02 18:30:00', NULL, 14, 2, 1, 34, 15),
(34, 'Meeting scheduler: timezone issue.', '2025-06-03 19:00:00', '2025-06-13 00:00:00', '2025-06-03 19:00:00', NULL, 15, 3, 2, 35, 16),
(35, 'Expense tracking: totals incorrect.', '2025-06-04 20:30:00', '2025-06-14 00:00:00', '2025-06-04 21:00:00', NULL, 16, 2, 3, 36, 17),  -- t_timestamp_closed = NULL
(36, 'Remote access tool: connection timeout.', '2025-06-05 21:00:00', '2025-06-15 00:00:00', '2025-06-05 21:15:00', NULL, 17, 4, 3, 37, 18),  -- t_timestamp_closed = NULL
(37, 'Performance reviews: cannot submit feedback.', '2025-06-06 22:15:00', '2025-06-16 00:00:00', '2025-06-06 22:30:00', NULL, 18, 2, 3, 38, 19),  -- t_timestamp_closed = NULL
(38, 'Time tracking: timer stops unexpectedly.', '2025-06-07 23:00:00', '2025-06-17 00:00:00', '2025-06-07 23:15:00', NULL, 19, 3, 3, 39, 20),  -- t_timestamp_closed = NULL
(39, 'Cloud backup: restore fails.', '2025-06-08 23:30:00', '2025-06-18 00:00:00', '2025-06-08 23:45:00', NULL, 20, 4, 3, 40, 1),  -- t_timestamp_closed = NULL
(40, 'Technical support: chat not loading.', '2025-06-09 00:00:00', '2025-06-19 00:00:00', '2025-06-09 00:15:00', NULL, 8, 2, 3, 8, 2);  -- t_timestamp_closed = NULL



-- --------------------------------------------------------

--
-- Structure de la table `tp_user`
--

CREATE TABLE `tp_user` (
  `u_id` int(11) NOT NULL,
  `u_login` varchar(50) NOT NULL,
  `u_firstname` varchar(50) NOT NULL,
  `u_lastname` varchar(50) NOT NULL,
  `u_email` varchar(50) NOT NULL,
  `u_password` text DEFAULT NULL,
  `u_timestamp_creation` datetime DEFAULT NULL,
  `u_timestamp_modification` datetime NOT NULL,
  `u_profile_picture` text DEFAULT 'assets/images/uploads/user.png',
  `u_gender` tinyint(1) NOT NULL,
  `u_phone_number` varchar(10) DEFAULT NULL,
  `u_status` int(11) NOT NULL,
  `u_description` varchar(50) DEFAULT NULL,
  `r_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tp_user`
--

INSERT INTO `tp_user` (`u_id`, `u_login`, `u_firstname`, `u_lastname`, `u_email`, `u_password`, `u_timestamp_creation`, `u_timestamp_modification`, `u_profile_picture`, `u_gender`, `u_phone_number`, `u_status`, `u_description`, `r_id`) VALUES
(1, 'admin', 'Admin', 'Admin', 'alice.smith@email.com', '$2y$10$WfiLGhoASjVWSu5iWOjpU.DWW8FtCdW5cmR47A9VYVSZoiO92cYwe', '2025-05-01 09:00:00', '2025-05-01 09:00:00', 'assets/images/uploads/user.png', 0, '0600000001', 1, 'Administrator', 1),
(2, 'developer', 'Developer', 'Developer', 'john.doe@email.com', '$2y$10$WfiLGhoASjVWSu5iWOjpU.DWW8FtCdW5cmR47A9VYVSZoiO92cYwe', '2025-05-01 09:10:00', '2025-05-01 09:10:00', 'assets/images/uploads/user.png', 1, '0600000002', 1, 'Developer', 2),
(3, 'reporter', 'Reporter', 'Reporter', 'mary.jones@email.com', '$2y$10$WfiLGhoASjVWSu5iWOjpU.DWW8FtCdW5cmR47A9VYVSZoiO92cYwe', '2025-05-01 09:20:00', '2025-05-01 09:20:00', 'assets/images/uploads/user.png', 0, '0600000003', 1, 'Reporter', 3),
(4, 'bwayne', 'Bruce', 'Wayne', 'bruce.wayne@email.com', NULL, '2025-05-01 09:30:00', '2025-05-01 09:30:00', 'assets/images/uploads/user.png', 1, '0600000004', 1, 'Developer', 2),
(5, 'ckent', 'Clark', 'Kent', 'clark.kent@email.com', NULL, '2025-05-01 09:40:00', '2025-05-01 09:40:00', 'assets/images/uploads/user.png', 1, '0600000005', 1, 'Reporter', 3),
(6, 'dprince', 'Diana', 'Prince', 'diana.prince@email.com', NULL, '2025-05-01 09:50:00', '2025-05-01 09:50:00', 'assets/images/uploads/user.png', 0, '0600000006', 1, 'Developer', 2),
(7, 'pparker', 'Peter', 'Parker', 'peter.parker@email.com', NULL, '2025-05-01 10:00:00', '2025-05-01 10:00:00', 'assets/images/uploads/user.png', 1, '0600000007', 1, 'Reporter', 3),
(8, 'tstark', 'Tony', 'Stark', 'tony.stark@email.com', NULL, '2025-05-01 10:10:00', '2025-05-01 10:10:00', 'assets/images/uploads/user.png', 1, '0600000008', 1, 'Developer', 2),
(9, 'srogers', 'Steve', 'Rogers', 'steve.rogers@email.com', NULL, '2025-05-01 10:20:00', '2025-05-01 10:20:00', 'assets/images/uploads/user.png', 1, '0600000009', 1, 'Reporter', 3),
(10, 'nromanoff', 'Natasha', 'Romanoff', 'natasha.romanoff@email.com', NULL, '2025-05-01 10:30:00', '2025-05-01 10:30:00', 'assets/images/uploads/user.png', 0, '0600000010', 1, 'Developer', 2),
(11, 'bwilson', 'Barbara', 'Wilson', 'barbara.wilson@email.com', NULL, '2025-05-01 10:40:00', '2025-05-01 10:40:00', 'assets/images/uploads/user.png', 0, '0600000011', 1, 'Reporter', 3),
(12, 'hpotter', 'Harry', 'Potter', 'harry.potter@email.com', NULL, '2025-05-01 10:50:00', '2025-05-01 10:50:00', 'assets/images/uploads/user.png', 1, '0600000012', 1, 'Developer', 2),
(13, 'rgranger', 'Ron', 'Granger', 'ron.granger@email.com', NULL, '2025-05-01 11:00:00', '2025-05-01 11:00:00', 'assets/images/uploads/user.png', 1, '0600000013', 1, 'Reporter', 3),
(14, 'hgranger', 'Hermione', 'Granger', 'hermione.granger@email.com', NULL, '2025-05-01 11:10:00', '2025-05-01 11:10:00', 'assets/images/uploads/user.png', 0, '0600000014', 1, 'Developer', 2),
(15, 'lskywalker', 'Luke', 'Skywalker', 'luke.skywalker@email.com', NULL, '2025-05-01 11:20:00', '2025-05-01 11:20:00', 'assets/images/uploads/user.png', 1, '0600000015', 1, 'Reporter', 3),
(16, 'lorgana', 'Leia', 'Organa', 'leia.organa@email.com', NULL, '2025-05-01 11:30:00', '2025-05-01 11:30:00', 'assets/images/uploads/user.png', 0, '0600000016', 1, 'Developer', 2),
(17, 'hsolo', 'Han', 'Solo', 'han.solo@email.com', NULL, '2025-05-01 11:40:00', '2025-05-01 11:40:00', 'assets/images/uploads/user.png', 1, '0600000017', 1, 'Reporter', 3),
(18, 'c3po', 'C3', 'PO', 'c3.po@email.com', NULL, '2025-05-01 11:50:00', '2025-05-01 11:50:00', 'assets/images/uploads/user.png', 1, '0600000018', 1, 'Developer', 2),
(19, 'r2d2', 'R2', 'D2', 'r2.d2@email.com', NULL, '2025-05-01 12:00:00', '2025-05-01 12:00:00', 'assets/images/uploads/user.png', 1, '0600000019', 1, 'Reporter', 3),
(20, 'yoda', 'Yoda', '', 'yoda@email.com', NULL, '2025-05-01 12:10:00', '2025-05-01 12:10:00', 'assets/images/uploads/user.png', 1, '0600000020', 1, 'Developer', 2),
(21, 'gweasley', 'Ginny', 'Weasley', 'ginny.weasley@email.com', NULL, '2025-05-01 12:20:00', '2025-05-01 12:20:00', 'assets/images/uploads/user.png', 0, '0600000021', 1, 'Reporter', 3),
(22, 'fweasley', 'Fred', 'Weasley', 'fred.weasley@email.com', NULL, '2025-05-01 12:30:00', '2025-05-01 12:30:00', 'assets/images/uploads/user.png', 1, '0600000022', 1, 'Developer', 2),
(23, 'ggranger', 'George', 'Granger', 'george.granger@email.com', NULL, '2025-05-01 12:40:00', '2025-05-01 12:40:00', 'assets/images/uploads/user.png', 1, '0600000023', 1, 'Reporter', 3),
(24, 'dmalfoy', 'Draco', 'Malfoy', 'draco.malfoy@email.com', NULL, '2025-05-01 12:50:00', '2025-05-01 12:50:00', 'assets/images/uploads/user.png', 1, '0600000024', 1, 'Developer', 2),
(25, 'nlongbottom', 'Neville', 'Longbottom', 'neville.longbottom@email.com', NULL, '2025-05-01 13:00:00', '2025-05-01 13:00:00', 'assets/images/uploads/user.png', 1, '0600000025', 1, 'Reporter', 3),
(26, 'llovegood', 'Luna', 'Lovegood', 'luna.lovegood@email.com', NULL, '2025-05-01 13:10:00', '2025-05-01 13:10:00', 'assets/images/uploads/user.png', 0, '0600000026', 1, 'Developer', 2),
(27, 'sblack', 'Sirius', 'Black', 'sirius.black@email.com', NULL, '2025-05-01 13:20:00', '2025-05-01 13:20:00', 'assets/images/uploads/user.png', 1, '0600000027', 1, 'Reporter', 3),
(28, 'rweasley', 'Ron', 'Weasley', 'ron.weasley@email.com', NULL, '2025-05-01 13:30:00', '2025-05-01 13:30:00', 'assets/images/uploads/user.png', 1, '0600000028', 1, 'Developer', 2),
(29, 'mmax', 'Max', 'Mustermann', 'max.mustermann@email.com', NULL, '2025-05-01 13:40:00', '2025-05-01 13:40:00', 'assets/images/uploads/user.png', 1, '0600000029', 1, 'Reporter', 3),
(30, 'ejohnson', 'Emma', 'Johnson', 'emma.johnson@email.com', NULL, '2025-05-01 13:50:00', '2025-05-01 13:50:00', 'assets/images/uploads/user.png', 0, '0600000030', 1, 'Developer', 2),
(31, 'owilliams', 'Olivia', 'Williams', 'olivia.williams@email.com', NULL, '2025-05-01 14:00:00', '2025-05-01 14:00:00', 'assets/images/uploads/user.png', 0, '0600000031', 1, 'Reporter', 3),
(32, 'jwilson', 'James', 'Wilson', 'james.wilson@email.com', NULL, '2025-05-01 14:10:00', '2025-05-01 14:10:00', 'assets/images/uploads/user.png', 1, '0600000032', 1, 'Developer', 2),
(33, 'lmoore', 'Lily', 'Moore', 'lily.moore@email.com', NULL, '2025-05-01 14:20:00', '2025-05-01 14:20:00', 'assets/images/uploads/user.png', 0, '0600000033', 1, 'Reporter', 3),
(34, 'dthomas', 'David', 'Thomas', 'david.thomas@email.com', NULL, '2025-05-01 14:30:00', '2025-05-01 14:30:00', 'assets/images/uploads/user.png', 1, '0600000034', 1, 'Developer', 2),
(35, 'sjackson', 'Sophia', 'Jackson', 'sophia.jackson@email.com', NULL, '2025-05-01 14:40:00', '2025-05-01 14:40:00', 'assets/images/uploads/user.png', 0, '0600000035', 1, 'Reporter', 3),
(36, 'bmartin', 'Benjamin', 'Martin', 'benjamin.martin@email.com', NULL, '2025-05-01 14:50:00', '2025-05-01 14:50:00', 'assets/images/uploads/user.png', 1, '0600000036', 1, 'Developer', 2),
(37, 'cwhite', 'Charlotte', 'White', 'charlotte.white@email.com', NULL, '2025-05-01 15:00:00', '2025-05-01 15:00:00', 'assets/images/uploads/user.png', 0, '0600000037', 1, 'Reporter', 3),
(38, 'hlee', 'Henry', 'Lee', 'henry.lee@email.com', NULL, '2025-05-01 15:10:00', '2025-05-01 15:10:00', 'assets/images/uploads/user.png', 1, '0600000038', 1, 'Developer', 2),
(39, 'zclark', 'Zoe', 'Clark', 'zoe.clark@email.com', NULL, '2025-05-01 15:20:00', '2025-05-01 15:20:00', 'assets/images/uploads/user.png', 0, '0600000039', 1, 'Reporter', 3),
(40, 'mroberts', 'Mason', 'Roberts', 'mason.roberts@email.com', NULL, '2025-05-01 15:30:00', '2025-05-01 15:30:00', 'assets/images/uploads/user.png', 1, '0600000040', 1, 'Developer', 2);

-- --------------------------------------------------------

--
-- Structure de la table `tp_work`
--

CREATE TABLE `tp_work` (
  `u_id` int(11) NOT NULL,
  `t_id` int(11) NOT NULL,
  `w_commentary` text DEFAULT NULL,
  `w_timestamp_modification` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tp_user`
--
INSERT INTO `tp_work` (`u_id`, `t_id`, `w_commentary`, `w_timestamp_modification`) VALUES
(2, 1, 'Investigated login issue, reset user password.', '2025-05-01 10:00:00'),
(3, 2, 'Checked PDF generation logs, found missing dependency.', '2025-05-02 11:00:00'),
(4, 3, 'Crash caused by outdated library, updated to latest version.', '2025-05-03 12:00:00'),
(5, 4, 'Optimized dashboard queries for faster load times.', '2025-05-04 13:00:00'),
(6, 5, 'Fixed validation on employee form.', '2025-05-05 14:00:00'),
(7, 6, 'Resolved data sync conflict during migration.', '2025-05-06 15:00:00'),
(8, 7, 'SMTP configuration corrected for password reset emails.', '2025-05-07 16:00:00'),
(9, 8, 'Added validation to prevent negative inventory.', '2025-05-08 17:00:00'),
(10, 9, 'Corrected campaign statistics calculation.', '2025-05-09 18:00:00'),
(11, 10, 'Adjusted file upload permissions for images.', '2025-05-10 19:00:00'),
(12, 11, 'Notification service restarted and tested.', '2025-05-11 20:00:00'),
(13, 12, 'Fixed homepage links and updated sitemap.', '2025-05-12 21:00:00'),
(14, 13, 'Patched security vulnerability and notified team.', '2025-05-13 22:00:00'),
(15, 14, 'Weather API integration fixed for agricultural module.', '2025-05-14 23:00:00'),
(16, 15, 'Removed duplicate invoice generation logic.', '2025-05-15 09:00:00'),
(17, 16, 'Improved email validation to reduce bounce rate.', '2025-05-16 10:00:00'),
(18, 17, 'Re-indexed library database for faster search.', '2025-05-17 11:00:00'),
(19, 18, 'GPS polling interval adjusted for real-time tracking.', '2025-05-18 12:00:00'),
(20, 19, 'Fixed course progress save functionality.', '2025-05-19 13:00:00'),
(2, 20, 'Attachment upload bug fixed in messaging system.', '2025-05-20 14:00:00'),
(3, 21, 'Corrected validation rules on feedback form.', '2025-05-21 15:00:00'),
(4, 22, 'Updated chart library for dashboard.', '2025-05-22 16:00:00'),
(5, 23, 'Fixed CSV export encoding issue.', '2025-05-23 17:00:00'),
(6, 24, 'Supplier form validation improved.', '2025-05-24 18:00:00'),
(7, 25, 'Welcome email template updated.', '2025-05-25 19:00:00'),
(8, 26, 'Resolved data mismatch during migration.', '2025-05-26 20:00:00'),
(9, 27, 'Push notification service restarted.', '2025-05-27 21:00:00'),
(10, 28, 'API authentication token refreshed.', '2025-05-28 22:00:00'),
(11, 29, 'User count calculation corrected.', '2025-05-29 23:00:00'),
(12, 30, 'PDF upload limit increased.', '2025-05-30 09:00:00'),
(13, 31, 'Duplicate ticket detection improved.', '2025-05-31 10:00:00'),
(14, 32, 'Article save bug fixed in knowledge base.', '2025-06-01 11:00:00'),
(15, 33, 'Calendar sync issue resolved.', '2025-06-02 12:00:00'),
(16, 34, 'Timezone handling improved for meetings.', '2025-06-03 13:00:00'),
(17, 35, 'Expense calculation logic updated.', '2025-06-04 14:00:00'),
(18, 36, 'Connection timeout increased for remote access.', '2025-06-05 15:00:00'),
(19, 37, 'Feedback submission bug fixed.', '2025-06-06 16:00:00'),
(20, 38, 'Timer stability improved.', '2025-06-07 17:00:00'),
(1, 39, 'Cloud restore process debugged and fixed.', '2025-06-08 18:00:00'),
(2, 40, 'Live chat server restarted.', '2025-06-09 19:00:00');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `tp_client`
--
ALTER TABLE `tp_client`
  ADD PRIMARY KEY (`c_id`);

--
-- Index pour la table `tp_priority`
--
ALTER TABLE `tp_priority`
  ADD PRIMARY KEY (`pty_id`);

--
-- Index pour la table `tp_project`
--
ALTER TABLE `tp_project`
  ADD PRIMARY KEY (`p_id`),
  ADD KEY `c_id` (`c_id`);

--
-- Index pour la table `tp_role`
--
ALTER TABLE `tp_role`
  ADD PRIMARY KEY (`r_id`);

--
-- Index pour la table `tp_status`
--
ALTER TABLE `tp_status`
  ADD PRIMARY KEY (`s_id`);

--
-- Index pour la table `tp_ticket`
--
ALTER TABLE `tp_ticket`
  ADD PRIMARY KEY (`t_id`),
  ADD KEY `c_id` (`c_id`),
  ADD KEY `s_id` (`s_id`),
  ADD KEY `pty_id` (`pty_id`) USING BTREE,
  ADD KEY `p_id` (`p_id`) USING BTREE,
  ADD KEY `u_id` (`u_id`);

--
-- Index pour la table `tp_user`
--
ALTER TABLE `tp_user`
  ADD PRIMARY KEY (`u_id`),
  ADD UNIQUE KEY `u_login` (`u_login`),
  ADD UNIQUE KEY `u_email` (`u_email`),
  ADD KEY `r_id` (`r_id`);

--
-- Index pour la table `tp_work`
--
ALTER TABLE `tp_work`
  ADD KEY `t_id` (`t_id`),
  ADD KEY `u_id` (`u_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `tp_client`
--
ALTER TABLE `tp_client`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `tp_priority`
--
ALTER TABLE `tp_priority`
  MODIFY `pty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `tp_project`
--
ALTER TABLE `tp_project`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `tp_role`
--
ALTER TABLE `tp_role`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `tp_status`
--
ALTER TABLE `tp_status`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `tp_ticket`
--
ALTER TABLE `tp_ticket`
  MODIFY `t_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `tp_user`
--
ALTER TABLE `tp_user`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `tp_project`
--
ALTER TABLE `tp_project`
  ADD CONSTRAINT `tp_project_ibfk_1` FOREIGN KEY (`c_id`) REFERENCES `tp_client` (`c_id`);

--
-- Contraintes pour la table `tp_ticket`
--
ALTER TABLE `tp_ticket`
  ADD CONSTRAINT `tp_ticket_ibfk_1` FOREIGN KEY (`c_id`) REFERENCES `tp_client` (`c_id`),
  ADD CONSTRAINT `tp_ticket_ibfk_2` FOREIGN KEY (`pty_id`) REFERENCES `tp_priority` (`pty_id`),
  ADD CONSTRAINT `tp_ticket_ibfk_3` FOREIGN KEY (`s_id`) REFERENCES `tp_status` (`s_id`);

--
-- Contraintes pour la table `tp_user`
--
ALTER TABLE `tp_user`
  ADD CONSTRAINT `tp_user_ibfk_1` FOREIGN KEY (`r_id`) REFERENCES `tp_role` (`r_id`);

--
-- Contraintes pour la table `tp_work`
--
ALTER TABLE `tp_work`
  ADD CONSTRAINT `tp_work_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `tp_user` (`u_id`),
  ADD CONSTRAINT `tp_work_ibfk_2` FOREIGN KEY (`t_id`) REFERENCES `tp_ticket` (`t_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
