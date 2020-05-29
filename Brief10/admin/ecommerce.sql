DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userID`    int(11) NOT NULL AUTO_INCREMENT,
  `username`  varchar(255) NOT NULL,
  `password`  varchar(255) NOT NULL,
  `email`     varchar(255) NOT NULL,
  `fullname`  varchar(255) NOT NULL,
  `groupeID`  int(11) NOT NULL,
  `regStatus` int(11) NOT NULL,
  `dateRegistre` DATE NOT NULL,
  PRIMARY KEY (`userID`)
);


DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id`          int(11) NOT NULL AUTO_INCREMENT,
  `name`        varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `price`       float NOT NULL,
  `date`        date NOT NULL,
  PRIMARY KEY (`id`)
);