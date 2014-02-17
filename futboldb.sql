-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 17-02-2014 a las 03:31:31
-- Versión del servidor: 5.5.16
-- Versión de PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `futboldb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `arbitros`
--

CREATE TABLE IF NOT EXISTS `arbitros` (
  `idarbitro` int(11) NOT NULL AUTO_INCREMENT,
  `arbitro` varchar(30) NOT NULL,
  PRIMARY KEY (`idarbitro`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Volcado de datos para la tabla `arbitros`
--

INSERT INTO `arbitros` (`idarbitro`, `arbitro`) VALUES
(1, 'Francisco La Molina'),
(29, 'Juan Bava'),
(28, 'Horacio Elizondo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

CREATE TABLE IF NOT EXISTS `equipos` (
  `idequipo` int(11) NOT NULL AUTO_INCREMENT,
  `idzona` int(11) NOT NULL,
  `equipo` varchar(30) NOT NULL,
  PRIMARY KEY (`idequipo`,`idzona`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Volcado de datos para la tabla `equipos`
--

INSERT INTO `equipos` (`idequipo`, `idzona`, `equipo`) VALUES
(25, 2, 'MONO "B"'),
(24, 2, 'AG. 46'),
(23, 2, 'TODOS PARA UINO'),
(2, 1, 'LOS PRESCRIPTOS'),
(3, 1, 'FISCADOS'),
(4, 1, 'PALITOS'),
(5, 1, 'BARRILETES'),
(6, 1, 'LEONES'),
(7, 1, 'DAMAJUANAS'),
(8, 1, 'RUSTICOS'),
(9, 2, 'SUR "B"'),
(10, 2, 'DON RAMON'),
(11, 2, 'AG. 56'),
(26, 2, 'ELEVEN'),
(27, 2, 'EXPORTADORES');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jugadores`
--

CREATE TABLE IF NOT EXISTS `jugadores` (
  `idjugador` int(11) NOT NULL AUTO_INCREMENT,
  `idequipo` int(11) NOT NULL,
  `jugador` varchar(30) NOT NULL,
  `nro` int(11) NOT NULL,
  `goles` int(11) NOT NULL,
  PRIMARY KEY (`idjugador`,`idequipo`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Volcado de datos para la tabla `jugadores`
--

INSERT INTO `jugadores` (`idjugador`, `idequipo`, `jugador`, `nro`, `goles`) VALUES
(1, 0, 'Juan José', 1, 0),
(9, 13, 'Ju4', 4, 0),
(3, 12, 'Jugador B', 4, 0),
(4, 12, 'Jugador C', 1, 0),
(5, 12, 'Jugador D', 9, 0),
(6, 12, 'Jugador #12', 0, 0),
(7, 13, 'Ja', 1, 0),
(8, 13, 'Il Mister', 0, 0),
(10, 1, 'Paradiso', 5, 0),
(11, 2, '10', 10, 100);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partidos`
--

CREATE TABLE IF NOT EXISTS `partidos` (
  `idzona` int(11) NOT NULL,
  `nrofecha` int(11) NOT NULL,
  `idpartido` int(11) NOT NULL,
  `idarbitro` int(11) NOT NULL,
  `local` int(11) NOT NULL,
  `visitante` int(11) NOT NULL,
  `glocal` int(11) NOT NULL,
  `gvisitante` int(11) NOT NULL,
  `fechahora` varchar(16) NOT NULL,
  PRIMARY KEY (`idzona`,`nrofecha`,`idpartido`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `partidos`
--

INSERT INTO `partidos` (`idzona`, `nrofecha`, `idpartido`, `idarbitro`, `local`, `visitante`, `glocal`, `gvisitante`, `fechahora`) VALUES
(1, 1, 1, 1, 1, 8, 4, 3, '28/09/2012 19:00'),
(1, 1, 2, 28, 2, 7, 2, 2, '28/09/2012 19:00'),
(1, 1, 3, 0, 3, 6, 0, 2, '28/09/2012 19:00'),
(1, 2, 1, 0, 1, 2, 6, 4, '05/10/2012 20:30'),
(1, 2, 2, 0, 3, 8, 0, 2, '05/10/2012 21:30'),
(1, 1, 4, 0, 4, 5, 3, 15, '05/10/2012 21:30'),
(1, 2, 3, 0, 4, 7, 2, 18, '05/10/2012 20:30'),
(1, 2, 4, 0, 5, 6, 3, 0, '05/10/2012 21:30'),
(3, 1, 1, 0, 0, 0, 0, 0, '12/11/2012 19:00'),
(3, 1, 2, 0, 0, 0, 0, 0, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puntajes`
--

CREATE TABLE IF NOT EXISTS `puntajes` (
  `idzona` int(11) NOT NULL,
  `idequipo` int(11) NOT NULL,
  `nrofecha` int(11) NOT NULL,
  `PG` int(11) NOT NULL,
  `PE` int(11) NOT NULL,
  `PP` int(11) NOT NULL,
  `NP` int(11) NOT NULL,
  `GF` int(11) NOT NULL,
  `GC` int(11) NOT NULL,
  `DF` int(11) NOT NULL,
  `PTS` int(11) NOT NULL,
  PRIMARY KEY (`idzona`,`idequipo`,`nrofecha`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `puntajes`
--

INSERT INTO `puntajes` (`idzona`, `idequipo`, `nrofecha`, `PG`, `PE`, `PP`, `NP`, `GF`, `GC`, `DF`, `PTS`) VALUES
(1, 6, 2, 0, 0, 1, 0, 0, 3, -3, 1),
(1, 5, 2, 1, 0, 0, 0, 3, 0, 3, 3),
(1, 7, 2, 1, 0, 0, 0, 18, 2, 16, 3),
(1, 4, 2, 0, 0, 1, 0, 2, 18, -16, 1),
(1, 8, 2, 1, 0, 0, 0, 2, 0, 2, 3),
(1, 3, 2, 0, 0, 1, 1, 0, 2, -2, 0),
(1, 2, 2, 0, 0, 1, 0, 4, 6, -2, 1),
(1, 1, 2, 1, 0, 0, 0, 6, 4, 2, 3),
(1, 5, 1, 1, 0, 0, 0, 15, 3, 12, 3),
(1, 4, 1, 0, 0, 1, 0, 3, 15, -12, 1),
(1, 6, 1, 1, 0, 0, 0, 2, 0, 2, 3),
(1, 3, 1, 0, 0, 1, 1, 0, 2, -2, 0),
(1, 7, 1, 0, 1, 0, 0, 2, 2, 0, 2),
(1, 2, 1, 0, 1, 0, 0, 2, 2, 0, 2),
(1, 8, 1, 0, 0, 1, 0, 3, 4, -1, 1),
(1, 1, 1, 1, 0, 0, 0, 4, 3, 1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resultados`
--

CREATE TABLE IF NOT EXISTS `resultados` (
  `idzona` int(11) NOT NULL,
  `nrofecha` int(11) NOT NULL,
  `idpartido` int(11) NOT NULL,
  `idarbitro` int(11) NOT NULL,
  `local` int(11) NOT NULL,
  `visitante` int(11) NOT NULL,
  `glocal` int(11) NOT NULL,
  `gvisitante` int(11) NOT NULL,
  `fechahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idzona`,`nrofecha`,`idpartido`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zonas`
--

CREATE TABLE IF NOT EXISTS `zonas` (
  `idzona` int(11) NOT NULL AUTO_INCREMENT,
  `zona` varchar(10) NOT NULL,
  PRIMARY KEY (`idzona`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `zonas`
--

INSERT INTO `zonas` (`idzona`, `zona`) VALUES
(1, 'Zona A'),
(2, 'Zona B'),
(3, 'Zona C'),
(4, 'Zona D');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
