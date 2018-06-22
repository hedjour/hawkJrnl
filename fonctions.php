<?php
$TODAY=date("Y-m-d");
$widthL="150px";
function connectBase(){
  #Distant
  /*
	$base = mysqli_connect ('127.0.0.1', 'mael', 'YJ3mq2Q4');
	mysqli_select_db ($base, 'dbMael') ;
	
	*/
	$base = mysqli_connect ('localhost', 'root', 'root');
	mysqli_select_db ($base, 'Odelin') ;
  /*
	$base = new PDO('mysql:host=127.0.0.1;dbname=test;charset=utf8', 'root', 'root');
	
	*/
	return $base;
};

function is_date( $value ){
	return preg_match( "^\d{1,2}/\d{1,2}/\d{4}$" , $value );
 };

function get_header(){
	//Offline version of Jquery
	echo '<script src="jquery-1.11.3.js"></script>';
	echo '<script src="jquery-migrate-1.2.1.min.js"></script>';
	echo '<script src="jquery-ui.js"></script>';

	//Css link
	echo '<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css" />';
	echo '<script src="bootstrap/js/bootstrap.min.js"></script>';

	//Jquery
	echo '<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>';
	echo '<script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>';
	//Calendar
	echo '<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>';
	echo '<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">';
	
	//Graph/stats
	echo '<script type="text/javascript" src="plot.js"></script>';
	echo '<script type="text/javascript" src="stats.js"></script>';
}
?>
