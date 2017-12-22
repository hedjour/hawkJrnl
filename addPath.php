<?php
	include_once("fonctions.php");
	/*TODO faire en sorte de vérifier que du code sql n'est pas entré en tant que nom d'utilisateur*/
	 //On récupère les valeurs entrées par l'utilisateur :

	//Check Name
	if ( (isset($_POST['name']) ) && (preg_match("/([A-z -_]*)/",$_POST['name']))  ){
		$name=$_POST['name'];
	}else{
		$reponse="<div class=\"alert\"> Unexpected error occured : First name must just contains alphabetic character</div>";
		$bug=1;
	}
	//Check description,
	if ( (isset($_POST['description'])) && (preg_match("/([A-z -_]*)/",$_POST['description'])) ){
		$description=$_POST['description'];
	}else{
		$reponse="<div class=\"alert\">  Unexpected error occured : Name must just contains alphabetic character</div>";
		$bug=1;
	}

    //On alimente la base de données et on lance l'affichage résumé
    if (! (isset($bug)) ){
		//On se connecte
		$base=connectBase();

		//On prépare la commande sql d'insertion
		$sql = 'INSERT INTO possiblerun VALUES("","'.$name.'","'.$description.'")';

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
