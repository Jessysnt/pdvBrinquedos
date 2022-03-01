-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 01-Mar-2022 às 03:31
-- Versão do servidor: 10.4.22-MariaDB
-- versão do PHP: 8.0.15

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

--
-- Extraindo dados da tabela `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `id_usuario`, `nome_categoria`, `descricao`, `dataCaptura`) VALUES
(17, 13, '0 a 5meses', 'Brinquedos com som e que possam morder', '2021-11-10'),
(19, 13, '6meses a 1 ano', 'Brinquedos de cubos, argolas, caixas que encaixam ', '2021-11-24'),
(29, 13, 'kkk', 'llll', '2021-12-29');

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
-- Estrutura da tabela `estoque`
--

CREATE TABLE `estoque` (
  `id_estoque` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `quantotal` int(11) NOT NULL,
  `preco_ven` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `estoque`
--

INSERT INTO `estoque` (`id_estoque`, `id_produto`, `quantotal`, `preco_ven`) VALUES
(1, 2, 7, '5.90'),
(2, 3, 10, '9.90');

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
-- Estrutura da tabela `imagens`
--

CREATE TABLE `imagens` (
  `id_imagem` int(11) NOT NULL,
  `nome` varchar(250) NOT NULL,
  `url` varchar(300) NOT NULL,
  `dataUpload` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `imagens`
--

INSERT INTO `imagens` (`id_imagem`, `nome`, `url`, `dataUpload`) VALUES
(2, 'woody.jpg', '../../arquivos/woody.jpg', '2022-02-25 23:07:11'),
(3, 'carro1.jpg', '../../arquivos/carro1.jpg', '2022-02-26 03:46:59');

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
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `id_produto` int(11) NOT NULL,
  `id_imagem` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(250) NOT NULL,
  `descricao` varchar(250) NOT NULL,
  `dataCaptura` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id_produto`, `id_imagem`, `id_usuario`, `nome`, `descricao`, `dataCaptura`) VALUES
(2, 2, 13, 'Woody Cowboy.', 'Toy Story.', '2022-02-25 23:07:11'),
(3, 3, 13, 'Relâmpago McQueen ', 'Disney', '2022-02-26 03:46:59');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtov`
--

CREATE TABLE `produtov` (
  `id_prodv` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `lote` varchar(100) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `preco_comp` decimal(10,2) NOT NULL,
  `preco_ven` decimal(10,2) NOT NULL,
  `dataCaptura` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `produtov`
--

INSERT INTO `produtov` (`id_prodv`, `id_usuario`, `id_produto`, `lote`, `quantidade`, `preco_comp`, `preco_ven`, `dataCaptura`) VALUES
(1, 13, 2, '1', 2, '10.00', '4.00', '2022-02-25 23:21:15'),
(3, 13, 2, '2', 5, '11.90', '2.90', '2022-02-26 03:43:42'),
(4, 13, 3, '1', 2, '11.00', '9.90', '2022-02-26 18:07:10'),
(5, 13, 3, '2', 8, '14.90', '8.90', '2022-02-26 18:09:09');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `user` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `cargo` varchar(150) NOT NULL,
  `dataCaptura` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `user`, `email`, `senha`, `cargo`, `dataCaptura`) VALUES
(13, 'Admin', 'admin', 'admin@reino.com', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin', '2021-11-09'),
(14, 'Vendedor T', 'vendedor1', 'vendas@reino.com', '88d6818710e371b461efff33d271e0d2fb6ccf47', 'Vendedor', '2021-11-09'),
(15, 'SUper', 'teste', 'caixa@reino.com', '81dbefaf6d02f0f52d2ac05359c25385a96c7ca4', 'Supervisor', '2022-01-16');

-- --------------------------------------------------------

--
-- Estrutura da tabela `vendas`
--

CREATE TABLE `vendas` (
  `id_venda` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `preco` float NOT NULL,
  `quantidade` int(11) NOT NULL,
  `total_venda` float NOT NULL,
  `nome_pagamento` varchar(150) NOT NULL,
  `dataCompra` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `vendas`
--

INSERT INTO `vendas` (`id_venda`, `id_cliente`, `id_produto`, `id_usuario`, `preco`, `quantidade`, `total_venda`, `nome_pagamento`, `dataCompra`) VALUES
(1, 29, 30, 13, 150, 1, 150, 'Credito', '2021-12-28'),
(2, 39, 30, 13, 150, 1, 150, 'Débito', '2021-12-28'),
(3, 0, 31, 13, 130, 1, 130, 'Débito', '2021-12-29'),
(3, 0, 30, 13, 150, 1, 150, 'Débito', '2021-12-29'),
(3, 29, 31, 13, 130, 2, 260, 'Débito', '2021-12-29'),
(4, 0, 31, 13, 130, 1, 130, '', '2021-12-29'),
(5, 29, 30, 13, 150, 2, 300, '', '2022-02-20');

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
-- Índices para tabela `estoque`
--
ALTER TABLE `estoque`
  ADD PRIMARY KEY (`id_estoque`);

--
-- Índices para tabela `fornecedores`
--
ALTER TABLE `fornecedores`
  ADD PRIMARY KEY (`id_fornecedor`);

--
-- Índices para tabela `imagens`
--
ALTER TABLE `imagens`
  ADD PRIMARY KEY (`id_imagem`);

--
-- Índices para tabela `pagamentos`
--
ALTER TABLE `pagamentos`
  ADD PRIMARY KEY (`id_pagamento`);

--
-- Índices para tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id_produto`);

--
-- Índices para tabela `produtov`
--
ALTER TABLE `produtov`
  ADD PRIMARY KEY (`id_prodv`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
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
-- AUTO_INCREMENT de tabela `estoque`
--
ALTER TABLE `estoque`
  MODIFY `id_estoque` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `fornecedores`
--
ALTER TABLE `fornecedores`
  MODIFY `id_fornecedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `imagens`
--
ALTER TABLE `imagens`
  MODIFY `id_imagem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `pagamentos`
--
ALTER TABLE `pagamentos`
  MODIFY `id_pagamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `produtov`
--
ALTER TABLE `produtov`
  MODIFY `id_prodv` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
