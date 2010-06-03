-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 03-06-2010 a las 05:10:03
-- Versión del servidor: 5.1.41
-- Versión de PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de datos: `musicshow`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recitales`
--

CREATE TABLE IF NOT EXISTS `recitales` (
  `recital_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `banda` varchar(100) NOT NULL,
  `date` char(10) NOT NULL,
  `timer` time DEFAULT NULL,
  `genero_id` int(11) NOT NULL,
  `price` char(20) NOT NULL,
  `price2` char(20) NOT NULL,
  `lugar_id` int(11) NOT NULL,
  `image1_full` varchar(255) NOT NULL,
  `image2_full` varchar(255) NOT NULL,
  `image3_full` varchar(255) NOT NULL,
  `image4_full` varchar(255) NOT NULL,
  `image5_full` varchar(255) NOT NULL,
  `image1_thumb` varchar(255) NOT NULL,
  `image2_thumb` varchar(255) NOT NULL,
  `image3_thumb` varchar(255) NOT NULL,
  `image4_thumb` varchar(255) NOT NULL,
  `image5_thumb` varchar(255) NOT NULL,
  `moreinfo` text NOT NULL,
  `date_added` datetime NOT NULL,
  `last_modified` datetime NOT NULL,
  PRIMARY KEY (`recital_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=51 ;

--
-- Volcar la base de datos para la tabla `recitales`
--

INSERT INTO `recitales` (`recital_id`, `user_id`, `banda`, `date`, `timer`, `genero_id`, `price`, `price2`, `lugar_id`, `image1_full`, `image2_full`, `image3_full`, `image4_full`, `image5_full`, `image1_thumb`, `image2_thumb`, `image3_thumb`, `image4_thumb`, `image5_thumb`, `moreinfo`, `date_added`, `last_modified`) VALUES
(42, 20, 'banda enero', '12,01,2010', NULL, 4, '', '', 47, '20_12695277464bab74c28bf4b.jpg', '', '', '', '', '20_12695277464bab74c28bf4b_thumb.jpg', '', '', '', '', '', '2010-03-25 11:35:46', '0000-00-00 00:00:00'),
(41, 20, 'banda 1', '25,03,2010', NULL, 3, '', '', 47, '20_12694484924baa3f2c69b59.jpg', '', '', '20_12694486554baa3fcf9f598.jpg', '20_12694486554baa3fcfd69ea.jpg', '20_12694484924baa3f2c69b59_thumb.jpg', '', '', '20_12694486554baa3fcf9f598_thumb.jpg', '20_12694486554baa3fcfd69ea_thumb.jpg', '', '2010-03-24 01:34:27', '2010-03-24 01:37:36'),
(43, 20, 'banda 2', '02,02,2010', NULL, 3, '343', '545', 33, '20_12695277824bab74e678dd4.jpg', '', '', '', '', '20_12695277824bab74e678dd4_thumb.jpg', '', '', '', '', '', '2010-03-25 11:36:22', '0000-00-00 00:00:00'),
(44, 20, 'banda mayo', '08,04,2010', NULL, 4, '565', '655', 33, '20_12695278584bab7532bf5ad.jpg', '', '', '', '', '20_12695278584bab7532bf5ad_thumb.jpg', '', '', '', '', '', '2010-03-25 11:37:38', '0000-00-00 00:00:00'),
(45, 20, 'banda abril', '20,04,2010', NULL, 6, '56', '34', 34, '20_12695279104bab756687365.jpg', '', '', '', '', '20_12695279104bab756687365_thumb.jpg', '', '', '', '', '', '2010-03-25 11:38:30', '0000-00-00 00:00:00'),
(46, 20, 'banda junio', '15,06,2010', NULL, 5, '', '', 36, '20_12695279634bab759be814f.jpg', '', '', '', '', '20_12695279634bab759be814f_thumb.jpg', '', '', '', '', '', '2010-03-25 11:39:24', '2010-03-26 09:18:42'),
(47, 20, 'banda julio', '15,07,2010', NULL, 7, '', '', 33, '20_12696227824bace7fe78669.jpg', '', '', '', '', '20_12696227824bace7fe78669_thumb.jpg', '', '', '', '', '', '2010-03-26 01:59:42', '0000-00-00 00:00:00'),
(48, 20, 'banda agosto', '11,08,2010', NULL, 6, '', '', 33, '20_12696229864bace8cab2db0.jpg', '', '', '', '', '20_12696229864bace8cab2db0_thumb.jpg', '', '', '', '', '', '2010-03-26 02:03:06', '0000-00-00 00:00:00'),
(50, 20, 'prueba recital con hora', '02,06,2010', '13:15:00', 3, '', '', 32, '20_12755309214c070ea9f01a9.png', '', '', '', '', '20_12755309214c070ea9f01a9_thumb.png', '', '', '', '', 'xsdfsdf', '2010-06-02 11:08:42', '2010-06-02 11:24:15');

