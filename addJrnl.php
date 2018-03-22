<?php
	include("fonctions.php");
    //On récupère les valeurs entrées par l'utilisateur :
	//day DATE,
    if ( (isset($_POST['dat'])) ){ // && (is_date($_POST['dat']))
		$dat=$_POST['dat'];
		$reponse=$dat;
	}else{
		$reponse="Date is undefined";
		$bug=1;
	}
	//bird id INT
	if ( (isset($_POST['bird_id'])) && (is_numeric($_POST['bird_id'])) ){
		$birdid=$_POST['bird_id'];
	}else{
		$reponse=" Bird  is undefined";
		$bug=1;
		$bug=1;
	}
	//Weight INT
    if ( (isset($_POST['weight'])) && (is_numeric($_POST['weight'])) ){
		$weight=$_POST['weight'];
	}else{
		$reponse=" Weight is undefined";
		$bug=1;
	}
	//Performance TEXT
    if ( isset($_POST['perf']) ){
		$perf=$_POST['perf'];
	}else{
		$reponse="Perf is undefined";
		$bug=1;
	}
	//Quarrytaken TEXT
    if ( isset($_POST['quarrytaken']) ){
		$quarrytaken=$_POST['quarrytaken'];
	}else{
		$reponse="Quarry taken is undefined";
		$bug=1;
	}
	//Food TEXT
    if ( isset($_POST['food']) ){
		$food=$_POST['food'];
	}else{
		$reponse="Food is undefined";
		$bug=1;
	}
	//State TEXT
    if ( isset($_POST['state']) ){
		$state=$_POST['state'];
	}else{
		$reponse="State";
		$bug=1;
	}
	//Run Choice or Text
    if ( isset($_POST['path']) ){
		$run=$_POST['path'];
	}else{
		$reponse="Run is undefined";
		$bug=1;
	}
	 if ( isset($_POST['taker']) ){
		$taker=$_POST['taker'];
	}else{
		$reponse="Taker is undefined";
		$bug=1;
	}

 if (! ( isset($bug) ) ){
	$reponse='Bird\'s day add';
	//On alimente la base de données

    //On se connecte
    $base=connectBase();

    //On prépare la commande sql d'insertion
    $sql = 'INSERT INTO jrnl (day, bird_id, weight, performance, quarrytaken, food, state, run, taker)
	VALUES("'.$dat.'","'.$birdid.'","'.$weight.'","'.$perf.'","'.$quarrytaken.'","'.$food.'","'.$state.'","'.$run.'","'.$taker.'")';

    /*on lance la commande (mysqli_query) et au cas où,
    on rédige un petit message d'erreur si la requête ne passe pas (or die)
    (Message qui intègrera les causes d'erreur sql)*/
    mysqli_query($base, $sql) or die ('Erreur SQL !'.$sql.'<br />'.mysqli_error($base));

    // on ferme la connexion
    mysqli_close($base);
}
    echo json_encode(['reponse' => $reponse]);
?>
