CREATE DATABASE omdb CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE users (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE `usermovies` (
  `id_user` int(11) NOT NULL,
  `id_movie` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`,`id_movie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;