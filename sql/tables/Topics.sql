CREATE TABLE Topics (
  id   INT UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT,
  name CHAR(250) NOT NULL UNIQUE,
  PRIMARY KEY (id)
) engine=innodb;