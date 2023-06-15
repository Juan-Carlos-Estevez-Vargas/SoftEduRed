-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-06-2018 a las 06:01:28
-- Versión del servidor: 10.1.30-MariaDB
-- Versión de PHP: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `attendant`
--

CREATE DATABASE proyecto;
use proyecto;

CREATE TABLE `attendant` (
  `user_pk_fk_cod_doc` varchar(3) NOT NULL,
  `user_id_user` varchar(15) NOT NULL,
  `fk_relationship` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `attendant`
--

INSERT INTO `attendant` (`user_pk_fk_cod_doc`, `user_id_user`, `fk_relationship`) VALUES
('CC', '1000136217', 'FATHER'),
('CC', '995455485', 'FATHER'),
('CC', '1000254987', 'MOTHER'),
('CC', '84654196', 'MOTHER'),
('CC', '1030689689', 'UNCLE'),
('CE', '66558745', 'UNCLE'),
('CE', '68784564', 'UNCLE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `course`
--

CREATE TABLE `course` (
  `cod_course` varchar(5) NOT NULL,
  `state` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `course`
--

INSERT INTO `course` (`cod_course`, `state`) VALUES
('11-01', 1),
('11-02', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gender`
--

CREATE TABLE `gender` (
  `desc_gender` varchar(20) NOT NULL,
  `state` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `gender`
--

INSERT INTO `gender` (`desc_gender`, `state`) VALUES
('FEMALE', 1),
('MASCULINE', 1),
('UNSPECIFIED', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `no_attendance`
--

CREATE TABLE `no_attendance` (
  `cod_no_attendance` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `observation` mediumtext,
  `fk_student_tdoc` varchar(3) NOT NULL,
  `fk_student_user_id` varchar(15) NOT NULL,
  `fk_course_has_subject` varchar(5) NOT NULL,
  `fk_sub_has_course` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relationship`
--

CREATE TABLE `relationship` (
  `desc_relationship` varchar(30) NOT NULL,
  `state` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `relationship`
--

INSERT INTO `relationship` (`desc_relationship`, `state`) VALUES
('FATHER', 1),
('MOTHER', 1),
('UNCLE', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role`
--

CREATE TABLE `role` (
  `desc_role` varchar(15) NOT NULL,
  `state` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `role`
--

INSERT INTO `role` (`desc_role`, `state`) VALUES
('ADMIN', 1),
('ATTENDANT', 1),
('INVITED', 1),
('STUDENT', 1),
('TEACHER', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `security_question`
--

CREATE TABLE `security_question` (
  `question` varchar(45) NOT NULL,
  `state` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `security_question`
--

INSERT INTO `security_question` (`question`, `state`) VALUES
('NAME OF YOUR BEST FRIEND?', 1),
('NAME OF YOUR FIRST PET?', 1),
('NAME OF YOUR FIRST SCHOOL?', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `student`
--

CREATE TABLE `student` (
  `pk_fk_tdoc_user` varchar(3) NOT NULL,
  `pk_fk_user_id` varchar(15) NOT NULL,
  `fk_attendat_cod_doc` varchar(3) NOT NULL,
  `fk_attendant_id` varchar(15) NOT NULL,
  `fk_cod_course` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `student`
--

INSERT INTO `student` (`pk_fk_tdoc_user`, `pk_fk_user_id`, `fk_attendat_cod_doc`, `fk_attendant_id`, `fk_cod_course`) VALUES
('TI', '1000054894', 'CC', '1000254987', '11-02'),
('TI', '1000135457', 'CC', '84654196', '11-02'),
('TI', '1000365564', 'CC', '995455485', '11-02'),
('TI', '1000390471', 'CC', '1030689689', '11-02'),
('TI', '1000396898', 'CC', '1000136217', '11-01'),
('TI', '1000396899', 'CC', '1000136217', '11-01'),
('TI', '1000549874', 'CC', '84654196', '11-01'),
('TI', '1002546216', 'CE', '68784564', '11-01'),
('TI', '1005486789', 'CE', '66558745', '11-01'),
('TI', '1005549854', 'CC', '995455485', '11-02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subject`
--

CREATE TABLE `subject` (
  `n_subject` varchar(30) NOT NULL,
  `state` tinyint(4) NOT NULL,
  `fk_tdoc_user_teacher` varchar(3) NOT NULL,
  `fk_id_user_teacher` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `subject`
--

INSERT INTO `subject` (`n_subject`, `state`, `fk_tdoc_user_teacher`, `fk_id_user_teacher`) VALUES
('CHEMISTRY', 1, 'CE', '66558745'),
('ENGLISH', 1, 'CE', '68784564'),
('MATH', 1, 'CC', '995455485'),
('PHYSICAL', 1, 'CE', '66558745'),
('SISTEM', 1, 'CC', '1000136217');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subject_has_course`
--

CREATE TABLE `subject_has_course` (
  `pk_fk_course_stu` varchar(5) NOT NULL,
  `pk_fk_te_sub` varchar(30) NOT NULL,
  `state_sub_course` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `subject_has_course`
--

INSERT INTO `subject_has_course` (`pk_fk_course_stu`, `pk_fk_te_sub`, `state_sub_course`) VALUES
('11-01', 'CHEMISTRY', 1),
('11-01', 'ENGLISH', 1),
('11-01', 'MATH', 1),
('11-01', 'PHYSICAL', 1),
('11-01', 'SISTEM', 1),
('11-02', 'CHEMISTRY', 1),
('11-02', 'ENGLISH', 1),
('11-02', 'MATH', 1),
('11-02', 'PHYSICAL', 1),
('11-02', 'SISTEM', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `teacher`
--

CREATE TABLE `teacher` (
  `user_pk_fk_cod_doc` varchar(3) NOT NULL,
  `user_id_user` varchar(15) NOT NULL,
  `SALARY` int(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `teacher`
--

INSERT INTO `teacher` (`user_pk_fk_cod_doc`, `user_id_user`, `SALARY`) VALUES
('CC', '1000136217', NULL),
('CC', '995455485', NULL),
('CE', '66558745', NULL),
('CE', '68784564', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `type_of_document`
--

CREATE TABLE `type_of_document` (
  `cod_document` varchar(3) NOT NULL,
  `Des_doc` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `type_of_document`
--

INSERT INTO `type_of_document` (`cod_document`, `Des_doc`) VALUES
('CC', 'CEDULA CIUDADANA'),
('CE', 'CEDULA EXTRANJERIA'),
('TI', 'TARJETA DE IDENTIDAD');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `pk_fk_cod_doc` varchar(3) NOT NULL,
  `id_user` varchar(15) NOT NULL,
  `first_name` varchar(15) NOT NULL,
  `second_name` varchar(15) DEFAULT NULL,
  `surname` varchar(15) NOT NULL,
  `second_surname` varchar(15) DEFAULT NULL,
  `fk_gender` varchar(10) NOT NULL,
  `adress` varchar(40) DEFAULT NULL,
  `email` varchar(35) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `user_name` varchar(45) NOT NULL,
  `pass` varchar(20) NOT NULL,
  `photo` varchar(100) DEFAULT NULL,
  `security_answer` varchar(25) NOT NULL,
  `fk_s_question` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`pk_fk_cod_doc`, `id_user`, `first_name`, `second_name`, `surname`, `second_surname`, `fk_gender`, `adress`, `email`, `phone`, `user_name`, `pass`, `photo`, `security_answer`, `fk_s_question`) VALUES
('CC', '1000136217', 'Anderson', NULL, 'Riano', NULL, 'MASCULINE', NULL, 'asriano7@example.com', '555 55 55', 'Shack', '24092000.', NULL, 'TITO', 'NAME OF YOUR FIRST PET?'),
('CC', '1000254987', 'Luisa', NULL, 'Martinez', NULL, 'FEMALE', NULL, 'LuisaMart@example.com', '555 84 98', 'Luisa_Martinez', 'LuisitaComunica', NULL, 'KENNEDY', 'NAME OF YOUR FIRST SCHOOL?'),
('CC', '1030689689', 'Julian', NULL, 'Naranjo', NULL, 'MASCULINE', NULL, 'jcnaranjo98@example.com', '555 55 55', 'Julian', 'XDXDXD', NULL, 'NEMO', 'NAME OF YOUR FIRST PET?'),
('CC', '84654196', 'Alejandra', NULL, 'Benitez', NULL, 'FEMALE', NULL, 'Aleja_quimi@example.com', '555 48 54', 'Aleja', 'QuimicaAleja', NULL, 'POLAR', 'NAME OF YOUR FIRST PET?'),
('CC', '995455485', 'Armando', NULL, 'Casas', NULL, 'MASCULINE', NULL, 'armando@example.com', '224 88 95', 'Armandocasitas@example.com', 'CasasArman', NULL, 'BRUNO', 'NAME OF YOUR FIRST PET?'),
('CE', '66558745', 'Julio', NULL, 'Benitez', NULL, 'MASCULINE', NULL, 'julio@example.com', '3125548985', 'Julio25', 'JULIO66.', NULL, 'JESUS', 'NAME OF YOUR BEST FRIEND?'),
('CE', '68784564', 'Mauricio', NULL, 'Lopez', NULL, 'MASCULINE', NULL, 'mauri_en@example.com', '587 45 64', 'Mauri_En', 'MauricioSpeak', NULL, 'KING', 'NAME OF YOUR FIRST PET?'),
('TI', '1000054894', 'Gustavo', NULL, 'Petro', NULL, 'MASCULINE', NULL, 'Petrosky_18@example.com', '321 454 5649', 'Lord_Petrosky', 'Petrosky2018', NULL, 'Albarito', 'NAME OF YOUR FIRST PET?'),
('TI', '1000135457', 'Alberto', NULL, 'Dario', NULL, 'MASCULINE', NULL, 'dario_25@example.com', '315 216 5459', 'Dario25', 'dario25alberto.', NULL, 'JUAN', 'NAME OF YOUR BEST FRIEND?'),
('TI', '1000365564', 'Carlos', NULL, 'Rodriguez', NULL, 'MASCULINE', NULL, 'carlitos16@example.com', '555 21 54', 'CarlitosVI', 'CarlitosVIRodri', NULL, 'KENNEDY', 'NAME OF YOUR FIRST SCHOOL?'),
('TI', '1000390471', 'Manuel', NULL, 'Higuera', NULL, 'MASCULINE', NULL, 'jmhiguera1@example.com', '555 55 55', 'Manuel', '1000390471', NULL, 'MANOLITO', 'NAME OF YOUR FIRST PET?'),
('TI', '1000396898', 'Paula', NULL, 'Ruiz', NULL, 'FEMALE', NULL, 'Pato09@example.com', '554 54 65', 'Andy', 'ANDYPATO09.', NULL, 'PEPE', 'NAME OF YOUR FIRST PET?'),
('TI', '1000396899', 'Valentina', NULL, 'Ruiz', NULL, 'FEMALE', NULL, 'valen09@example.com', '464 45 89', 'Valen09', '09092001xd', NULL, 'PEPE', 'NAME OF YOUR FIRST PET?'),
('TI', '1000549874', 'Edgar', NULL, 'Figueroa', NULL, 'MASCULINE', NULL, 'Edgar@example.com', '558 98 21', 'Edgar_Figue', 'Edgar558', NULL, 'RUFUS', 'NAME OF YOUR FIRST PET?'),
('TI', '1002546216', 'Clara', NULL, 'Muñoz', NULL, 'FEMALE', NULL, 'ocura_25@example.com', '254 54 54', 'ClaritaMuñoz', 'Clarita2545454', NULL, 'Camila', 'NAME OF YOUR BEST FRIEND?'),
('TI', '1005486789', 'Carmen', NULL, 'Rodriguez', NULL, 'FEMALE', NULL, 'Carmend@example.com', '584 55 13', 'Carmen', '1005486789', NULL, 'PEDAGOGO LEON', 'NAME OF YOUR FIRST SCHOOL?'),
('TI', '1005549854', 'Andres', NULL, 'Peréz', NULL, 'MASCULINE', NULL, 'Perez_And@example.com', '584 55 13', 'Andres_Perez', '1005549854', NULL, 'LEON V', 'NAME OF YOUR FIRST SCHOOL?');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_has_role`
--

CREATE TABLE `user_has_role` (
  `tdoc_role` varchar(3) NOT NULL,
  `pk_fk_id_user` varchar(15) NOT NULL,
  `pk_fk_role` varchar(15) NOT NULL,
  `state` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `user_has_role`
--

INSERT INTO `user_has_role` (`tdoc_role`, `pk_fk_id_user`, `pk_fk_role`, `state`) VALUES
('CC', '1000136217', 'ADMIN', 1),
('CC', '1000136217', 'TEACHER', 1),
('CC', '1000254987', 'ATTENDANT', 1),
('CC', '1030689689', 'ADMIN', 1),
('CC', '1030689689', 'ATTENDANT', 1),
('CC', '84654196', 'ATTENDANT', 1),
('CC', '995455485', 'ATTENDANT', 1),
('CC', '995455485', 'TEACHER', 0),
('CE', '66558745', 'ATTENDANT', 1),
('CE', '66558745', 'TEACHER', 1),
('CE', '68784564', 'ATTENDANT', 1),
('CE', '68784564', 'TEACHER', 1),
('TI', '1000054894', 'STUDENT', 1),
('TI', '1000135457', 'STUDENT', 1),
('TI', '1000365564', 'STUDENT', 1),
('TI', '1000390471', 'ADMIN', 1),
('TI', '1000390471', 'STUDENT', 1),
('TI', '1000396898', 'STUDENT', 1),
('TI', '1000396899', 'STUDENT', 1),
('TI', '1000549874', 'STUDENT', 1),
('TI', '1002546216', 'STUDENT', 1),
('TI', '1005486789', 'STUDENT', 1),
('TI', '1005549854', 'STUDENT', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `attendant`
--
ALTER TABLE `attendant`
  ADD PRIMARY KEY (`user_pk_fk_cod_doc`,`user_id_user`),
  ADD KEY `fk_attendant_relationship1_idx` (`fk_relationship`);

--
-- Indices de la tabla `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`cod_course`);

--
-- Indices de la tabla `gender`
--
ALTER TABLE `gender`
  ADD PRIMARY KEY (`desc_gender`);

--
-- Indices de la tabla `no_attendance`
--
ALTER TABLE `no_attendance`
  ADD PRIMARY KEY (`cod_no_attendance`),
  ADD KEY `fk_no_attendance_student1_idx` (`fk_student_tdoc`,`fk_student_user_id`),
  ADD KEY `fk_no_attendance_course_has_subject1_idx` (`fk_course_has_subject`,`fk_sub_has_course`);

--
-- Indices de la tabla `relationship`
--
ALTER TABLE `relationship`
  ADD PRIMARY KEY (`desc_relationship`);

--
-- Indices de la tabla `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`desc_role`);

--
-- Indices de la tabla `security_question`
--
ALTER TABLE `security_question`
  ADD PRIMARY KEY (`question`);

--
-- Indices de la tabla `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`pk_fk_tdoc_user`,`pk_fk_user_id`),
  ADD KEY `fk_student_attendant1_idx` (`fk_attendat_cod_doc`,`fk_attendant_id`),
  ADD KEY `fk_student_course1_idx` (`fk_cod_course`);

--
-- Indices de la tabla `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`n_subject`),
  ADD KEY `fk_subject_teacher1_idx` (`fk_tdoc_user_teacher`,`fk_id_user_teacher`);

--
-- Indices de la tabla `subject_has_course`
--
ALTER TABLE `subject_has_course`
  ADD PRIMARY KEY (`pk_fk_course_stu`,`pk_fk_te_sub`),
  ADD KEY `fk_course_has_subject_subject1_idx` (`pk_fk_te_sub`),
  ADD KEY `fk_course_has_subject_course1_idx` (`pk_fk_course_stu`);

--
-- Indices de la tabla `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`user_pk_fk_cod_doc`,`user_id_user`);

--
-- Indices de la tabla `type_of_document`
--
ALTER TABLE `type_of_document`
  ADD PRIMARY KEY (`cod_document`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`pk_fk_cod_doc`,`id_user`,`fk_s_question`),
  ADD UNIQUE KEY `user_name_UNIQUE` (`user_name`),
  ADD KEY `fk_user_gender1_idx` (`fk_gender`),
  ADD KEY `fk_user_security_question1_idx` (`fk_s_question`);

--
-- Indices de la tabla `user_has_role`
--
ALTER TABLE `user_has_role`
  ADD PRIMARY KEY (`tdoc_role`,`pk_fk_id_user`,`pk_fk_role`),
  ADD KEY `fk_role_has_user_user1_idx` (`tdoc_role`,`pk_fk_id_user`),
  ADD KEY `fk_role_has_user_role1_idx` (`pk_fk_role`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `no_attendance`
--
ALTER TABLE `no_attendance`
  MODIFY `cod_no_attendance` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `attendant`
--
ALTER TABLE `attendant`
  ADD CONSTRAINT `fk_attendant_relationship1` FOREIGN KEY (`fk_relationship`) REFERENCES `relationship` (`desc_relationship`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_attendant_user1` FOREIGN KEY (`user_pk_fk_cod_doc`,`user_id_user`) REFERENCES `user` (`pk_fk_cod_doc`, `id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `no_attendance`
--
ALTER TABLE `no_attendance`
  ADD CONSTRAINT `fk_no_attendance_course_has_subject1` FOREIGN KEY (`fk_course_has_subject`,`fk_sub_has_course`) REFERENCES `subject_has_course` (`pk_fk_course_stu`, `pk_fk_te_sub`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_no_attendance_student1` FOREIGN KEY (`fk_student_tdoc`,`fk_student_user_id`) REFERENCES `student` (`pk_fk_tdoc_user`, `pk_fk_user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `fk_student_attendant1` FOREIGN KEY (`fk_attendat_cod_doc`,`fk_attendant_id`) REFERENCES `attendant` (`user_pk_fk_cod_doc`, `user_id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_student_course1` FOREIGN KEY (`fk_cod_course`) REFERENCES `course` (`cod_course`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_student_user1` FOREIGN KEY (`pk_fk_tdoc_user`,`pk_fk_user_id`) REFERENCES `user` (`pk_fk_cod_doc`, `id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `subject`
--
ALTER TABLE `subject`
  ADD CONSTRAINT `fk_subject_teacher1` FOREIGN KEY (`fk_tdoc_user_teacher`,`fk_id_user_teacher`) REFERENCES `teacher` (`user_pk_fk_cod_doc`, `user_id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `subject_has_course`
--
ALTER TABLE `subject_has_course`
  ADD CONSTRAINT `fk_course_has_subject_course1` FOREIGN KEY (`pk_fk_course_stu`) REFERENCES `course` (`cod_course`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_course_has_subject_subject1` FOREIGN KEY (`pk_fk_te_sub`) REFERENCES `subject` (`n_subject`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `teacher`
--
ALTER TABLE `teacher`
  ADD CONSTRAINT `fk_teacher_user1` FOREIGN KEY (`user_pk_fk_cod_doc`,`user_id_user`) REFERENCES `user` (`pk_fk_cod_doc`, `id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_gender1` FOREIGN KEY (`fk_gender`) REFERENCES `gender` (`desc_gender`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_security_question1` FOREIGN KEY (`fk_s_question`) REFERENCES `security_question` (`question`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_type_of_docuemnt` FOREIGN KEY (`pk_fk_cod_doc`) REFERENCES `type_of_document` (`cod_document`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `user_has_role`
--
ALTER TABLE `user_has_role`
  ADD CONSTRAINT `fk_role_has_user_role1` FOREIGN KEY (`pk_fk_role`) REFERENCES `role` (`desc_role`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_role_has_user_user1` FOREIGN KEY (`tdoc_role`,`pk_fk_id_user`) REFERENCES `user` (`pk_fk_cod_doc`, `id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
