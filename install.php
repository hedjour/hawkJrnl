<?php
#include_once(fonctions.php);
include("fonctions.php");
//Connection to the base
$base=connectBase();
//Fichier de création des tables
//ON linux edit /etc/php5/apache2/php.ini and verify:
//file_uploads = On

//Création des tables :
//Human 3 col/*
/*$sql_tbl_human = <<< SQL
		 CREATE TABLE IF NOT EXISTS `human` (
				`id` INT NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`id`),
				INDEX (`id`),
				`name` VARCHAR(15),
				`firstname` VARCHAR(15)
				);
SQL;*/
$sql_tbl_human = "
		 CREATE TABLE IF NOT EXISTS `human` (
				`id` INT NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`id`),
				INDEX (`id`),
				`name` VARCHAR(15),
				`firstname` VARCHAR(15)
				);
";
mysqli_query($base, $sql_tbl_human ) or die("<pre>Erreur:\nrequete: $sql_tbl_human\n".mysqli_error($base)."\n</pre>\n");
echo("Human table created <br/>");

//Image path 2  cln
#mysqli_query($base, ' CREATE TABLE image(
#				id INT NOT NULL AUTO_INCREMENT,
#				PRIMARY KEY (id),
#				path VARCHAR(100)
#				)ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
#				INSERT INTO image (id, path) VALUES (0,"image/birdAvatar/no.jpg");
#			') or die ('Erreur SQL create table image failed!'.$sql.'<br />'.mysqli_error($base));
#echo("Image table created");
$sql_tbl_image = <<<SQL
CREATE TABLE IF NOT EXISTS `image` (
    `id` INT NOT NULL AUTO_INCREMENT,
    PRIMARY KEY(`id`),
    `path` VARCHAR(100) );
SQL;
mysqli_query( $base, $sql_tbl_image ) or die("<pre>Erreur:\nrequete: $sql_tbl_image\n".mysqli_error($base)."\n</pre>\n");

//Bird 13 cln
$sql_tbl_bird = <<<SQL
 		CREATE TABLE IF NOT EXISTS `bird` (
				`id` INT NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (id),
				`nom` VARCHAR(15),
				`sex` boolean,
				`species` VARCHAR(15) NOT NULL DEFAULT "Harris",
				#status VARCHAR(50),
			 	`birth_date` DATE,
				`death_date` DATE,
				`owner` VARCHAR(15),
				`privat` BOOLEAN,
				`father_id` INT,
				`mother_id` INT,
			 	`wild` BOOLEAN,
				`captureDate` DATE,
				`Country` VARCHAR(20),
				`picture` INT NOT NULL,
				FOREIGN KEY (`picture`) REFERENCES image(`id`)
			) ;
SQL;
mysqli_query($base, $sql_tbl_bird) or die ('Erreur SQL create table bird failed!'.$sql_tbl_bird.'<br />'.mysqli_error($base));;
echo("Image table created<br/>");


//Run Table 2cln
$sql_tbl_possiblerun = <<<SQL
		CREATE TABLE IF NOT EXISTS `possiblerun` (
				`id` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
				`run_name` VARCHAR(20),
				`Description` TEXT NULL DEFAULT NULL
				);
SQL;

mysqli_query($base, $sql_tbl_possiblerun) or die ('Erreur SQL create tbl_possiblerun failed!'.$sql_tbl_possiblerun.'<br />'.mysqli_error($base));
echo("Table of Run created<br/>");

//Journal 8cln
$sql_tbl_jrnl = <<<SQL
 CREATE TABLE IF NOT EXISTS `jrnl` (
				`id` INT NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (id),
				`day` DATE,
				`bird_id` INT,
				FOREIGN KEY (`bird_id`) REFERENCES bird (`id`),
				INDEX (`day`,`bird_id`),
				#TODO INdex de day et bird_id et avoir id comme clé primaire
				`weight` DOUBLE,
				#start DOUBLE,
				#end DOUBLE,
				`performance` VARCHAR(50),
				`quarrytaken` VARCHAR(50),
				`food` VARCHAR(20),
				`state` VARCHAR(20),
				`run` int,
				FOREIGN KEY (`run`) REFERENCES possiblerun(`id`),
				`taker` int,
				FOREIGN KEY (taker) REFERENCES human(`id`)
				);
SQL;
mysqli_query($base, $sql_tbl_jrnl) or die ('Erreur SQL create table jrnl failed !'.$sql_tbl_jrnl.'<br />'.mysqlii_error());
echo("Table of Journal created<br/>");

//Insertion
$sql_inser_img = <<<SQL
		INSERT INTO image (id, path) VALUES (0,"image/birdAvatar/no.jpg");
SQL;
mysqli_query( $base, $sql_inser_img ) or die("<pre>Erreur:\nrequete: $sql_inser_img \n".mysqli_error($base)."\n</pre>\n");

//We create the two bird for unknown parents

$sql_inser_bird = <<<SQL
		INSERT INTO `bird` (id, nom, sex, species, birth_date, death_date, owner, privat, father_id, mother_id, wild, captureDate, Country, picture) VALUES
					(1, "Hawke", 1, "toto", "1900-01-01", "1900-01-01", "Falci-God", 0, 2, 1, 0, "1900-01-01", "Earth", 1),
					(2, "Hobereau", 0, "tata", "1900-01-01", "1900-01-01", "Falci-God", 0, 2, 1, 0, "1900-01-01", "Earth", 1);
SQL;

mysqli_query($base, $sql_inser_bird) or die ('Erreur SQL add bird 0 failed!'.$sql_inser_bird.'<br />'.mysqli_error($base));
echo("Father and mother of empty created<br/>");
?>
