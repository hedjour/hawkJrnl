<?php
#include_once(fonctions.php);
include("fonctions.php");

$base=connectBase();

//	IMAGE
$sql_tbl = "
	CREATE TABLE IF NOT EXISTS IMAGE (
		id INT NOT NULL AUTO_INCREMENT,
		path VARCHAR(100),
		PRIMARY KEY (id)
	) ;
";
mysqli_query($base, $sql_tbl ) or die("<pre>Erreur:\nrequete: $sql_tbl\n".mysqli_error($base)."\n</pre>\n");
echo("Table created <br/>");


//	BIRD
$sql_tbl = "
	CREATE TABLE IF NOT EXISTS BIRD (
		id INT NOT NULL AUTO_INCREMENT,
		nom VARCHAR(15),
		sex boolean,
		species VARCHAR(15),
		birth_date DATE,
		death_date DATE,
		owner_id INT,
		privat BOOLEAN,
		father_id INT,
		mother_id INT,
		wild BOOLEAN,
		captureDate DATE,
		Country VARCHAR(20),
		image_id INT NOT NULL,
		PRIMARY KEY (id)
	) ;
";
mysqli_query($base, $sql_tbl ) or die("<pre>Erreur:\nrequete: $sql_tbl\n".mysqli_error($base)."\n</pre>\n");
echo("Table created <br/>");


//	JRNL
$sql_tbl = "
	CREATE TABLE IF NOT EXISTS JRNL (
		id INT NOT NULL AUTO_INCREMENT,
		day DATE,
		bird_id INT,
		INDEX (day,bird_id),
		weight DOUBLE,
		performance VARCHAR(50),
		quarrytaken VARCHAR(50),
		food VARCHAR(20),
		state VARCHAR(20),
		run_id int,
		PRIMARY KEY (id)
	) ;
";
mysqli_query($base, $sql_tbl ) or die("<pre>Erreur:\nrequete: $sql_tbl\n".mysqli_error($base)."\n</pre>\n");
echo("Table created <br/>");


//	HUMAN
$sql_tbl = "
	CREATE TABLE IF NOT EXISTS HUMAN (
		id INT NOT NULL AUTO_INCREMENT,
		name VARCHAR(15),
		firstname VARCHAR(15),
		INDEX (id),
		PRIMARY KEY (id)
	) ;
";
mysqli_query($base, $sql_tbl ) or die("<pre>Erreur:\nrequete: $sql_tbl\n".mysqli_error($base)."\n</pre>\n");
echo("Table created <br/>");


//	NODE
$sql_tbl = "
	CREATE TABLE IF NOT EXISTS NODE (
		id INT NOT NULL AUTO_INCREMENT,
		description VARCHAR(20),
		position INT,
		longitude DOUBLE,
		latitude DOUBLE,
		run_id INT,
		PRIMARY KEY (id)
) ;
";
mysqli_query($base, $sql_tbl ) or die("<pre>Erreur:\nrequete: $sql_tbl\n".mysqli_error($base)."\n</pre>\n");
echo("Table created <br/>");


//	RUN
$sql_tbl = "
	CREATE TABLE IF NOT EXISTS RUN (
		id INT NOT NULL AUTO_INCREMENT,
		length INT,
		run_name VARCHAR(20),
		PRIMARY KEY (id)
	) ;
";
mysqli_query($base, $sql_tbl ) or die("<pre>Erreur:\nrequete: $sql_tbl\n".mysqli_error($base)."\n</pre>\n");
echo("Table created <br/>");

//	//	//	//	//	//	//	//	//	//	//	//	
//	//	//	ALTER TABLE	//	//	//	//	//	//
//	//	//	//	//	//	//	//	//	//	//	//	
//	BIRD
$sql_tbl = "
	ALTER TABLE BIRD ADD FOREIGN KEY (image_id) REFERENCES IMAGE (id);
";
mysqli_query($base, $sql_tbl ) or die("<pre>Erreur:\nrequete: $sql_tbl\n".mysqli_error($base)."\n</pre>\n");
echo("Table altered <br/>");

$sql_tbl = "
	ALTER TABLE BIRD ADD FOREIGN KEY (owner_id) REFERENCES HUMAN (id);
";
mysqli_query($base, $sql_tbl ) or die("<pre>Erreur:\nrequete: $sql_tbl\n".mysqli_error($base)."\n</pre>\n");
echo("Table altered <br/>");


//	JRNL
$sql_tbl = "
	ALTER TABLE JRNL ADD FOREIGN KEY (bird_id) REFERENCES BIRD (id);
";
mysqli_query($base, $sql_tbl ) or die("<pre>Erreur:\nrequete: $sql_tbl\n".mysqli_error($base)."\n</pre>\n");
echo("Table altered <br/>");

$sql_tbl = "
	ALTER TABLE JRNL ADD FOREIGN KEY (run_id) REFERENCES RUN (id);
";
mysqli_query($base, $sql_tbl ) or die("<pre>Erreur:\nrequete: $sql_tbl\n".mysqli_error($base)."\n</pre>\n");
echo("Table altered <br/>");


//	NODE
$sql_tbl = "
	ALTER TABLE NODE ADD FOREIGN KEY (run_id) REFERENCES RUN (id);
";
mysqli_query($base, $sql_tbl ) or die("<pre>Erreur:\nrequete: $sql_tbl\n".mysqli_error($base)."\n</pre>\n");
echo("Table altered <br/>");


































