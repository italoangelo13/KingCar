-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.6.43-log


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema kingcar
--

CREATE DATABASE IF NOT EXISTS kingcar;
USE kingcar;

--
-- Definition of table `carro`
--

DROP TABLE IF EXISTS `carro`;
CREATE TABLE `carro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `marca_codigo` varchar(50) NOT NULL,
  `preco` double(9,2) NOT NULL,
  `ano` varchar(4) NOT NULL,
  `foto` varchar(40) NOT NULL,
  `infos_adicionais` varchar(400) NOT NULL,
  `status` varchar(1) NOT NULL,
  `usuario_id` varchar(11) NOT NULL,
  `usuario_nome` varchar(50) NOT NULL,
  `usuario_tel1` varchar(11) NOT NULL,
  `usuario_tel2` varchar(11) DEFAULT NULL,
  `usuario_endereco` varchar(80) NOT NULL,
  `quilometragem` double(10,2) NOT NULL,
  `cambio` int(11) NOT NULL,
  `portas` int(1) NOT NULL,
  `combustivel` int(11) NOT NULL,
  `cor` int(11) NOT NULL,
  `placa` varchar(8) NOT NULL,
  `troca` varchar(1) NOT NULL,
  `CARDESTAQUE` varchar(1) NOT NULL,
  `CARDATCADASTRO` datetime NOT NULL,
  `CARUSER` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `marca_codigo` (`marca_codigo`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `carro`
--

/*!40000 ALTER TABLE `carro` DISABLE KEYS */;
/*!40000 ALTER TABLE `carro` ENABLE KEYS */;


--
-- Definition of table `contato`
--

DROP TABLE IF EXISTS `contato`;
CREATE TABLE `contato` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `situacao` varchar(1) NOT NULL,
  `mensagem` varchar(400) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contato`
--

/*!40000 ALTER TABLE `contato` DISABLE KEYS */;
/*!40000 ALTER TABLE `contato` ENABLE KEYS */;


--
-- Definition of table `kgctblcam`
--

DROP TABLE IF EXISTS `kgctblcam`;
CREATE TABLE `kgctblcam` (
  `CAMCOD` int(11) NOT NULL AUTO_INCREMENT,
  `CAMDESCRICAO` varchar(50) NOT NULL,
  `CAMDATCADASTRO` datetime NOT NULL,
  `CAMUSER` varchar(50) NOT NULL,
  PRIMARY KEY (`CAMCOD`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kgctblcam`
--

/*!40000 ALTER TABLE `kgctblcam` DISABLE KEYS */;
INSERT INTO `kgctblcam` (`CAMCOD`,`CAMDESCRICAO`,`CAMDATCADASTRO`,`CAMUSER`) VALUES 
 (1,'MANUAL','2019-12-03 00:00:00','ADMIN'),
 (2,'AUTOMÁTICO','2019-12-03 00:00:00','ADMIN');
/*!40000 ALTER TABLE `kgctblcam` ENABLE KEYS */;


--
-- Definition of table `KGCTBLCAR`
--

DROP TABLE IF EXISTS `KGCTBLCAR`;
CREATE TABLE `KGCTBLCAR` (
  `CARCOD` int(11) NOT NULL AUTO_INCREMENT,
  `CARNOME` varchar(50) NOT NULL,
  `CARCODMARCA` int(11) NOT NULL,
  `CARCODMODELO` int(11) NOT NULL,
  `CARPRECO` double(9,2) NOT NULL,
  `CARANO` varchar(4) NOT NULL,
  `CARFOTO` varchar(255) NOT NULL,
  `CARCODSTATUS` int(11) NOT NULL,
  `CARKM` double(10,2) NOT NULL,
  `CARCODCAMBIO` int(11) NOT NULL,
  `CARPORTAS` int(1) NOT NULL,
  `CARCODCOMBUSTIVEL` int(11) NOT NULL,
  `CARCODCOR` int(11) NOT NULL,
  `CARPLACA` varchar(8) NOT NULL,
  `CARTROCA` varchar(1) NOT NULL,
  `CARDESTAQUE` varchar(1) NOT NULL,
  `CARDATCADASTRO` datetime NOT NULL,
  `CARUSER` varchar(50) NOT NULL,
  PRIMARY KEY (`CARCOD`),
  KEY `CARCODMARCA` (`CARCODMARCA`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `KGCTBLCAR`
--

/*!40000 ALTER TABLE `KGCTBLCAR` DISABLE KEYS */;
INSERT INTO `KGCTBLCAR` (`CARCOD`,`CARNOME`,`CARCODMARCA`,`CARCODMODELO`,`CARPRECO`,`CARANO`,`CARFOTO`,`CARCODSTATUS`,`CARKM`,`CARCODCAMBIO`,`CARPORTAS`,`CARCODCOMBUSTIVEL`,`CARCODCOR`,`CARPLACA`,`CARTROCA`,`CARDESTAQUE`,`CARDATCADASTRO`,`CARUSER`) VALUES 
 (1,'PALIO EDX 97',1,1,8500.00,'1997','111997031220191812.JPG',1,40000.00,1,4,1,1,'CII-1234','S','S','2019-12-03 00:00:00','ADMIN');
/*!40000 ALTER TABLE `KGCTBLCAR` ENABLE KEYS */;


--
-- Definition of table `kgctblcom`
--

DROP TABLE IF EXISTS `kgctblcom`;
CREATE TABLE `kgctblcom` (
  `COMCOD` int(11) NOT NULL AUTO_INCREMENT,
  `COMDESCRICAO` varchar(50) NOT NULL,
  `COMDATCADASTRO` datetime NOT NULL,
  `COMUSER` varchar(50) NOT NULL,
  PRIMARY KEY (`COMCOD`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kgctblcom`
--

/*!40000 ALTER TABLE `kgctblcom` DISABLE KEYS */;
INSERT INTO `kgctblcom` (`COMCOD`,`COMDESCRICAO`,`COMDATCADASTRO`,`COMUSER`) VALUES 
 (1,'GASOLINA','2019-12-03 00:00:00','ADMIN'),
 (2,'ETANOL','2019-12-03 00:00:00','ADMIN'),
 (3,'GÁS NATURAL','2019-12-03 00:00:00','ADMIN'),
 (4,'FLEX','2019-12-03 00:00:00','ADMIN'),
 (5,'DIESEL','2019-12-03 00:00:00','ADMIN');
/*!40000 ALTER TABLE `kgctblcom` ENABLE KEYS */;


--
-- Definition of table `kgctblcon`
--

DROP TABLE IF EXISTS `kgctblcon`;
CREATE TABLE `kgctblcon` (
  `CONCOD` int(11) NOT NULL AUTO_INCREMENT,
  `CONNOME` varchar(255) NOT NULL,
  `CONEMAIL` varchar(255) NOT NULL,
  `CONASSUNTO` varchar(255) NOT NULL,
  `CONMENSAGEM` varchar(1000) NOT NULL,
  PRIMARY KEY (`CONCOD`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kgctblcon`
--

/*!40000 ALTER TABLE `kgctblcon` DISABLE KEYS */;
/*!40000 ALTER TABLE `kgctblcon` ENABLE KEYS */;


--
-- Definition of table `kgctblcor`
--

DROP TABLE IF EXISTS `kgctblcor`;
CREATE TABLE `kgctblcor` (
  `CORCOD` int(11) NOT NULL AUTO_INCREMENT,
  `CORDESCRICAO` varchar(50) NOT NULL,
  `CORCODHEXADECIMAL` varchar(7) NOT NULL,
  `CORDATCADASTRO` datetime NOT NULL,
  `CORUSER` varchar(50) NOT NULL,
  PRIMARY KEY (`CORCOD`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kgctblcor`
--

/*!40000 ALTER TABLE `kgctblcor` DISABLE KEYS */;
INSERT INTO `kgctblcor` (`CORCOD`,`CORDESCRICAO`,`CORCODHEXADECIMAL`,`CORDATCADASTRO`,`CORUSER`) VALUES 
 (1,'PRATA','#c0c0c0','2019-12-03 00:00:00','ADMIN');
/*!40000 ALTER TABLE `kgctblcor` ENABLE KEYS */;


--
-- Definition of table `KGCTBLMAR`
--

DROP TABLE IF EXISTS `KGCTBLMAR`;
CREATE TABLE `KGCTBLMAR` (
  `MARCOD` int(11) NOT NULL AUTO_INCREMENT,
  `MARDESCRICAO` varchar(50) NOT NULL,
  `MARDATCADASTRO` datetime NOT NULL,
  `MARUSER` varchar(50) NOT NULL,
  PRIMARY KEY (`MARCOD`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `KGCTBLMAR`
--

/*!40000 ALTER TABLE `KGCTBLMAR` DISABLE KEYS */;
INSERT INTO `KGCTBLMAR` (`MARCOD`,`MARDESCRICAO`,`MARDATCADASTRO`,`MARUSER`) VALUES 
 (1,'Fiat','2019-12-03 17:26:15','ADMIN'),
 (2,'Audi','2019-12-03 17:26:15','ADMIN'),
 (3,'BMW','2019-12-03 17:26:15','ADMIN'),
 (4,'Chevrolet','2019-12-03 17:26:15','ADMIN'),
 (5,'Citroen','2019-12-03 17:26:15','ADMIN'),
 (6,'Ford','2019-12-03 17:26:15','ADMIN'),
 (7,'Honda','2019-12-03 17:26:15','ADMIN'),
 (8,'Hyundai','2019-12-03 17:26:15','ADMIN'),
 (9,'Jeep','2019-12-03 17:26:15','ADMIN'),
 (10,'Mitsubishi','2019-12-03 17:26:15','ADMIN'),
 (11,'Peugeot','2019-12-03 17:26:15','ADMIN'),
 (12,'Renault','2019-12-03 17:26:15','ADMIN'),
 (13,'Suzuki','2019-12-03 17:26:15','ADMIN'),
 (14,'Toyota','2019-12-03 17:26:15','ADMIN'),
 (15,'Volkswagem','2019-12-03 17:26:15','ADMIN'),
 (17,'Outro','2019-12-03 17:26:15','ADMIN');
/*!40000 ALTER TABLE `KGCTBLMAR` ENABLE KEYS */;


--
-- Definition of table `KGCTBLMOD`
--

DROP TABLE IF EXISTS `KGCTBLMOD`;
CREATE TABLE `KGCTBLMOD` (
  `MODCOD` int(11) NOT NULL AUTO_INCREMENT,
  `MODDESCRICAO` varchar(50) NOT NULL,
  `MODCODMARCA` int(11) NOT NULL,
  `MODDATCADASTRO` datetime NOT NULL,
  `MODUSER` varchar(50) NOT NULL,
  PRIMARY KEY (`MODCOD`),
  KEY `MODCODMARCA` (`MODCODMARCA`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `KGCTBLMOD`
--

/*!40000 ALTER TABLE `KGCTBLMOD` DISABLE KEYS */;
INSERT INTO `KGCTBLMOD` (`MODCOD`,`MODDESCRICAO`,`MODCODMARCA`,`MODDATCADASTRO`,`MODUSER`) VALUES 
 (1,'PALIO EDX',1,'2019-12-03 00:00:00','ADMIN');
/*!40000 ALTER TABLE `KGCTBLMOD` ENABLE KEYS */;


--
-- Definition of table `KGCTBLPUB`
--

DROP TABLE IF EXISTS `KGCTBLPUB`;
CREATE TABLE `KGCTBLPUB` (
  `PUBCOD` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `PUBTITULO` varchar(100) NOT NULL,
  `PUBIMG` varchar(255) NOT NULL,
  `PUBEMPRESA` varchar(255) NOT NULL,
  `PUBDATCADASTRO` datetime NOT NULL,
  `PUBUSER` varchar(50) NOT NULL,
  PRIMARY KEY (`PUBCOD`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='TABELA DE PUBLICIDADES';

--
-- Dumping data for table `KGCTBLPUB`
--

/*!40000 ALTER TABLE `KGCTBLPUB` DISABLE KEYS */;
/*!40000 ALTER TABLE `KGCTBLPUB` ENABLE KEYS */;


--
-- Definition of table `kgctblrecanu`
--

DROP TABLE IF EXISTS `kgctblrecanu`;
CREATE TABLE `kgctblrecanu` (
  `RECCOD` int(11) NOT NULL AUTO_INCREMENT,
  `RECEMAIL` varchar(255) NOT NULL,
  PRIMARY KEY (`RECCOD`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kgctblrecanu`
--

/*!40000 ALTER TABLE `kgctblrecanu` DISABLE KEYS */;
/*!40000 ALTER TABLE `kgctblrecanu` ENABLE KEYS */;


--
-- Definition of table `KGCTBLSOLANU`
--

DROP TABLE IF EXISTS `KGCTBLSOLANU`;
CREATE TABLE `KGCTBLSOLANU` (
  `SOLCOD` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `SOLANUNCIANTE` varchar(255) NOT NULL,
  `SOLCODMARCA` int(10) unsigned NOT NULL,
  `SOLCODMODELO` int(10) unsigned NOT NULL,
  `SOLANO` varchar(4) NOT NULL,
  `SOLPRECO` double(10,2) NOT NULL,
  `SOLDATCADASTRO` datetime NOT NULL,
  `SOLUSER` varchar(50) NOT NULL,
  PRIMARY KEY (`SOLCOD`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='TABELA DE SOLICITAÇÃO DE ANUNCIOS';

--
-- Dumping data for table `KGCTBLSOLANU`
--

/*!40000 ALTER TABLE `KGCTBLSOLANU` DISABLE KEYS */;
/*!40000 ALTER TABLE `KGCTBLSOLANU` ENABLE KEYS */;


--
-- Definition of table `kgctblstacar`
--

DROP TABLE IF EXISTS `kgctblstacar`;
CREATE TABLE `kgctblstacar` (
  `STACOD` int(11) NOT NULL AUTO_INCREMENT,
  `STADESCRICAO` varchar(50) NOT NULL,
  `STADATCADASTRO` datetime NOT NULL,
  `STAUSER` varchar(50) NOT NULL,
  PRIMARY KEY (`STACOD`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kgctblstacar`
--

/*!40000 ALTER TABLE `kgctblstacar` DISABLE KEYS */;
INSERT INTO `kgctblstacar` (`STACOD`,`STADESCRICAO`,`STADATCADASTRO`,`STAUSER`) VALUES 
 (1,'VENDA','2019-12-03 00:00:00','ADMIN');
/*!40000 ALTER TABLE `kgctblstacar` ENABLE KEYS */;


--
-- Definition of table `kgctbltipusu`
--

DROP TABLE IF EXISTS `kgctbltipusu`;
CREATE TABLE `kgctbltipusu` (
  `TIPCOD` int(11) NOT NULL AUTO_INCREMENT,
  `TIPDESCRICAO` varchar(50) NOT NULL,
  `TIPDATCADASTRO` datetime NOT NULL,
  `TIPUSER` varchar(50) NOT NULL,
  PRIMARY KEY (`TIPCOD`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kgctbltipusu`
--

/*!40000 ALTER TABLE `kgctbltipusu` DISABLE KEYS */;
/*!40000 ALTER TABLE `kgctbltipusu` ENABLE KEYS */;


--
-- Definition of table `marca`
--

DROP TABLE IF EXISTS `marca`;
CREATE TABLE `marca` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `MARDATCADASTRO` datetime NOT NULL,
  `MARUSER` varchar(50) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `marca`
--

/*!40000 ALTER TABLE `marca` DISABLE KEYS */;
INSERT INTO `marca` (`codigo`,`nome`,`MARDATCADASTRO`,`MARUSER`) VALUES 
 (1,'Fiat','2019-12-03 12:15:29','ADMIN'),
 (2,'Audi','2019-12-03 12:15:29','ADMIN'),
 (3,'BMW','2019-12-03 12:15:29','ADMIN'),
 (4,'Chevrolet','2019-12-03 12:15:29','ADMIN'),
 (5,'Citroen','2019-12-03 12:15:29','ADMIN'),
 (6,'Ford','2019-12-03 12:15:29','ADMIN'),
 (7,'Honda','2019-12-03 12:15:29','ADMIN'),
 (8,'Hyundai','2019-12-03 12:15:29','ADMIN'),
 (9,'Jeep','2019-12-03 12:15:29','ADMIN'),
 (10,'Mitsubishi','2019-12-03 12:15:29','ADMIN'),
 (11,'Peugeot','2019-12-03 12:15:29','ADMIN'),
 (12,'Renault','2019-12-03 12:15:29','ADMIN'),
 (13,'Suzuki','2019-12-03 12:15:29','ADMIN'),
 (14,'Toyota','2019-12-03 12:15:29','ADMIN'),
 (15,'Volkswagem','2019-12-03 12:15:29','ADMIN'),
 (17,'Outro','2019-12-03 12:15:29','ADMIN');
/*!40000 ALTER TABLE `marca` ENABLE KEYS */;


--
-- Definition of table `modelo`
--

DROP TABLE IF EXISTS `modelo`;
CREATE TABLE `modelo` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `marca_codigo` varchar(50) NOT NULL,
  `MODDATCADASTRO` datetime NOT NULL,
  `MODUSER` varchar(50) NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `marca_codigo` (`marca_codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `modelo`
--

/*!40000 ALTER TABLE `modelo` DISABLE KEYS */;
/*!40000 ALTER TABLE `modelo` ENABLE KEYS */;


--
-- Definition of table `receber_anuncio`
--

DROP TABLE IF EXISTS `receber_anuncio`;
CREATE TABLE `receber_anuncio` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `situacao` varchar(1) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `receber_anuncio`
--

/*!40000 ALTER TABLE `receber_anuncio` DISABLE KEYS */;
/*!40000 ALTER TABLE `receber_anuncio` ENABLE KEYS */;


--
-- Definition of table `ugetblcva`
--

DROP TABLE IF EXISTS `ugetblcva`;
CREATE TABLE `ugetblcva` (
  `CVACOD` int(11) NOT NULL AUTO_INCREMENT,
  `CVAVERSAO` varchar(50) NOT NULL,
  `CVADATCADASTRO` datetime NOT NULL,
  `CVAUSER` varchar(50) NOT NULL,
  PRIMARY KEY (`CVACOD`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ugetblcva`
--

/*!40000 ALTER TABLE `ugetblcva` DISABLE KEYS */;
/*!40000 ALTER TABLE `ugetblcva` ENABLE KEYS */;


--
-- Definition of table `ugetblcvb`
--

DROP TABLE IF EXISTS `ugetblcvb`;
CREATE TABLE `ugetblcvb` (
  `CVBCOD` int(11) NOT NULL AUTO_INCREMENT,
  `CVBVERSAO` varchar(50) NOT NULL,
  `CVBDATCADASTRO` datetime NOT NULL,
  `CVBUSER` varchar(50) NOT NULL,
  PRIMARY KEY (`CVBCOD`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ugetblcvb`
--

/*!40000 ALTER TABLE `ugetblcvb` DISABLE KEYS */;
INSERT INTO `ugetblcvb` (`CVBCOD`,`CVBVERSAO`,`CVBDATCADASTRO`,`CVBUSER`) VALUES 
 (1,'001','2019-12-03 12:16:29','SCRIPT_BANCO');
/*!40000 ALTER TABLE `ugetblcvb` ENABLE KEYS */;


--
-- Definition of table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(40) NOT NULL,
  `cpf` varchar(11) DEFAULT NULL,
  `dt_nascimento` varchar(10) DEFAULT NULL,
  `telefone` varchar(11) DEFAULT NULL,
  `telefone2` varchar(11) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `senha` varchar(50) DEFAULT NULL,
  `cep` varchar(8) DEFAULT NULL,
  `rua` varchar(50) DEFAULT NULL,
  `numero_casa` varchar(6) DEFAULT NULL,
  `bairro` varchar(50) DEFAULT NULL,
  `cidade` varchar(40) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,
  `tipo` int(11) DEFAULT NULL,
  `USUUSUARIO` varchar(50) NOT NULL,
  `USUDATCADASTRO` datetime NOT NULL,
  `USUUSER` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `usuario`
--

/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` (`id`,`nome`,`cpf`,`dt_nascimento`,`telefone`,`telefone2`,`email`,`senha`,`cep`,`rua`,`numero_casa`,`bairro`,`cidade`,`estado`,`tipo`,`USUUSUARIO`,`USUDATCADASTRO`,`USUUSER`) VALUES 
 (1,'ITALO ANGELO',NULL,NULL,NULL,NULL,NULL,'2a7127938116961b96e8e141f6421bc6',NULL,NULL,NULL,NULL,NULL,NULL,1,'ITALOANGELO13','2019-12-03 00:00:00','ADMIN');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
