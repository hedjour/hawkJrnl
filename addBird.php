<?php
include_once("fonctions.php");
    //On récupère les valeurs entrées par l'utilisateur :
    	/* Value to get
    	 * ""
    	 * bird_name in the db : nom
    	 * sex
    	 * species
    	 * birth_date
    	 * death_date
    	 * owner
    	 * privat
    	 * father_id
    	 * mother_id
    	 * wild
    	 * captureDate
    	 * Country
    	 * picture
    	 */

	//nom,
 $reponse=""; //We initialize the response var

    if ( (isset($_POST['bird_name']))  ){
		$nom=$_POST['bird_name'];
	}else{
		$reponse.="name undefined";
		$bug=1;
	}
	 if ( (isset($_POST['species']))  ){
		$species=$_POST['species'];
	}else{
		$reponse.="species undefined";
		$bug=1;
	}
	if ( (isset($_POST['sex']))  ){ //&& (is_numeric($_POST['sex']))
		$sex=$_POST['sex'];
	}else{
		$reponse.="sex undefined";
		$bug=1;
	}
    if ( (isset($_POST['bd_cal']))  ){
		$birth_date=$_POST['bd_cal'];
	}else{
		$reponse.="birth undefined";
		$bug=1;
	}
    if ( isset($_POST['dd_cal']) ){
		$death_date=$_POST['dd_cal'];
	}elseif( ! isset($_POST['dd_cal']) ){
			$death_date="";
		}
    if ( isset($_POST['owner']) ){
		$owner=$_POST['owner'];
	}else{
		$reponse.="owner undefined";
		$bug=1;
	}
    if ( isset($_POST['pub'])  ){ //&& (is_numeric($_POST['pub']))
		$privat=$_POST['pub'];
	}else{
		$reponse.="privat status undefined";
		$bug=1;
	}
    if ( isset($_POST['father'])  ){ //&& (is_numeric($_POST['father_id']))
		$father_id=$_POST['father'];
	}else{
		$reponse.="Father is undefined";
		$bug=1;
	}
    if ( isset($_POST['mother']) ){ //&& (is_numeric($_POST['mother_id']))
		$mother_id=$_POST['mother'];
	}else{
		$reponse.="Mother is undefined";
		$bug=1;
	}
	 if ( isset($_POST['wild']) ){ // && (is_numeric($_POST['wild']))
			$wild=$_POST['wild'];
		}else{
			$reponse.="Wild  is undefined";
			$bug=1;
		}
	 if ( isset($_POST['cd_cal'])  ){ //&& (is_numeric($_POST['captureDate']))
			$captureDate=$_POST['cd_cal'];
		}elseif( ! isset($_POST['cd_cal']) ){
			$captureDate="";
		}else{
			$reponse="capture date undefine";
			$bug=1;
		}
	 if ( isset($_POST['country'])){ // && (is_numeric($_POST['country']))
		$country=$_POST['country'];
	}else{
		$reponse.=" Country is undefined";
		$bug=1;
	}
	/*
	  * Picture System
	  *
	 */
	if (isset($_FILES['userfile']) &&  $_FILES['userfile']->name !="") {
		var_dump("FILE set");
		var_dump($_FILES['userfile']);
		var_dump("fin first");
	    $target_dir = "image/birdAvatar/";
	    $target_filetmp = $target_dir . time(). basename($_FILES["userfile"]["name"]);
	    $target_file=str_replace ( "." , "_" ,$target_filetmp);
	    //var_dump($target_file);
	    $uploadOk = 1;
	    $targetFileType = pathinfo($target_filetmp, PATHINFO_EXTENSION);

	// Check if file already exists
	    if (file_exists($target_file) && filesize($target_file) == $_FILES['userfile']['size']) {
	        $reponse .= "Le fichier est déjà présent<br/>";
	        $uploadOk = 0;
	    }

	// Check file size (inférieur à 500k)
	    if ($_FILES["userfile"]["size"] > 500000) {
	        $reponse .= "Le fichier est lourd >500k<br>";
	        $uploadOk = 0;
	    }

	// Allow certain file formats
		$filetyp=array("png","jpg","jpeg");
	    if (!(in_array(strtolower($targetFileType), $filetyp) )) { //|| $_FILES["filename"]['type'] == 'text/csv' || $_FILES["filename"]['type'] == 'text/comma-separated-values' TODO augmenter les vérifications
	        $reponse .= "\n oup's, le fichier n'est pas une image valide<br>";
	        $uploadOk = 0;
	    }

	// Check if $uploadOk is set to 0 by an error
	    if ($uploadOk == 0){
	       $reponse .= "Le fichier ne peut être charger<br>";
	// if everything is ok, try to upload file
	    }else{
	        if (move_uploaded_file($_FILES["userfile"]["tmp_name"], $target_file)) {
	            $reponse .= "Le fichier " . basename($_FILES["userfile"]["name"]) . " est chargé.<br>";
	            $base=connectBase();
				$sqlimage='INSERT INTO image VALUES("", "'.$target_file.'")';
				mysqli_query($base, $sqlimage) or die ('Erreur SQL image!'.$sql.'<br />'.mysqli_error($base));
				$getMaxImageID='SELECT MAX(id) FROM image';
				$picture=mysqli_fetch_assoc(mysqli_query($base, $getMaxImageID))["MAX(id)"] ;
				mysqli_close($base);
			} else {
	            $reponse .= "Pb de téléchargement, le fichier n'est pas chargé.<br>";
	            $bug=1;
	        }
	    }
	} else{
		//var_dump("no user picture");
		$picture=1;
	}
	 //var_dump($picture);
 if ( (! isset($bug)) || ($bug==0) ){
    $reponse.= 'Bird added';

    //On alimente la base de données

    //On se connecte
    $base=connectBase();

    //On prépare la commande sql d'insertion
    $sql = 'INSERT INTO bird VALUES(
    "","'.
    $nom.'","'.
    $sex.'","'.
    $species.'","'.
    $birth_date.'","'.
    $death_date.'","'.
    $owner.'","'.
    $privat.'","'.
    $father_id.'","'.
    $mother_id.'","'.
    $wild.'","'.
    $captureDate.'","'.
    $country.'","'.
    $picture. '" )';

    /*on lance la commande (mysqli_query) et au cas où,
    on rédige un petit message d'erreur si la requête ne passe pas (or die)
    (Message qui intègrera les causes d'erreur sql)*/
    mysqli_query($base, $sql) or die ('Erreur SQL !'.$sql.'<br />'.mysqli_error($base));

    // on ferme la connexion
    mysqli_close($base);
}
    echo json_encode(['reponse' => $reponse]);
//header("location:hawkjournal.php");
?>
