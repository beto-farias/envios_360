-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.1.21-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win32
-- HeidiSQL Versión:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Volcando estructura para tabla template-core.auth_assignment
CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `auth_assignment_user_id_idx` (`user_id`),
  CONSTRAINT `FK_auth_assignment_mod_usuarios_ent_usuarios` FOREIGN KEY (`user_id`) REFERENCES `mod_usuarios_ent_usuarios` (`id_usuario`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla template-core.auth_assignment: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `auth_assignment` DISABLE KEYS */;
INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
	('super-admin', 1, NULL);
/*!40000 ALTER TABLE `auth_assignment` ENABLE KEYS */;

-- Volcando estructura para tabla template-core.auth_item
CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla template-core.auth_item: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;
INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
	('admin', 1, 'Administrador del sistema', NULL, NULL, NULL, NULL),
	('super-admin', 1, 'Super administrador del sistema', NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;

-- Volcando estructura para tabla template-core.auth_item_child
CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla template-core.auth_item_child: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;
INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
	('super-admin', 'admin');
/*!40000 ALTER TABLE `auth_item_child` ENABLE KEYS */;

-- Volcando estructura para tabla template-core.auth_rule
CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla template-core.auth_rule: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `auth_rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_rule` ENABLE KEYS */;

-- Volcando estructura para tabla template-core.mod_usuarios_cat_status_sesiones
CREATE TABLE IF NOT EXISTS `mod_usuarios_cat_status_sesiones` (
  `id_status` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `txt_nombre` varchar(50) NOT NULL COMMENT 'Estatus de la sesión',
  `txt_descripcion` varchar(500) DEFAULT NULL COMMENT 'Descripción del elemento',
  `b_habilitado` int(10) unsigned NOT NULL DEFAULT '1' COMMENT 'Booleano para saber si el registro esta habilitado',
  PRIMARY KEY (`id_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla template-core.mod_usuarios_cat_status_sesiones: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `mod_usuarios_cat_status_sesiones` DISABLE KEYS */;
/*!40000 ALTER TABLE `mod_usuarios_cat_status_sesiones` ENABLE KEYS */;

-- Volcando estructura para tabla template-core.mod_usuarios_cat_status_usuarios
CREATE TABLE IF NOT EXISTS `mod_usuarios_cat_status_usuarios` (
  `id_status` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `txt_nombre` varchar(50) NOT NULL COMMENT 'Estatus del usuario',
  `txt_descripcion` varchar(500) DEFAULT NULL COMMENT 'Descripción del elemento',
  `b_habilitado` int(10) unsigned NOT NULL DEFAULT '1' COMMENT 'Booleano para saber si el registro esta habilitado',
  PRIMARY KEY (`id_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla template-core.mod_usuarios_cat_status_usuarios: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `mod_usuarios_cat_status_usuarios` DISABLE KEYS */;
INSERT INTO `mod_usuarios_cat_status_usuarios` (`id_status`, `txt_nombre`, `txt_descripcion`, `b_habilitado`) VALUES
	(1, 'Pendiente', NULL, 1),
	(2, 'Activo', NULL, 1),
	(3, 'Bloqueado', NULL, 1);
/*!40000 ALTER TABLE `mod_usuarios_cat_status_usuarios` ENABLE KEYS */;

-- Volcando estructura para tabla template-core.mod_usuarios_cat_tipos_usuarios
CREATE TABLE IF NOT EXISTS `mod_usuarios_cat_tipos_usuarios` (
  `id_tipo_usuario` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `txt_nombre` varchar(100) NOT NULL,
  `txt_descripcion` varchar(500) NOT NULL,
  `b_habiliado` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_tipo_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla template-core.mod_usuarios_cat_tipos_usuarios: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `mod_usuarios_cat_tipos_usuarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `mod_usuarios_cat_tipos_usuarios` ENABLE KEYS */;

-- Volcando estructura para tabla template-core.mod_usuarios_ent_sesiones
CREATE TABLE IF NOT EXISTS `mod_usuarios_ent_sesiones` (
  `id_sesion` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` int(10) unsigned NOT NULL COMMENT 'Id del usuario que inicio sesión',
  `id_status` int(10) unsigned NOT NULL DEFAULT '1' COMMENT 'Status de la sesión',
  `fch_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha en la que el usuario inicio sesión',
  `fch_logout` timestamp NULL DEFAULT NULL COMMENT 'Fecha en la que el usuario finalizo la sesión',
  `num_minutos_sesion` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Minutos que duraro la sesión del usuario',
  `txt_ip` varchar(32) NOT NULL COMMENT 'Ip de donde se conecto el usuario',
  `txt_ip_logout` varchar(32) DEFAULT NULL COMMENT 'Ip de donde el usuario se desconecto',
  PRIMARY KEY (`id_sesion`),
  KEY `FK_ent_sesiones_cat_status_sesiones` (`id_status`),
  KEY `FK_ent_sesiones_ent_usuarios` (`id_usuario`),
  CONSTRAINT `FK_ent_sesiones_cat_status_sesiones` FOREIGN KEY (`id_status`) REFERENCES `mod_usuarios_cat_status_sesiones` (`id_status`),
  CONSTRAINT `FK_ent_sesiones_ent_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `mod_usuarios_ent_usuarios` (`id_usuario`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla template-core.mod_usuarios_ent_sesiones: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `mod_usuarios_ent_sesiones` DISABLE KEYS */;
/*!40000 ALTER TABLE `mod_usuarios_ent_sesiones` ENABLE KEYS */;

-- Volcando estructura para tabla template-core.mod_usuarios_ent_usuarios
CREATE TABLE IF NOT EXISTS `mod_usuarios_ent_usuarios` (
  `id_usuario` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `txt_auth_item` varchar(64) NOT NULL,
  `txt_token` varchar(100) NOT NULL DEFAULT '0',
  `txt_imagen` varchar(200) DEFAULT NULL,
  `txt_username` varchar(255) NOT NULL,
  `txt_apellido_paterno` varchar(30) DEFAULT NULL,
  `txt_apellido_materno` varchar(30) DEFAULT NULL,
  `txt_auth_key` varchar(32) NOT NULL,
  `txt_password_hash` varchar(255) NOT NULL,
  `txt_password_reset_token` varchar(255) DEFAULT NULL,
  `txt_email` varchar(255) NOT NULL,
  `fch_creacion` timestamp NULL DEFAULT NULL,
  `fch_actualizacion` datetime DEFAULT NULL,
  `id_status` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `txt_token` (`txt_token`),
  UNIQUE KEY `password_reset_token` (`txt_password_reset_token`),
  KEY `FK_ent_usuarios_cat_status_usuarios` (`id_status`),
  KEY `FK_mod_usuarios_ent_usuarios_auth_item` (`txt_auth_item`),
  CONSTRAINT `FK_ent_usuarios_cat_status_usuarios` FOREIGN KEY (`id_status`) REFERENCES `mod_usuarios_cat_status_usuarios` (`id_status`) ON DELETE CASCADE,
  CONSTRAINT `FK_mod_usuarios_ent_usuarios_auth_item` FOREIGN KEY (`txt_auth_item`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla template-core.mod_usuarios_ent_usuarios: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `mod_usuarios_ent_usuarios` DISABLE KEYS */;
INSERT INTO `mod_usuarios_ent_usuarios` (`id_usuario`, `txt_auth_item`, `txt_token`, `txt_imagen`, `txt_username`, `txt_apellido_paterno`, `txt_apellido_materno`, `txt_auth_key`, `txt_password_hash`, `txt_password_reset_token`, `txt_email`, `fch_creacion`, `fch_actualizacion`, `id_status`) VALUES
	(1, 'super-admin', 'usr7ca3eac6636e602cf7fdf8f65b89446c5a00b2c16e211', NULL, 'Diego', 'Perez', 'Martinez', 'aOa5yucU8iyhmiqY2S7ezOr4D8_HE9T0', '$2y$13$kVe8cvZ2Px.0SWVWr1PJuucVuw4gWpTHAxjbShvTWNfO4.x3riFf6', NULL, 'development@2gom.com.mx', '2017-11-07 22:06:42', NULL, 2);
/*!40000 ALTER TABLE `mod_usuarios_ent_usuarios` ENABLE KEYS */;

-- Volcando estructura para tabla template-core.mod_usuarios_ent_usuarios_activacion
CREATE TABLE IF NOT EXISTS `mod_usuarios_ent_usuarios_activacion` (
  `id_usuario_activacion` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` int(10) unsigned NOT NULL,
  `txt_token` varchar(60) NOT NULL,
  `txt_ip_activacion` varchar(60) DEFAULT NULL,
  `fch_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fch_activacion` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_usuario_activacion`),
  UNIQUE KEY `txt_token` (`txt_token`),
  KEY `FK_ent_usuarios_activacion_ent_usuarios` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla template-core.mod_usuarios_ent_usuarios_activacion: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `mod_usuarios_ent_usuarios_activacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `mod_usuarios_ent_usuarios_activacion` ENABLE KEYS */;

-- Volcando estructura para tabla template-core.mod_usuarios_ent_usuarios_cambio_pass
CREATE TABLE IF NOT EXISTS `mod_usuarios_ent_usuarios_cambio_pass` (
  `id_usuario_cambio_pass` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` int(10) unsigned NOT NULL,
  `txt_token` varchar(60) NOT NULL COMMENT 'Token del registro',
  `txt_ip` varchar(20) NOT NULL COMMENT 'Ip del usuario donde pidio el cambio de pass',
  `txt_ip_cambio` varchar(20) DEFAULT NULL COMMENT 'Ip del usuario donde cambio el pass',
  `fch_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creacion de registro',
  `fch_finalizacion` timestamp NULL DEFAULT NULL COMMENT 'Fecha de expiracion de la solicitud de cambio de pass',
  `fch_peticion_usada` timestamp NULL DEFAULT NULL COMMENT 'Fecha en la cual se utilizo la peticion',
  `b_usado` int(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Booleano para saber si el usuario ha usado la peticion',
  PRIMARY KEY (`id_usuario_cambio_pass`),
  KEY `FK_ent_usuarios_cambio_pass_ent_usuarios` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla template-core.mod_usuarios_ent_usuarios_cambio_pass: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `mod_usuarios_ent_usuarios_cambio_pass` DISABLE KEYS */;
/*!40000 ALTER TABLE `mod_usuarios_ent_usuarios_cambio_pass` ENABLE KEYS */;

-- Volcando estructura para tabla template-core.mod_usuarios_ent_usuarios_facebook
CREATE TABLE IF NOT EXISTS `mod_usuarios_ent_usuarios_facebook` (
  `id_usuario_facebook` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` int(10) unsigned NOT NULL,
  `id_facebook` bigint(20) NOT NULL,
  `txt_url_photo` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_usuario_facebook`),
  UNIQUE KEY `id_usuario` (`id_usuario`),
  UNIQUE KEY `id_facebook` (`id_facebook`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla template-core.mod_usuarios_ent_usuarios_facebook: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `mod_usuarios_ent_usuarios_facebook` DISABLE KEYS */;
/*!40000 ALTER TABLE `mod_usuarios_ent_usuarios_facebook` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
