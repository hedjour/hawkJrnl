<?php
include_once("fonctions.php");
if ( (isset($_GET)) && isset($_GET['type']) ){
		$type=$_GET['type'];
	}
if ( isset($_GET['id']) && is_numeric($_GET['id'])){
		$id=$_GET['id'];
	}
if ( isset($_GET['idimg']) && is_numeric($_GET['idimg'])){
		$idimg=$_GET['idimg'];
	}

switch ($type) {
    case "bird":
        if ( isset($_GET['idimg']) && is_numeric($_GET['idimg'])){
			if( $idimg != "1" || $idimg != "2"){//id img = 1 is the default image
				$sql='DELETE FROM bird WHERE bird.id='. $id.';';
			}else{
				die("NO WAY IT'S a God I can't kill him");
			}
			if( $idimg != "1"){//id img = 1 is the default image
				error_log("delete d'une image");//DEBUG
				$sql.='DELETE FROM image WHERE image.id='. $idimg.';';
			}
			$page="";
		}
        break;
    case "path":
        $sql='DELETE FROM possiblerun WHERE possiblerun.id='. $id.';';
        $page="#path_infos";
        break;
    case "human":
        $sql='DELETE FROM human WHERE human.id='. $id.';';
        $page="#human_infos";
        break;
}
if(isset($sql)){
	$base=connectBase();
	$rep=mysqli_query($base, $sql);
//	echo $rep;
	mysqli_close($base);
	header("location:hawkjournal.php".$page);
}else{
	die ("Error in delete");
}
?>
