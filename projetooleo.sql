-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 25/06/2025 às 21:39
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `projetooleo`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `coletas`
--

CREATE TABLE `coletas` (
  `id_coleta` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_empresa` int(11) DEFAULT NULL,
  `quantidade` int(11) NOT NULL,
  `status` varchar(50) DEFAULT 'pendente',
  `confirmacao_usuario` tinyint(1) DEFAULT 0,
  `confirmacao_empresa` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `coletas`
--

INSERT INTO `coletas` (`id_coleta`, `id_usuario`, `id_empresa`, `quantidade`, `status`, `confirmacao_usuario`, `confirmacao_empresa`) VALUES
(1, 1, 1, 7, 'aceita', 0, 1),
(2, 3, 1, 20, 'aceita', 0, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `empresa`
--

CREATE TABLE `empresa` (
  `id_empresa` int(11) NOT NULL,
  `nome_fantasia` varchar(100) NOT NULL,
  `logradouro_empresa` varchar(150) NOT NULL,
  `telefone_empresa` varchar(20) DEFAULT NULL,
  `email_empresa` varchar(150) DEFAULT NULL,
  `senha` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `empresa`
--

INSERT INTO `empresa` (`id_empresa`, `nome_fantasia`, `logradouro_empresa`, `telefone_empresa`, `email_empresa`, `senha`) VALUES
(1, 'Eco óleo', 'Rua Imaculada', NULL, 'ecooleo@org.com', '1234');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `logradouro_usuario` varchar(150) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(12) NOT NULL,
  `qtd_oleo` int(11) DEFAULT NULL,
  `solicitado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome`, `logradouro_usuario`, `email`, `senha`, `qtd_oleo`, `solicitado`) VALUES
(1, 'Guilherme', 'Rua Almir', 'gui@gmail.com', '1234', 0, 1),
(2, 'José', 'Rua Azevedo', 'jose@gmail.com', '1234', 3, 0),
(3, 'Restaurante Moenda', 'Rua Veneza', 'restaurante@gmail.com', '1234', 0, 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `coletas`
--
ALTER TABLE `coletas`
  ADD PRIMARY KEY (`id_coleta`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- Índices de tabela `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id_empresa`),
  ADD UNIQUE KEY `email_empresa` (`email_empresa`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `coletas`
--
ALTER TABLE `coletas`
  MODIFY `id_coleta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id_empresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `coletas`
--
ALTER TABLE `coletas`
  ADD CONSTRAINT `coletas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `coletas_ibfk_2` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
