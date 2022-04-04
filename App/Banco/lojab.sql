-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 31-Mar-2022 às 05:50
-- Versão do servidor: 10.4.22-MariaDB
-- versão do PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `lojab`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nome_categoria` varchar(100) NOT NULL,
  `descricao` varchar(200) NOT NULL,
  `dataCaptura` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `sobrenome` varchar(100) NOT NULL,
  `endereco` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefone` varchar(100) NOT NULL,
  `cpf` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `id_usuario`, `nome`, `sobrenome`, `endereco`, `email`, `telefone`, `cpf`) VALUES
(29, 13, 'Teste1', 'Teste1', 'rua 1', 'Teste1@gmail.com', '(12)99200-0000', '999.999.999-99'),
(39, 13, 'Teste4', 'quatro', 'rua 4', 'quatro@gmai.com', '(12)99900-0999', '493.465.659-69'),
(40, 13, 'Teste5', 'Teste5', 'Teste5', 'Teste5@gmail.com', '(12)98888-8888', '493.465.659-69'),
(41, 13, 'Tatiane', 'Duarte', 'rua 10, 12', 'tatiane@gmail.com', '(12)90000-0099', '493.465.659-69'),
(42, 13, 'Teste3', 'Teste3', 'Teste3', 'teste3@gmail.com', '(39)33333-3330', '493.465.659-69'),
(43, 13, 'Lenovo', 'novo', 'Rua 2, n10', 'lenovo@gmail.com', '(12)90909-090', '493.465.659-69'),
(46, 13, 'Umteste', 'Umteste', 'Umteste', 'Umteste@kk.com', '(99)99999-9999', '856.770.521-59'),
(47, 13, 'DoisTeste', 'doisteste', 'rua 10', 'doisteste@teste.com', '(12)99200-9900', '780.469.358-32');

-- --------------------------------------------------------

--
-- Estrutura da tabela `comandas`
--

CREATE TABLE `comandas` (
  `id_comanda` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `estoque`
--

CREATE TABLE `estoque` (
  `id` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `quantotal` int(11) NOT NULL,
  `preco_ven` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fornecedores`
--

CREATE TABLE `fornecedores` (
  `id_fornecedor` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `fantasia` varchar(100) NOT NULL,
  `endereco` varchar(150) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefone` varchar(100) NOT NULL,
  `cnpj` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `fornecedores`
--

INSERT INTO `fornecedores` (`id_fornecedor`, `id_usuario`, `nome`, `fantasia`, `endereco`, `email`, `telefone`, `cnpj`) VALUES
(1, 6, 'Alice', 'Santos', 'Rua Girafales', 'alicesantos@gmail.com', '1234-5678', '111.222.333-99'),
(3, 13, 'Distribuidora Bonecos', 'Bonecolandia', 'Rua2', 'bonecos@necos.com', '(99)99999-9798', '44.444.444/4409-79');

-- --------------------------------------------------------

--
-- Estrutura da tabela `imagem`
--

CREATE TABLE `imagem` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `url` varchar(150) NOT NULL,
  `registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `imagem`
--

INSERT INTO `imagem` (`id`, `nome`, `url`, `registro`) VALUES
(1, 'relampago.jpeg', 'arquivos/relampago.jpeg', '2022-03-31 01:30:00'),
(2, 'wood.jpeg', 'arquivos/wood.jpeg', '2022-03-31 01:32:47'),
(3, 'naruto1.jpg', 'arquivos/naruto1.jpg', '2022-03-31 01:33:59');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pagamentos`
--

CREATE TABLE `pagamentos` (
  `id_pagamento` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nome_pagamento` varchar(100) NOT NULL,
  `dataCaptura` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pagamentos`
--

INSERT INTO `pagamentos` (`id_pagamento`, `id_usuario`, `nome_pagamento`, `dataCaptura`) VALUES
(1, 0, 'Dinheiro', '2021-11-25'),
(2, 0, 'Débito', '2021-11-25'),
(3, 0, 'Credito', '2021-11-25'),
(4, 13, 'asad', '2021-11-26'),
(5, 13, 'aa', '2021-11-26');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

CREATE TABLE `produto` (
  `id` int(11) NOT NULL,
  `id_imagem` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` varchar(150) NOT NULL,
  `registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `produto`
--

INSERT INTO `produto` (`id`, `id_imagem`, `id_usuario`, `nome`, `descricao`, `registro`) VALUES
(1, 1, 2, 'Relâmpago', 'Mcqueen', '2022-03-31 01:30:00'),
(2, 2, 2, 'Wood', 'Toystory', '2022-03-31 01:32:47'),
(3, 3, 2, 'Naruto', 'Anime', '2022-03-31 01:33:59');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtovenda`
--

CREATE TABLE `produtovenda` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `lote` varchar(150) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `preco_comp` decimal(10,2) NOT NULL,
  `preco_ven` decimal(10,2) NOT NULL,
  `registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) CHARACTER SET utf8 NOT NULL,
  `sobrenome` varchar(100) CHARACTER SET utf8 NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 NOT NULL,
  `senha` varchar(100) CHARACTER SET utf8 NOT NULL,
  `cargo` int(11) NOT NULL,
  `registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=ascii;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `sobrenome`, `email`, `senha`, `cargo`, `registro`) VALUES
(2, 'Jessy', 'Santos', 'admin@reino.com', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, '2022-03-29 22:56:18'),
(3, 'Ravena', 'Tita', 'ravena@reino.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 2, '2022-03-30 00:40:32'),
(5, 'Robin', 'Titan', 'robin@reino.com', '8abcda2dba9a5c5c674e659333828582122c5f56', 3, '2022-03-30 00:42:33');

-- --------------------------------------------------------

--
-- Estrutura da tabela `vendas`
--

CREATE TABLE `vendas` (
  `id_venda` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `total_venda` decimal(10,2) NOT NULL,
  `nome_pagamento` varchar(150) NOT NULL,
  `dataCompra` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `vendas`
--

INSERT INTO `vendas` (`id_venda`, `id_cliente`, `id_produto`, `id_usuario`, `preco`, `quantidade`, `total_venda`, `nome_pagamento`, `dataCompra`) VALUES
(1, 29, 30, 13, '150.00', 1, '150.00', 'Credito', '2021-12-28 03:00:00'),
(2, 39, 30, 13, '150.00', 1, '150.00', 'Débito', '2021-12-28 03:00:00'),
(3, 0, 31, 13, '130.00', 1, '130.00', 'Débito', '2021-12-29 03:00:00'),
(3, 0, 30, 13, '150.00', 1, '150.00', 'Débito', '2021-12-29 03:00:00'),
(3, 29, 31, 13, '130.00', 2, '260.00', 'Débito', '2021-12-29 03:00:00'),
(4, 0, 31, 13, '130.00', 1, '130.00', '', '2021-12-29 03:00:00'),
(5, 29, 30, 13, '150.00', 2, '300.00', '', '2022-02-20 03:00:00'),
(6, 29, 2, 6, '5.90', 2, '11.80', '', '2022-03-14 03:00:00');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Índices para tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Índices para tabela `comandas`
--
ALTER TABLE `comandas`
  ADD PRIMARY KEY (`id_comanda`);

--
-- Índices para tabela `estoque`
--
ALTER TABLE `estoque`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `fornecedores`
--
ALTER TABLE `fornecedores`
  ADD PRIMARY KEY (`id_fornecedor`);

--
-- Índices para tabela `imagem`
--
ALTER TABLE `imagem`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `pagamentos`
--
ALTER TABLE `pagamentos`
  ADD PRIMARY KEY (`id_pagamento`);

--
-- Índices para tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `produtovenda`
--
ALTER TABLE `produtovenda`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de tabela `comandas`
--
ALTER TABLE `comandas`
  MODIFY `id_comanda` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `estoque`
--
ALTER TABLE `estoque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `fornecedores`
--
ALTER TABLE `fornecedores`
  MODIFY `id_fornecedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `imagem`
--
ALTER TABLE `imagem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `pagamentos`
--
ALTER TABLE `pagamentos`
  MODIFY `id_pagamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `produtovenda`
--
ALTER TABLE `produtovenda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
