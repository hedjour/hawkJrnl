<?php
	include_once("fonctions.php");
	 //On récupère les valeurs entrées par l'utilisateur :

	//Check FirstName
	if ( (isset($_POST["first_name"]))   ){ //&& (preg_match("/([A-z -]*)/",$_POST['first_name']))
		$firstname=$_POST["first_name"];
	}else{
		$reponse="<div class=\"alert\"> Unexpected error occured : First name must just contains alphabetic character</div>";
		$bug=1;
	}
	//Check Name,
	if ( (isset($_POST['name'])) ){ //&& (preg_match("/([A-z -]*)/",$_POST['name']))
		$name=$_POST['name'];
	}else{
		$reponse="<div class=\"alert\">  Unexpected error occured : Name must just contains alphabetic character</div>";
		$bug=1;
	}
    //On alimente la base de données et on lance l'affichage résumé
    if (! (isset($bug)) ){

		$reponse=' First Name :' . $firstname .
		   '\n Name :' . $name;

		//On se connecte
		$base=connectBase();

		//On prépare la commande sql d'insertion
		$sql = 'INSERT INTO human VALUES("","'.$firstname.'","'.$name.'")';

		/*on lance la commande (mysqli_query) et au cas où,
		on rédige un petit message d'erreur si la requête ne passe pas (or die)
		(Message qui intègrera les causes d'erreur sql)*/
		mysqli_query($base, $sql) or die ('Erreur SQL !'.$sql.'<br />'.mysqli_error($base));

		// on ferme la connexion
		mysqli_close($base);
		$reponse="All right job done";
	}

echo json_encode(['reponse' => $reponse]);
 ?>
