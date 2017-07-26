-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 26 Iul 2017 la 16:19
-- Versiune server: 10.1.19-MariaDB
-- PHP Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cdi-secure`
--

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `books`
--

CREATE TABLE `books` (
  `id_book` int(11) NOT NULL,
  `book_image` varchar(100) NOT NULL DEFAULT 'default.png',
  `titlu` varchar(100) NOT NULL,
  `autor` varchar(100) NOT NULL,
  `id_categorie` int(11) NOT NULL,
  `stoc` int(11) NOT NULL,
  `imprumutate` int(11) NOT NULL DEFAULT '0',
  `descriere` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Salvarea datelor din tabel `books`
--

INSERT INTO `books` (`id_book`, `book_image`, `titlu`, `autor`, `id_categorie`, `stoc`, `imprumutate`, `descriere`) VALUES
(1, '201705192305592017435348.jpg', 'Omul invizibil', 'Herbert Wells', 6, 4, 0, 'Aceasta este o poveste SF atractiva si plina de suspans in care personajul principal este un om de stiinta care a descoperit formula pentru a face pe cineva invizibil tastand-o pe el insusi.'),
(2, '20170519230331126201845.jpg', 'Ion', 'Liviu Rebreanu', 10, 4, 0, 'Este o carte plina de realitate . Personajul Ion oscileaza intre dorinta dea avea pamantul lui Vasile Baciu si cea a implinirii iubirii pentru Florica.\r\nSper sa va placa!'),
(3, '20170519230449504551290.jpg', 'Harap Alb', 'Ion Creanga', 3, 4, 0, 'O descriere foarte frumoasa'),
(4, '201705192306561806705611.jpg', 'Poezii', 'Mihai Eminescu', 10, 5, 0, 'Cele peste 30 de lucrari din aceasta carte, apartinandu-i lui Mihai Eminescu, ii vor incanta atat pe cei mici,cat si pe cei mari.'),
(5, '201706152310401920227518.jpg', 'Enigma Otiliei', 'George Calinescu', 3, 3, 0, 'O carte foarte frumoasa'),
(6, '201705291145242098809185.jpg', 'Ultima noapte de dragoste. Intaia noapte de razboi', 'Camil Petrescu', 10, 3, 0, 'O carte frumoasa'),
(7, '201706022220151225033095.jpg', 'Singur pe lume', 'Hector Malot', 10, 3, 0, 'O carte extraordinara care mi-a marcat copilaria.'),
(8, '201706100825342030286193.jpg', 'Baltagul', 'Mihail Sadoveanu', 10, 4, 0, 'O carte frumoasa'),
(9, '201706160822301431947258.jpg', 'Maitreiy', 'Mircea Eliade', 10, 5, 0, '');

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `categorii`
--

CREATE TABLE `categorii` (
  `id_categorie` int(11) NOT NULL,
  `nume_categorie` varchar(40) NOT NULL,
  `implicit` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Salvarea datelor din tabel `categorii`
--

INSERT INTO `categorii` (`id_categorie`, `nume_categorie`, `implicit`) VALUES
(3, 'niciuna', 1),
(6, 'science-fiction', 0),
(10, 'literaturÄƒ', 0);

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `imagini`
--

CREATE TABLE `imagini` (
  `book_image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Salvarea datelor din tabel `imagini`
--

INSERT INTO `imagini` (`book_image`) VALUES
('20170519230331126201845.jpg'),
('20170519230449504551290.jpg'),
('201705192305592017435348.jpg'),
('201705192306561806705611.jpg'),
('201705291145242098809185.jpg'),
('201706022220151225033095.jpg'),
('201706100825342030286193.jpg'),
('201706152310401920227518.jpg'),
('201706160822301431947258.jpg'),
('201707261402462038589837.jpg'),
('default.png');

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `rezervari_camere`
--

CREATE TABLE `rezervari_camere` (
  `id_rezervare` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_room` int(11) NOT NULL,
  `profesor` varchar(40) NOT NULL,
  `clasa` varchar(15) NOT NULL,
  `data` date NOT NULL,
  `ora` int(11) NOT NULL,
  `motiv` text NOT NULL,
  `confirmed` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `rezervari_carti`
--

CREATE TABLE `rezervari_carti` (
  `id_rezervare` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_book` int(11) NOT NULL,
  `stoc_rezervat` int(11) NOT NULL,
  `data_rezervarii` date NOT NULL,
  `confirmed` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `roluri`
--

CREATE TABLE `roluri` (
  `rol` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Salvarea datelor din tabel `roluri`
--

INSERT INTO `roluri` (`rol`) VALUES
('admin'),
('admin_suprem'),
('cititor'),
('cititor_rezerva'),
('rezerva'),
('vizitator');

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `rooms`
--

CREATE TABLE `rooms` (
  `id_room` int(11) NOT NULL,
  `nume` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Salvarea datelor din tabel `rooms`
--

INSERT INTO `rooms` (`id_room`, `nume`) VALUES
(1, 'CDI'),
(2, 'Aula Magna'),
(3, 'Amfiteatru'),
(4, 'Sala Proiectie');

-- --------------------------------------------------------

--
-- Structura de tabel pentru tabelul `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(40) NOT NULL,
  `nume` varchar(40) NOT NULL,
  `prenume` varchar(40) NOT NULL,
  `clasa` varchar(10) DEFAULT NULL,
  `parola` varchar(40) NOT NULL,
  `salt` varchar(40) NOT NULL,
  `rol` varchar(30) NOT NULL,
  `data_realizarii` date NOT NULL,
  `confirmed` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Salvarea datelor din tabel `users`
--

INSERT INTO `users` (`id_user`, `username`, `nume`, `prenume`, `clasa`, `parola`, `salt`, `rol`, `data_realizarii`, `confirmed`) VALUES
(7, 'batabtro', 'Batalan', 'Vlad', 'XIID', '$1$4b07bfce$9SjRqjO9WZKxpw/iyRxqF1', '4b07bfce4ed802ebdb252d3146bb39ec', 'admin_suprem', '2017-01-30', 1),
(8, 'cerasela-cardas', 'Cardas', 'Cerasela', 'Profesor', '$1$4b07bfce$TZZKMGdD3Ju6GNJrPzcoJ0', '4b07bfce4ed802ebdb252d3146bb39ec', 'admin', '2017-04-10', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id_book`),
  ADD KEY `id_categorie` (`id_categorie`),
  ADD KEY `book_image` (`book_image`);

--
-- Indexes for table `categorii`
--
ALTER TABLE `categorii`
  ADD PRIMARY KEY (`id_categorie`);

--
-- Indexes for table `imagini`
--
ALTER TABLE `imagini`
  ADD PRIMARY KEY (`book_image`);

--
-- Indexes for table `rezervari_camere`
--
ALTER TABLE `rezervari_camere`
  ADD PRIMARY KEY (`id_rezervare`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_room` (`id_room`);

--
-- Indexes for table `rezervari_carti`
--
ALTER TABLE `rezervari_carti`
  ADD PRIMARY KEY (`id_rezervare`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_carte` (`id_book`);

--
-- Indexes for table `roluri`
--
ALTER TABLE `roluri`
  ADD PRIMARY KEY (`rol`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id_room`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `rol` (`rol`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id_book` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `categorii`
--
ALTER TABLE `categorii`
  MODIFY `id_categorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `rezervari_camere`
--
ALTER TABLE `rezervari_camere`
  MODIFY `id_rezervare` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `rezervari_carti`
--
ALTER TABLE `rezervari_carti`
  MODIFY `id_rezervare` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id_room` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- Restrictii pentru tabele sterse
--

--
-- Restrictii pentru tabele `rezervari_camere`
--
ALTER TABLE `rezervari_camere`
  ADD CONSTRAINT `rezervari_camere_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rezervari_camere_ibfk_2` FOREIGN KEY (`id_room`) REFERENCES `rooms` (`id_room`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrictii pentru tabele `rezervari_carti`
--
ALTER TABLE `rezervari_carti`
  ADD CONSTRAINT `rezervari_carti_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rezervari_carti_ibfk_2` FOREIGN KEY (`id_book`) REFERENCES `books` (`id_book`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrictii pentru tabele `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`rol`) REFERENCES `roluri` (`rol`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
