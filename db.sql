-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 29-03-2022 a las 12:06:49
-- Versión del servidor: 5.7.36
-- Versión de PHP: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `crud_productos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text NOT NULL,
  `descripcion` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `descripcion`, `fecha`) VALUES
(1, 'Categoría 1', 'Descripción categoría 1', '2022-03-28 16:06:46'),
(2, 'Categoría 2', 'Descripión categoría 2', '2022-03-28 16:06:46'),
(3, 'Categoría 3', 'Descripción categoría 3', '2022-03-29 11:34:24'),
(4, 'Categoría 4', 'Descripción categoría 4', '2022-03-29 11:34:24'),
(5, 'Categoría 5', 'Descripción categoría 5', '2022-03-29 11:34:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text NOT NULL,
  `imagen` text NOT NULL,
  `referencia` text NOT NULL,
  `precio` int(11) NOT NULL,
  `peso` int(11) NOT NULL,
  `categoria` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `imagen`, `referencia`, `precio`, `peso`, `categoria`, `stock`, `fecha`) VALUES
(1, 'Producto 1', 'vistas/img/productos/default/anonymous.png', 'PD1', 1000, 2, 3, 1000, '2022-03-29 11:36:25'),
(2, 'Producto 2', 'vistas/img/productos/admin/132.png', 'PD2', 3000, 1, 1, 296, '2022-03-29 11:39:34'),
(3, 'Producto 3', 'vistas/img/productos/admin/537.jpg', 'PD3', 600, 5, 3, 393, '2022-03-29 11:45:45'),
(4, 'Producto 4', 'vistas/img/productos/admin/344.jpg', 'PD4', 3000, 4, 5, 496, '2022-03-29 11:49:50'),
(5, 'Producto 5', 'vistas/img/productos/admin/932.jpg', 'PD5', 8000, 5, 2, 692, '2022-03-29 11:52:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_vendidos`
--

DROP TABLE IF EXISTS `productos_vendidos`;
CREATE TABLE IF NOT EXISTS `productos_vendidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_venta` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `productos_vendidos`
--

INSERT INTO `productos_vendidos` (`id`, `id_venta`, `id_producto`, `cantidad`) VALUES
(1, 1, 5, 2),
(2, 1, 4, 3),
(3, 2, 2, 4),
(4, 2, 4, 1),
(5, 2, 3, 3),
(6, 2, 5, 6),
(7, 3, 3, 4),
(8, 4, 4, 100),
(9, 4, 3, 100),
(10, 5, 2, 200);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `email` text COLLATE utf8_spanish_ci NOT NULL,
  `usuario` text COLLATE utf8_spanish_ci NOT NULL,
  `password` text COLLATE utf8_spanish_ci NOT NULL,
  `perfil` text COLLATE utf8_spanish_ci NOT NULL,
  `foto` text COLLATE utf8_spanish_ci NOT NULL,
  `estado` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `usuario`, `password`, `perfil`, `foto`, `estado`, `created_at`) VALUES
(1, 'Administrador', 'admin@admin.ad', 'admin', '$2a$07$asxx54ahjppf45sd87a5auXBm1Vr2M1NV5t/zNQtGHGpS5fFirrbG', 'Administrador', 'vistas/img/usuarios/admin/719.png', 1, '2022-03-29 06:28:14'),
(2, 'John Doe', 'john@doe.com', 'johndoe', '$2a$07$asxx54ahjppf45sd87a5au8uJqn2VoaOMw86zRUoDH6inuYomGLDq', 'Administrador', 'vistas/img/usuarios/johndoe/551.png', 1, '2022-03-29 06:38:20'),
(3, 'Emily Myers Doe', 'emily@myers.mib', 'emily_myers', '$2a$07$asxx54ahjppf45sd87a5au8uJqn2VoaOMw86zRUoDH6inuYomGLDq', 'Usuario', 'vistas/img/usuarios/emily_myers/823.jpg', 1, '2022-03-29 06:24:08'),
(4, 'Jane Doe', 'janedoe@gmail.com', 'janedoe', '$2a$07$asxx54ahjppf45sd87a5au8uJqn2VoaOMw86zRUoDH6inuYomGLDq', 'Usuario', '', 1, '2022-03-29 06:17:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

DROP TABLE IF EXISTS `ventas`;
CREATE TABLE IF NOT EXISTS `ventas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `total` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `total`, `id_usuario`, `fecha`) VALUES
(1, 25000, 1, '2022-03-29 11:53:39'),
(2, 64800, 1, '2022-03-29 11:58:48'),
(3, 2400, 1, '2022-03-29 11:59:00'),
(4, 360000, 2, '2022-03-29 12:03:43'),
(5, 600000, 2, '2022-03-29 12:04:19');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
