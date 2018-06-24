<?php
#include_once(fonctions.php);
include("fonctions.php");

$base=connectBase();

//	IMAGE
$sql_tbl = "
	CREATE TABLE IF NOT EXISTS image (
		id INT NOT NULL AUTO_INCREMENT,
		path VARCHAR(100),
		PRIMARY KEY (id)
	) ;
";
mysqli_query($base, $sql_tbl ) or die("<pre>Erreur:\nrequete: $sql_tbl\n".mysqli_error($base)."\n</pre>\n");
echo("Table created <br/>");


//	bird
$sql_tbl = "
	CREATE TABLE IF NOT EXISTS bird (
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


//	jrnl
$sql_tbl = "
	CREATE TABLE IF NOT EXISTS jrnl (
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


//	human
$sql_tbl = "
	CREATE TABLE IF NOT EXISTS human (
		id INT NOT NULL AUTO_INCREMENT,
		name VARCHAR(15),
		firstname VARCHAR(15),
		INDEX (id),
		PRIMARY KEY (id)
	) ;
";
mysqli_query($base, $sql_tbl ) or die("<pre>Erreur:\nrequete: $sql_tbl\n".mysqli_error($base)."\n</pre>\n");
echo("Table created <br/>");


//	node
$sql_tbl = "
	CREATE TABLE IF NOT EXISTS node (
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


//	run
$sql_tbl = "
	CREATE TABLE IF NOT EXISTS run (
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
<<<<<<< Updated upstream
//	//	//	//	//	//	//	//	//	//	//	//	
//	bird
=======
//	//	//	//	//	//	//	//	//	//	//	//
//	BIRD
>>>>>>> Stashed changes
$sql_tbl = "
	ALTER TABLE bird ADD FOREIGN KEY (image_id) REFERENCES IMAGE (id);
";
mysqli_query($base, $sql_tbl ) or die("<pre>Erreur:\nrequete: $sql_tbl\n".mysqli_error($base)."\n</pre>\n");
echo("Table altered <br/>");

$sql_tbl = "
	ALTER TABLE bird ADD FOREIGN KEY (owner_id) REFERENCES human (id);
";
mysqli_query($base, $sql_tbl ) or die("<pre>Erreur:\nrequete: $sql_tbl\n".mysqli_error($base)."\n</pre>\n");
echo("Table altered <br/>");


//	jrnl
$sql_tbl = "
	ALTER TABLE jrnl ADD FOREIGN KEY (bird_id) REFERENCES bird (id);
";
mysqli_query($base, $sql_tbl ) or die("<pre>Erreur:\nrequete: $sql_tbl\n".mysqli_error($base)."\n</pre>\n");
echo("Table altered <br/>");

$sql_tbl = "
	ALTER TABLE jrnl ADD FOREIGN KEY (run_id) REFERENCES run (id);
";
mysqli_query($base, $sql_tbl ) or die("<pre>Erreur:\nrequete: $sql_tbl\n".mysqli_error($base)."\n</pre>\n");
echo("Table altered <br/>");


//	node
$sql_tbl = "
	ALTER TABLE node ADD FOREIGN KEY (run_id) REFERENCES run (id);
";
mysqli_query($base, $sql_tbl ) or die("<pre>Erreur:\nrequete: $sql_tbl\n".mysqli_error($base)."\n</pre>\n");
echo("Table altered <br/>");
