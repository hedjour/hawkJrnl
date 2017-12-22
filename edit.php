<?php
	include_once("fonctions.php");
	$id=$_POST['ids'];
	$type=$_POST['typs'];
	if($id =="" or $type ==""){
		error_log("id =" .$id."  \n type : ".$type);
		die;
		}
	$bug=0 ;
	if (isset($id) && is_numeric($id) && isset($type) ){
		if($type=="bird"){//Edit bird
			if ( (isset($_POST['bird_name']))  ){ //nom
				$nom=$_POST['bird_name'];
			}else{
				$reponse.="name undefined";
				$bug=1;
			}
			 if ( (isset($_POST['species']))  ){//$species
				$species=$_POST['species'];
			}else{
				$reponse.="species undefined";
				$bug=1;
			}
			if ( (isset($_POST['sex']))  ){ //$sex
				$sex=$_POST['sex'];
			}else{
				$reponse.="sex undefined";
				$bug=1;
			}
		    if ( (isset($_POST['bd_cal']))  ){//$birth_date
				$birth_date=$_POST['bd_cal'];
			}else{
				$reponse.="birth undefined";
				$bug=1;
			}
		    if ( isset($_POST['dd_cal']) ){//$death_date
				$death_date=$_POST['dd_cal'];
			}elseif( ! isset($_POST['dd_cal']) ){
					$death_date="";
				}
		    if ( isset($_POST['owner']) ){//$owner
				$owner=$_POST['owner'];
			}else{
				$reponse.="owner undefined";
				$bug=1;
			}
		    if ( isset($_POST['pub'])  ){ //$privat
				$privat=$_POST['pub'];
			}else{
				$reponse.="privat status undefined";
				$bug=1;
			}
		    if ( isset($_POST['father'])  ){ //$father_id
				$father_id=$_POST['father'];
			}else{
				$reponse.="Father is undefined";
				$bug=1;
			}
		    if ( isset($_POST['mother']) ){ //$mother_id
				$mother_id=$_POST['mother'];
			}else{
				$reponse.="Mother is undefined";
				$bug=1;
			}
			if ( isset($_POST['wild']) ){ //$wild
					$wild=$_POST['wild'];
				}else{
					$reponse.="Wild  is undefined";
					$bug=1;
				}
			if ($wild==0){ //if sauvage we test the capture information
				 if ( isset($_POST['cd_cal'])  ){//$captureDate
						$captureDate=$_POST['cd_cal'];
					}elseif( ! isset($_POST['cd_cal']) ){
						$captureDate="";
					}else{
						$reponse="capture date undefine";
						$bug=1;
					}
				 if ( isset($_POST['country'])){ //$country
					$country=$_POST['country'];
				}else{
					$reponse.=" Country is undefined";
					$bug=1;
				}
				$wild_info=', captureDate = "'. $captureDate .'", country = "'. $country.'"';
			}else { $wild_info=' ';}
			if ($bug !=1){
				$sql='UPDATE hawkjrnl.bird SET ';
				$sql.='nom = "'. $nom . '", sex = "'. $sex .'", species = "'. $species .'",birth_date = "'. $birth_date ;
				$sql.='", death_date = "'. $death_date .'", owner = "'. $owner .'", privat = "'. $privat .'", father_id = "'. $father_id;
				$sql.='", mother_id = "'. $mother_id .'", wild = "'. $wild .$wild_info.'" WHERE bird.id = '. $id;
			}
		}elseif ($type=="human"){//Edit Human
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
			if ($bug !=1){
				$sql='UPDATE hawkjrnl.human SET name ="'. $name .'", firstname="'. $firstname .'" WHERE human.id='. $id ;
			}

		}elseif (isset($type) && $type=="path"){//Edit Path
			//Check Name,
			if ( (isset($_POST['name']))  && (preg_match("/([A-z -_]*)/",$_POST['name'])) ){
				$run_name=$_POST['name'];
			}else{
				$reponse="<div class=\"alert\">  Unexpected error occured : Name must just contains alphabetic character</div>";
				$bug=1;
			}
			//Check Description
			if ( (isset($_POST["description"]))  && (preg_match("/([A-z -_]*)/",$_POST['description']))   ){
				$description=$_POST["description"];
			}else{
				$reponse="<div class=\"alert\"> Unexpected error occured : First name must just contains alphabetic character</div>";
				$bug=1;
			}
			if ($bug !=1){
				$sql='UPDATE hawkjrnl.possiblerun SET run_name ="'. $run_name .'", description="'. $description .'" WHERE possiblerun.id='. $id ;
			}
		}elseif(isset($type) && $type=="jrnl"){//Edit un journal






		}else{
			die("Type is invalid");
		}
	}else{
		die("Id : --".$id."-- or typ : --".$type . "--invalid");
	}
//Execution of SQL commands
if( $bug != 1){
	$base=connectBase();
	mysqli_query($base, $sql) or die ('Erreur SQL !'.$sql.'<br />'.mysqli_error($base)); 
	mysqli_close($base);
}

//Return
echo (json_encode(['reponse'=>"The entry was modify"]));
?>
