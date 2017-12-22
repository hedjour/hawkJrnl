<?php
	include_once("fonctions.php");
	//$id=$_GET['id'];
	//$type=$_GET['typ'];
	$id=$_POST['ids'];
	$type=$_POST['typs'];
	//error_log( "id--".$id."---typ---".$type); //DEBUG
	//TODO TRANSFORMER LES GET en $_POST[]
	if (isset($id) && is_numeric($id) ){
		$base=connectBase();
		//$sql='SELECT * FROM jrnl INNER JOIN human ON human.id = jrnl.taker WHERE bird_id='.$id .' ORDER BY jrnl.day';
		$sql='SELECT * FROM jrnl INNER JOIN human ON human.id = jrnl.taker INNER JOIN possiblerun ON possiblerun.id = jrnl.run WHERE bird_id='.$id .' ORDER BY jrnl.day'; ///On test
		$result = mysql_query ($sql) or die ('Erreur SQL !'.$sql.'<br />'.mysql_error());
		mysql_close($base);
		
		///Organize the result ask and send them
		if(isset($type) && $type=="all"){//Get all retourne le tableau brut
			$rep = mysql_fetch_array($result);
			
		}elseif(isset($type) && $type=="weight"){//Get Weight
			//transforme rep en liste  à n éléments (colonnes) [ [X,...], [y,...] ]
			$dat=array();
			$weight=array();
			while($row = mysql_fetch_array($result) ) {
				$dat[] = $row['day'];
				$weight[]=$row['weight'];
			}
			$rep = ['date'=>$dat,'weight'=>$weight];
			
		}elseif (isset($type) && $type=="hum"){//Get Human
			
			$rep=mysql_fetch_array($result);
			$data=array();
			$legend=array();
			while($row = mysql_fetch_array($result) ) {
				if ( ! in_array($row['taker'], $data) ){
					$legend[]=$row['taker'].':'.$row['name'].'-'.$row['firstname'];
				}
				$data[] = $row['taker'];
			}
			$rep = ['data'=>$data,'legend'=>$legend];
		}elseif (isset($type) && $type=="path"){//Get Path
			$data=array();
			$legend=array();
			while($row = mysql_fetch_array($result) ) {
				if ( ! in_array($row['run'], $data) ){
					$legend[]=$row['run'].':'.$row['run_name'];
				}
				$data[] = $row['run'];
			}
			$rep = ['data'=>$data,'legend'=>$legend];
		}elseif(isset($type) && $type=="state"){//Get Status
			$data=array();
			while($row = mysql_fetch_array($result) ) {
				$data[] = $row['state'];
			}
			$rep = ['data'=>$data];
			
		}elseif(isset($type) && $type=="ci"){//Get CI
			$base=connectBase();
			$sql='SELECT * FROM bird INNER JOIN image ON bird.picture = image.id WHERE bird.id='.$id  ;
			$result = mysql_query ($sql) or die ('Erreur SQL !'.$sql.'<br />'.mysql_error());
			$rep=mysql_fetch_array($result) ;
			mysql_close($base);
		
		}elseif (isset($type) && $type=="path_info"){//Get Path_Info
				$base=connectBase();
				$sql='SELECT * FROM possiblerun  WHERE possiblerun.id='.$id  ;
				$result = mysql_query ($sql) or die ('Erreur SQL !'.$sql.'<br />'.mysql_error());
				$rep=mysql_fetch_array($result) ;
				mysql_close($base);	
		}elseif (isset($type) && $type=="bird_info"){//Get Path_Info
				$base=connectBase();
				$sql='SELECT * FROM bird  WHERE bird.id='.$id  ;
				$result = mysql_query ($sql) or die ('Erreur SQL !'.$sql.'<br />'.mysql_error());
				$rep=mysql_fetch_array($result) ;
				mysql_close($base);	
		}elseif (isset($type) && $type=="human_info"){//Get Human_Info
				$base=connectBase();
				$sql='SELECT * FROM human  WHERE human.id='.$id  ;
				$result = mysql_query ($sql) or die ('Erreur SQL !'.$sql.'<br />'.mysql_error());
				$rep=mysql_fetch_array($result) ;
				mysql_close($base);	
		}elseif (isset($type) && $type=="jrnl_info"){//Get diary of a bird
				//$base=connectBase();
				//$sql='SELECT * FROM jrnl  WHERE jrnl.bird_id='.$id;
				//$result = mysql_query ($sql) or die ('Erreur SQL !'.$sql.'<br />'.mysql_error());
				//mysql_close($base);	
				/*$word='<table class="table table-striped table-bordered table-hover table-condensed">';
				$word.='<thead><th>day</th> <th>weight</th> <th>performance</th> <th>quarrytaken </th>	<th>food</th> <th>state</th> <th>run </th> <th>taker</th></thead>\n<tbody>';
				while($row = mysql_fetch_array($result)) { 
					    $word.= '<tr>'; 
					    //id 	day 	bird_id 	weight 	performance 	quarrytaken 	food 	state 	run 	taker
					    $word.= '<td> <strong>' . $row['day'] . '</strong></td>';
					  	$word.= '<td>'. $row['weight'] .'</td>';
						$word.= '<td">' . $row['performance'] . '</td>';
						$word.= '<td>'.$row['quarrytaken'].'</td>';
						$word.= '<td>' . $row['food'] . '</td>';
					    $word.= '<td>' . $row['state'] . '</td>';
					    //Changer l'id en nom
					    $word.= '<td>' . $row['run'] . '</td>';
					    $word.= '<td>' . $row['taker']. '</td>';
					    //Edit/delete
					    $word.= '<td width=25px><button type="button" class="btn btn-warning btn-xs" onclick="jrnl_edit_form('.$row['id'].')" data-toggle="modal" data-target="#addBird"> Edit </button></td>';
					    $word.= '<td width=25px><a type="button" class="btn btn-danger  btn-xs" href="delete.php?type=jrnl&id='.$row['id'].'"> Delete </a></td>';
					    $word.= '</tr>\n';
					    
					}
				
				$word.='TEST TEST </tbody></table>';*/
				//$word="test";
				//error_log($word);
				$rep=['table'=>"word"];
		}else{
			$rep="Type is invalid";
		}
	}else{
		$rep="Id invalid";
	}
	//Renvoie de la réponse en json
	echo json_encode($rep);
?>
:
