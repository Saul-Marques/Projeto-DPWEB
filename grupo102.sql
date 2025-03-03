-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13-Jan-2025 às 16:57
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `grupo102`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `bids`
--

CREATE TABLE `bids` (
  `id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `valor` float NOT NULL,
  `licitado_a` timestamp NOT NULL DEFAULT current_timestamp(),
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `bids`
--

INSERT INTO `bids` (`id`, `produto_id`, `user_id`, `valor`, `licitado_a`, `timestamp`) VALUES
(1, 34, 1, 4443, '2024-11-26 10:23:17', '2024-12-01 23:10:33'),
(2, 34, 1, 0, '2024-11-26 10:25:25', '2024-12-01 23:10:33'),
(3, 35, 1, 201, '2024-11-26 10:25:50', '2024-12-01 23:10:33'),
(4, 32, 1, 30.5, '2024-11-26 10:28:32', '2024-12-01 23:10:33'),
(5, 32, 1, 30.6, '2024-11-26 10:28:44', '2024-12-01 23:10:33'),
(6, 36, 1, 10, '2024-11-26 11:21:36', '2024-12-01 23:10:33'),
(7, 36, 1, 11, '2024-11-26 11:21:54', '2024-12-01 23:10:33'),
(8, 38, 1, 4, '2024-12-01 23:11:05', '2024-12-01 23:11:05'),
(9, 33, 1, 10, '2024-12-01 23:13:51', '2024-12-01 23:13:51'),
(10, 33, 1, 11, '2024-12-02 17:25:44', '2024-12-02 17:25:44'),
(11, 33, 1, 50, '2024-12-13 16:36:29', '2024-12-13 16:36:29'),
(12, 33, 1, 75, '2024-12-13 16:38:26', '2024-12-13 16:38:26'),
(13, 33, 1, 76, '2024-12-13 17:12:38', '2024-12-13 17:12:38'),
(14, 36, 17, 800, '2024-12-24 18:41:43', '2024-12-24 18:41:43'),
(15, 35, 1, 255, '2025-01-09 17:42:54', '2025-01-09 17:42:54'),
(16, 35, 1, 566, '2025-01-09 17:43:08', '2025-01-09 17:43:08'),
(17, 35, 1, 800, '2025-01-09 17:48:18', '2025-01-09 17:48:18'),
(18, 35, 1, 899, '2025-01-09 17:48:31', '2025-01-09 17:48:31'),
(19, 33, 18, 80, '2025-01-09 18:25:52', '2025-01-09 18:25:52'),
(20, 33, 1, 90, '2025-01-13 13:43:28', '2025-01-13 13:43:28'),
(21, 33, 1, 100, '2025-01-13 13:46:36', '2025-01-13 13:46:36'),
(22, 33, 1, 120, '2025-01-13 14:03:05', '2025-01-13 14:03:05'),
(23, 33, 1, 130, '2025-01-13 14:03:34', '2025-01-13 14:03:34'),
(24, 33, 1, 140, '2025-01-13 14:07:28', '2025-01-13 14:07:28'),
(25, 35, 1, 1000, '2025-01-13 14:27:35', '2025-01-13 14:27:35'),
(26, 38, 1, 6, '2025-01-13 14:30:55', '2025-01-13 14:30:55'),
(27, 53, 1, 305, '2025-01-13 14:51:58', '2025-01-13 14:51:58');

-- --------------------------------------------------------

--
-- Estrutura da tabela `carrinho`
--

CREATE TABLE `carrinho` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `nome` varchar(30) DEFAULT NULL,
  `email` varchar(30) NOT NULL,
  `mensagem` text CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `enviado_a` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `feedback`
--

INSERT INTO `feedback` (`id`, `nome`, `email`, `mensagem`, `enviado_a`) VALUES
(1, 'Saul', '', 'teste', '2024-12-10'),
(2, 'teste', '', 'teste', '2024-12-10'),
(3, 'teste', 'teste', 'terdsra', '2024-12-10'),
(4, 'Saul', 'Marques', 'Olá gostei', '2024-12-13'),
(5, 'tste', 'teste@email.com', 'teste', '2024-12-13');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

CREATE TABLE `produto` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `titulo` varchar(30) NOT NULL,
  `descricao` text NOT NULL,
  `preco` float NOT NULL,
  `imagem` varchar(80) DEFAULT NULL,
  `adicionado_a` date NOT NULL DEFAULT current_timestamp(),
  `visivel` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Extraindo dados da tabela `produto`
--

INSERT INTO `produto` (`id`, `user_id`, `titulo`, `descricao`, `preco`, `imagem`, `adicionado_a`, `visivel`) VALUES
(32, 1, 'Produto 1', 'Produto teste, depois de apagar os outros todos', 30.5, NULL, '2024-12-01', 1),
(33, 1, 'Carro bacano', 'Carro muito bom', 500000, NULL, '2024-12-01', 1),
(34, 13, 'Carro bem podre', 'Carro nÃ£o vale grande coisa', 100.5, NULL, '2024-12-01', 1),
(35, 2, 'Peruca Usada', 'Peruca JÃ¡ usada no halloween', 200, NULL, '2024-12-01', 1),
(36, 2, 'Carro ok', 'Carro esteve presente num acidente LIGEIRO e ficou traumatizado', 2000, NULL, '2024-12-01', 1),
(37, 12, 'Crocodilo barato', 'Crocodilo proveniente de fontes fidedignas', 70, NULL, '2024-12-01', 1),
(38, 1, 'Teste data', 'Teste para ver', 85.56, NULL, '2024-12-01', 1),
(39, 1, 'teste preco 2', 'teste preco 2', 999, NULL, '2024-12-09', 1),
(40, 1, 'Teste preco 2', 'teste', 75.45, 'imgs/40/colin-watts-EPcaJRJm7YA-unsplash.jpg', '2024-12-10', 1),
(41, 1, 'teste pastas 2q', '454588', 78, 'imgs/produtos/41/colin-watts-EPcaJRJm7YA-unsplash.jpg', '2024-12-10', 1),
(49, 1, 'Carro muito bom', 'Carro mesmo fixe, quem conduz é mesmo bacano', 10000, 'imgs/produtos/49/passat1.png', '2024-12-24', 1),
(50, 18, 'teste final', 'teste', 7555, '../imgs/produtos/50/Imagem WhatsApp 2024-06-28 às 11.03.49_9d0eed3a.jpg', '2025-01-09', 0),
(51, 18, 'teste final 2', 'teste', 825, '../imgs/produtos/51/Imagem WhatsApp 2024-06-28 às 11.03.49_9d0eed3a.jpg', '2025-01-09', 0),
(52, 18, 'teste final 3', 'test 3', 852, 'imgs/produtos/52/raf,360x360,075,t,fafafa_ca443f4786.jpg', '2025-01-09', 0),
(53, 2, 'Backets Racing', 'último teste', 300, 'imgs/produtos/53/Captura de ecrã 2024-03-02 122008.png', '2025-01-13', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto_imagens`
--

CREATE TABLE `produto_imagens` (
  `id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Extraindo dados da tabela `produto_imagens`
--

INSERT INTO `produto_imagens` (`id`, `produto_id`, `image_path`) VALUES
(24, 32, 'imgs/Kookaburra-best.jpeg'),
(25, 32, 'imgs/2810-Crocodilo-gigante-layout_site.png'),
(26, 33, 'imgs/a67484147bae5b62c7b522653ee14229-1-600x630.jpg'),
(27, 34, 'imgs/dsc_5073.png'),
(28, 35, 'imgs/peruca-70-s-homem.jpg'),
(29, 36, 'imgs/honda_civic_1995_honda_civic_vtec_1_5i_ls_900_euro_7390126691242405423.jpg'),
(30, 36, 'imgs/465541280_10226387419460389_8685852876173240736_n.jpg'),
(31, 37, 'imgs/2810-Crocodilo-gigante-layout_site.png'),
(32, 38, 'imgs/pngtree-calendar-png-image_9167279.png'),
(33, 39, 'imgs/sora-sagano-Dksk8szLRN0-unsplash.jpg'),
(34, 40, 'imgs/40/colin-watts-EPcaJRJm7YA-unsplash.jpg'),
(35, 41, 'imgs/produtos/41/colin-watts-EPcaJRJm7YA-unsplash.jpg'),
(36, 41, 'imgs/produtos/41/ivana-cajina-HDd-NQ_AMNQ-unsplash.jpg'),
(37, 41, 'imgs/produtos/41/samuel-ferrara-dKJXkKCF2D8-unsplash.jpg'),
(38, 41, 'imgs/produtos/41/sora-sagano-Dksk8szLRN0-unsplash.jpg'),
(39, 41, 'imgs/produtos/41/wu-yi-viMzRtv316k-unsplash.jpg'),
(54, 49, 'imgs/produtos/49/passat1.png'),
(55, 49, 'imgs/produtos/49/passat2.png'),
(56, 50, '../imgs/produtos/50/Imagem WhatsApp 2024-06-28 às 11.03.49_9d0eed3a.jpg'),
(57, 51, '../imgs/produtos/51/Imagem WhatsApp 2024-06-28 às 11.03.49_9d0eed3a.jpg'),
(58, 52, 'imgs/produtos/52/raf,360x360,075,t,fafafa_ca443f4786.jpg'),
(59, 53, 'imgs/produtos/53/Captura de ecrã 2024-03-02 122008.png'),
(60, 53, 'imgs/produtos/53/Captura de ecrã 2024-03-02 122029.png'),
(61, 53, 'imgs/produtos/53/Captura de ecrã 2024-03-02 122048.png'),
(62, 53, 'imgs/produtos/53/Captura de ecrã 2024-03-02 122205.png'),
(63, 53, 'imgs/produtos/53/Captura de ecrã 2024-03-08 141501.png'),
(64, 53, 'imgs/produtos/53/Captura de ecrã 2024-03-08 141533.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(78) NOT NULL,
  `email` varchar(30) NOT NULL,
  `imagem` varchar(255) DEFAULT 'imgs/icons/account_circle.svg',
  `localidade` varchar(255) DEFAULT NULL,
  `cidade` varchar(150) DEFAULT NULL,
  `cp` varchar(7) DEFAULT NULL,
  `telemovel` int(16) DEFAULT NULL,
  `biografia` text DEFAULT NULL,
  `data` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `imagem`, `localidade`, `cidade`, `cp`, `telemovel`, `biografia`, `data`) VALUES
(1, 'Saul', '$2y$10$gcDnaR3v/pE54FLYlzDQ8.JuwhLjQQEFEzVmm4i0CErOnXX8JypUu', 'saul_marques10@hotmail.com', 'imgs/icons/account_circle.svg', 'Casais do Campo', 'Coimbra', '3045383', 926382343, 'Biografia mm top', '2024-11-12'),
(2, 'Henrique', '$2y$10$zuZA/4LXwtyExEwCxnZOLevb1a8uBJPAftlmNQg.ra0VOy83oY8m6', 'henrique@example.com', 'imgs/icons/account_circle.svg', NULL, NULL, NULL, NULL, 'OlÃ¡, sou o Henrique ', '2024-11-12'),
(7, 'Aleijado', '$2y$10$6gCSF96YLafzq45zn25ptux4/vb/R5dUfmdHw6Bue2.VTpdeDGkpG', 'aleijado@email.com', 'imgs/icons/account_circle.svg', NULL, NULL, NULL, NULL, NULL, '2024-11-12'),
(9, 'becas', '$2y$10$TE.aRvUHcvuD4Ko3KVVksuWvVGp7K04j/GQDRStqTqh0EkcU61GCK', 'gajaqueamaosaul@gmail.com', 'imgs/icons/account_circle.svg', NULL, NULL, NULL, NULL, NULL, '2024-11-12'),
(10, 'Vicente', '$2y$10$CmnENrM2jS5axk.v2t33p.G/adOe9nKZuQ.9WTBXPQKmtMreqZtGG', 'vicente@gmail.com', 'imgs/icons/account_circle.svg', NULL, NULL, NULL, NULL, NULL, '2024-11-12'),
(11, 'Vicente Rizza', '$2y$10$iWkE82x7RF91zlHjZXNNTuLgxr9wdH0iB1LgPoeqUssPHunS6jGv.', 'vicentedarizz@gmail.com', 'imgs/icons/account_circle.svg', NULL, NULL, NULL, NULL, NULL, '2024-11-12'),
(12, 'Pedro Moreira', '$2y$10$WZwyCsedl5.gl/tdgSE2memc3VHiuEPCmFqvV58hWpo9FpJ4qaMIC', 'pedromoreira@gay.com', 'imgs/icons/account_circle.svg', NULL, NULL, NULL, NULL, NULL, '2024-11-12'),
(13, 'Pedro Santos', '$2y$10$2i1vZ85FK8p91s7yXYcCJezUPjvGPB6XbaUS1wVN38w.q7Un2eHZ6', 'aleijado@gmail.com', 'imgs/icons/account_circle.svg', NULL, NULL, NULL, NULL, NULL, '2024-11-25'),
(14, 'teste1', '$2y$10$xyF4OP6g2FJEd2EFPFohkuOZjftzvS8vRT0cYm0eI1FxuRkl4vOi6', 'teste1@gmail.com', 'imgs/icons/account_circle.svg', NULL, NULL, NULL, NULL, NULL, '2024-12-02'),
(15, 'teste1', '$2y$10$9Ec/X8ULfnEJmNl1oB8zbeGlmygV7YYmqOntpxs9Oq4QoGF1lVn0e', 'teste1@gmail.com', 'imgs/icons/account_circle.svg', NULL, NULL, NULL, NULL, NULL, '2024-12-02'),
(16, 'teste', '$2y$10$.ZbTboGr.8MALwGWCEBIXOzCNgv1H.fUN2ly2j5WtzpC5VjL5PCye', 'saul@mail', 'imgs/icons/account_circle.svg', NULL, NULL, NULL, NULL, NULL, '2024-12-24'),
(17, 'Saul', '$2y$10$p1I06dBGlVqSQSqAMxdn2.g2Nlx33oPefmIfMOcLITt6vOg3S7zo2', 'saul@mail.com', 'imgs/icons/account_circle.svg', NULL, NULL, NULL, NULL, '', '2024-12-24'),
(18, 'teste', '$2y$10$ux9vMs/rnMunAvOg4LnrMOjSSjZ.aUh0CcyD848RE0vTYFk/ioEkW', 'teste@mail.com', 'imgs/icons/account_circle.svg', NULL, NULL, NULL, NULL, NULL, '2025-01-09');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `bids`
--
ALTER TABLE `bids`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produto_id` (`produto_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Índices para tabela `carrinho`
--
ALTER TABLE `carrinho`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users` (`user_id`),
  ADD KEY `fk_products` (`produto_id`);

--
-- Índices para tabela `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`user_id`);

--
-- Índices para tabela `produto_imagens`
--
ALTER TABLE `produto_imagens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_produto` (`produto_id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `bids`
--
ALTER TABLE `bids`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `carrinho`
--
ALTER TABLE `carrinho`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de tabela `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de tabela `produto_imagens`
--
ALTER TABLE `produto_imagens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `bids`
--
ALTER TABLE `bids`
  ADD CONSTRAINT `bids_ibfk_1` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bids_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `carrinho`
--
ALTER TABLE `carrinho`
  ADD CONSTRAINT `fk_products` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `produto_imagens`
--
ALTER TABLE `produto_imagens`
  ADD CONSTRAINT `fk_produto` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
