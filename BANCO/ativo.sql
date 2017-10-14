-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 20-Set-2016 às 22:56
-- Versão do servidor: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ativo`
--
CREATE DATABASE IF NOT EXISTS `ativo` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `ativo`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `contas`
--

CREATE TABLE IF NOT EXISTS `contas` (
`idContas` int(11) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `qtd_parcelas` int(3) NOT NULL,
  `total` varchar(10) NOT NULL,
  `status` varchar(30) NOT NULL,
  `NFs_idNFs` int(11) NOT NULL,
  `NFs_Unidade_fornecedor_idUnidade_fornecedor` int(11) NOT NULL,
  `NFs_Unidade_fornecedor_fornecedor_idFornecedor` int(11) NOT NULL,
  `NFs_Sucursal_idSucursal` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `duplicatas`
--

CREATE TABLE IF NOT EXISTS `duplicatas` (
`idDuplicatas` int(11) NOT NULL,
  `valor` varchar(10) NOT NULL,
  `valor_pago` varchar(10) DEFAULT '0,00',
  `vencimento` date NOT NULL,
  `posicao_parcela` smallint(3) NOT NULL,
  `status` enum('pendente','boleto recebido','pago','em cartório','ajuizado') NOT NULL DEFAULT 'pendente',
  `obs` text NOT NULL,
  `Contas_idContas` int(11) NOT NULL,
  `Contas_NFs_idNFs` int(11) NOT NULL,
  `Contas_NFs_Unidade_fornecedor_idUnidade_fornecedor` int(11) NOT NULL,
  `Contas_NFs_Unidade_fornecedor_fornecedor_idFornecedor` int(11) NOT NULL,
  `Contas_NFs_Sucursal_idSucursal` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fornecedor`
--

CREATE TABLE IF NOT EXISTS `fornecedor` (
`idFornecedor` int(11) NOT NULL,
  `fantasia` varchar(45) NOT NULL,
  `status` enum('A','I') NOT NULL DEFAULT 'A'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `marcas`
--

CREATE TABLE IF NOT EXISTS `marcas` (
`idMarca` int(11) NOT NULL,
  `nome_marca` varchar(45) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `marcas_has_fornecedor`
--

CREATE TABLE IF NOT EXISTS `marcas_has_fornecedor` (
  `Marcas_idMarca` int(11) NOT NULL,
  `fornecedor_idFornecedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `marcas_has_representantes`
--

CREATE TABLE IF NOT EXISTS `marcas_has_representantes` (
  `marcas_idMarca` int(11) NOT NULL,
  `representantes_idRepresentante` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `nfs`
--

CREATE TABLE IF NOT EXISTS `nfs` (
`idNFs` int(11) NOT NULL,
  `chave` varchar(44) NOT NULL,
  `numero` varchar(8) DEFAULT NULL,
  `valor_total` varchar(10) DEFAULT NULL,
  `valor_liquido` varchar(10) NOT NULL,
  `desconto` varchar(10) NOT NULL,
  `status` varchar(15) DEFAULT NULL,
  `Unidade_fornecedor_idUnidade_fornecedor` int(11) NOT NULL,
  `Unidade_fornecedor_fornecedor_idFornecedor` int(11) NOT NULL,
  `Sucursal_idSucursal` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `representantes`
--

CREATE TABLE IF NOT EXISTS `representantes` (
`idRepresentante` int(11) NOT NULL,
  `apelido` varchar(45) DEFAULT NULL,
  `nome` varchar(120) NOT NULL,
  `tel1` varchar(45) DEFAULT NULL,
  `tel2` varchar(45) DEFAULT NULL,
  `tel3` varchar(45) DEFAULT NULL,
  `tel4` varchar(45) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `site` varchar(100) DEFAULT NULL,
  `obs` mediumtext
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `representantes_has_fornecedor`
--

CREATE TABLE IF NOT EXISTS `representantes_has_fornecedor` (
  `representantes_idRepresentante` int(11) NOT NULL,
  `fornecedor_idFornecedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sucursal`
--

CREATE TABLE IF NOT EXISTS `sucursal` (
`idSucursal` int(11) NOT NULL,
  `sigla` varchar(10) DEFAULT NULL,
  `cnpj` varchar(14) DEFAULT NULL,
  `insc_est` varchar(20) DEFAULT NULL,
  `status` tinyint(3) DEFAULT '1'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `unidade_fornecedor`
--

CREATE TABLE IF NOT EXISTS `unidade_fornecedor` (
`idUnidade_fornecedor` int(11) NOT NULL,
  `razao` tinytext NOT NULL,
  `cnpj` varchar(14) NOT NULL,
  `insc_est` varchar(20) DEFAULT NULL,
  `obs` mediumtext,
  `nome_logradouro` varchar(100) DEFAULT NULL,
  `numero` varchar(6) DEFAULT NULL,
  `complemento` mediumtext,
  `CEP` decimal(8,0) DEFAULT NULL,
  `UF` varchar(2) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `bairro` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `tel1` varchar(20) DEFAULT NULL,
  `tel2` varchar(20) DEFAULT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `status` enum('A','I') DEFAULT 'A',
  `fornecedor_idFornecedor` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
`idusuario` int(11) NOT NULL,
  `usuario` varchar(45) DEFAULT NULL,
  `senha` varchar(8) DEFAULT NULL,
  `grau_acesso` varchar(3) DEFAULT NULL,
  `nome` varchar(45) DEFAULT NULL,
  `cargo` varchar(45) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contas`
--
ALTER TABLE `contas`
 ADD PRIMARY KEY (`idContas`,`NFs_idNFs`,`NFs_Unidade_fornecedor_idUnidade_fornecedor`,`NFs_Unidade_fornecedor_fornecedor_idFornecedor`,`NFs_Sucursal_idSucursal`), ADD KEY `fk_Contas_NFs1_idx` (`NFs_idNFs`,`NFs_Unidade_fornecedor_idUnidade_fornecedor`,`NFs_Unidade_fornecedor_fornecedor_idFornecedor`,`NFs_Sucursal_idSucursal`);

--
-- Indexes for table `duplicatas`
--
ALTER TABLE `duplicatas`
 ADD PRIMARY KEY (`idDuplicatas`,`Contas_idContas`,`Contas_NFs_idNFs`,`Contas_NFs_Unidade_fornecedor_idUnidade_fornecedor`,`Contas_NFs_Unidade_fornecedor_fornecedor_idFornecedor`,`Contas_NFs_Sucursal_idSucursal`), ADD KEY `fk_Duplicatas_Contas1_idx` (`Contas_idContas`,`Contas_NFs_idNFs`,`Contas_NFs_Unidade_fornecedor_idUnidade_fornecedor`,`Contas_NFs_Unidade_fornecedor_fornecedor_idFornecedor`,`Contas_NFs_Sucursal_idSucursal`);

--
-- Indexes for table `fornecedor`
--
ALTER TABLE `fornecedor`
 ADD PRIMARY KEY (`idFornecedor`);

--
-- Indexes for table `marcas`
--
ALTER TABLE `marcas`
 ADD PRIMARY KEY (`idMarca`), ADD UNIQUE KEY `nome_marca` (`nome_marca`);

--
-- Indexes for table `marcas_has_fornecedor`
--
ALTER TABLE `marcas_has_fornecedor`
 ADD PRIMARY KEY (`Marcas_idMarca`,`fornecedor_idFornecedor`), ADD KEY `fk_Marcas_has_fornecedor_fornecedor1_idx` (`fornecedor_idFornecedor`), ADD KEY `fk_Marcas_has_fornecedor_Marcas1_idx` (`Marcas_idMarca`);

--
-- Indexes for table `marcas_has_representantes`
--
ALTER TABLE `marcas_has_representantes`
 ADD PRIMARY KEY (`marcas_idMarca`,`representantes_idRepresentante`), ADD KEY `fk_marcas_has_representantes_representantes1_idx` (`representantes_idRepresentante`), ADD KEY `fk_marcas_has_representantes_marcas1_idx` (`marcas_idMarca`);

--
-- Indexes for table `nfs`
--
ALTER TABLE `nfs`
 ADD PRIMARY KEY (`idNFs`,`Unidade_fornecedor_idUnidade_fornecedor`,`Unidade_fornecedor_fornecedor_idFornecedor`,`Sucursal_idSucursal`), ADD UNIQUE KEY `chave` (`chave`), ADD KEY `fk_NFs_Unidade_fornecedor1_idx` (`Unidade_fornecedor_idUnidade_fornecedor`,`Unidade_fornecedor_fornecedor_idFornecedor`), ADD KEY `fk_NFs_Sucursal1_idx` (`Sucursal_idSucursal`);

--
-- Indexes for table `representantes`
--
ALTER TABLE `representantes`
 ADD PRIMARY KEY (`idRepresentante`);

--
-- Indexes for table `representantes_has_fornecedor`
--
ALTER TABLE `representantes_has_fornecedor`
 ADD PRIMARY KEY (`representantes_idRepresentante`,`fornecedor_idFornecedor`), ADD KEY `fk_representantes_has_fornecedor_fornecedor1_idx` (`fornecedor_idFornecedor`), ADD KEY `fk_representantes_has_fornecedor_representantes1_idx` (`representantes_idRepresentante`);

--
-- Indexes for table `sucursal`
--
ALTER TABLE `sucursal`
 ADD PRIMARY KEY (`idSucursal`);

--
-- Indexes for table `unidade_fornecedor`
--
ALTER TABLE `unidade_fornecedor`
 ADD PRIMARY KEY (`idUnidade_fornecedor`,`fornecedor_idFornecedor`), ADD KEY `fk_unidade_fornecedor_fornecedor_idx` (`fornecedor_idFornecedor`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
 ADD PRIMARY KEY (`idusuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contas`
--
ALTER TABLE `contas`
MODIFY `idContas` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `duplicatas`
--
ALTER TABLE `duplicatas`
MODIFY `idDuplicatas` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `fornecedor`
--
ALTER TABLE `fornecedor`
MODIFY `idFornecedor` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `marcas`
--
ALTER TABLE `marcas`
MODIFY `idMarca` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `nfs`
--
ALTER TABLE `nfs`
MODIFY `idNFs` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `representantes`
--
ALTER TABLE `representantes`
MODIFY `idRepresentante` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `sucursal`
--
ALTER TABLE `sucursal`
MODIFY `idSucursal` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `unidade_fornecedor`
--
ALTER TABLE `unidade_fornecedor`
MODIFY `idUnidade_fornecedor` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `contas`
--
ALTER TABLE `contas`
ADD CONSTRAINT `fk_Contas_NFs1` FOREIGN KEY (`NFs_idNFs`, `NFs_Unidade_fornecedor_idUnidade_fornecedor`, `NFs_Unidade_fornecedor_fornecedor_idFornecedor`, `NFs_Sucursal_idSucursal`) REFERENCES `nfs` (`idNFs`, `Unidade_fornecedor_idUnidade_fornecedor`, `Unidade_fornecedor_fornecedor_idFornecedor`, `Sucursal_idSucursal`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `duplicatas`
--
ALTER TABLE `duplicatas`
ADD CONSTRAINT `fk_Duplicatas_Contas1` FOREIGN KEY (`Contas_idContas`, `Contas_NFs_idNFs`, `Contas_NFs_Unidade_fornecedor_idUnidade_fornecedor`, `Contas_NFs_Unidade_fornecedor_fornecedor_idFornecedor`, `Contas_NFs_Sucursal_idSucursal`) REFERENCES `contas` (`idContas`, `NFs_idNFs`, `NFs_Unidade_fornecedor_idUnidade_fornecedor`, `NFs_Unidade_fornecedor_fornecedor_idFornecedor`, `NFs_Sucursal_idSucursal`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `marcas_has_fornecedor`
--
ALTER TABLE `marcas_has_fornecedor`
ADD CONSTRAINT `fk_Marcas_has_fornecedor_Marcas1` FOREIGN KEY (`Marcas_idMarca`) REFERENCES `marcas` (`idMarca`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_Marcas_has_fornecedor_fornecedor1` FOREIGN KEY (`fornecedor_idFornecedor`) REFERENCES `fornecedor` (`idFornecedor`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `marcas_has_representantes`
--
ALTER TABLE `marcas_has_representantes`
ADD CONSTRAINT `fk_marcas_has_representantes_marcas1` FOREIGN KEY (`marcas_idMarca`) REFERENCES `marcas` (`idMarca`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_marcas_has_representantes_representantes1` FOREIGN KEY (`representantes_idRepresentante`) REFERENCES `representantes` (`idRepresentante`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `nfs`
--
ALTER TABLE `nfs`
ADD CONSTRAINT `fk_NFs_Sucursal1` FOREIGN KEY (`Sucursal_idSucursal`) REFERENCES `sucursal` (`idSucursal`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_NFs_Unidade_fornecedor1` FOREIGN KEY (`Unidade_fornecedor_idUnidade_fornecedor`, `Unidade_fornecedor_fornecedor_idFornecedor`) REFERENCES `unidade_fornecedor` (`idUnidade_fornecedor`, `fornecedor_idFornecedor`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `representantes_has_fornecedor`
--
ALTER TABLE `representantes_has_fornecedor`
ADD CONSTRAINT `fk_representantes_has_Fornecedor_representantes1` FOREIGN KEY (`representantes_idRepresentante`) REFERENCES `representantes` (`idRepresentante`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `fk_representantes_has_fornecedor_fornecedor1` FOREIGN KEY (`fornecedor_idFornecedor`) REFERENCES `fornecedor` (`idFornecedor`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `unidade_fornecedor`
--
ALTER TABLE `unidade_fornecedor`
ADD CONSTRAINT `fk_unidade_fornecedor_fornecedor` FOREIGN KEY (`fornecedor_idFornecedor`) REFERENCES `fornecedor` (`idFornecedor`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
