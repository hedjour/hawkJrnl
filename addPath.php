<?php
	include_once("fonctions.php");
	/*TODO faire en sorte de vérifier que du code sql n'est pas entré en tant que nom d'utilisateur*/
	 //On récupère les valeurs entrées par l'utilisateur :
	//Check Name
	if ( (isset($_POST['name']) ) /*&& (preg_match("/([A-z -_]*)/",$_POST['name']))  */){
		$name=$_POST['name'];
	}else{
		$reponse="<div class=\"alert\"> Unexpected error occured : path name must just contains alphabetic character</div>";
		$bug=1;
	}
	//Check description
	if ( isset($_POST['node']) ){
		$node=$_POST['node'];
	}else{
		$reponse="<div class=\"alert\"> Unexpected error occured : description must exist</div>";
		$bug=1;
	}

    //On alimente la base de données et on lance l'affichage résumé
    if (! (isset($bug)) ){
		//On se connecte
		$base=connectBase();

	//	//	//	//	//	//	//	//	//	//	//	//
	//	//	//	INSERT RUN	//	//	//	//	//	//
	//	//	//	//	//	//	//	//	//	//	//	//
		//On prépare la commande sql d'insertion

	$sql ='INSERT INTO run  (run_name, length)VALUES(	"'.$name.'",	 "'.sizeOf($node).'")';
		/*on lance la commande (mysqli_query) et au cas où,
		on rédige un petit message d'erreur si la requête ne passe pas (or die)
		(Message qui intègrera les causes d'erreur sql)*/
		mysqli_query($base, $sql) or die ('Erreur SQL !'.$sql.'<br />'.mysqli_error($base));
		
		// select the ID of the new run
		$sql ='SELECT id FROM run  WHERE run_name = "'.$name.'" AND length = "'.sizeOf($node).'"  ';
		$result = mysqli_query($base, $sql) or die ('Erreur SQL !'.$sql.'<br />'.mysqli_error($base));
		$row = mysqli_fetch_array($result);
		$runid = $row['id'];
		

		//	//	//	//	//	//	//	//	//	//	//	//
		//	//	// INSERT NODES	//	//	//	//	//	//
		//	//	//	//	//	//	//	//	//	//	//	//
/*
		$sql = 'INSERT INTO node (position, description, run_id) VALUES  ' ;
		for ($i = 0 ; $i < sizeOf($node) ; $i++) {
			if($i != 0) {
				$sql += ',';
			}
			$sql += '("'.$i.'", "'.$node[$i].'", "'.$runnid.'")'
		}*/
	//	mysqli_query($base, $sql) or die ('Erreur SQL !'.$sql.'<br />'.mysqli_error($base));
		// on ferme la connexion
		mysqli_close($base);
		
		$reponse=$sql+ "     run id = "+$runid;
	//	$reponse="All right job done";
	}
echo json_encode(['reponse' => $reponse]);
 ?>
