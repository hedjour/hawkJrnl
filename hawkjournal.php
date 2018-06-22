<!DOCTYPE html >

<html lang="fr" >

<head>
<title>Hawk Journal</title>
<link rel="shortcut icon" type="image/x-icon" href="image/icons.png" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php
	include_once('fonctions.php');
	get_header();
?>
<script type="text/javascript" src="functions.js"></script>
<!--bootstrap/css -->

</head>

<body>
<div class="containers-fluid">
<!--Header de la page -->
	<div class="page-header" style="margin-left: 30px;">
		<h2><img src="image/iconsfree.png" class="img-thumbnail" alt="hawkjrnl-logo" width="90"> <font color="blue">HawkJrnl</font> Hawk Journal</h2>
	</div>

<!-- Bouton d'ajout d'information : -->
	<div class="row" id="addlinks">
		<div class="col-lg-12">
			<div class="btn-group">
				<!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#addBird">Toto</button>-->
				<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#addHuman" onclick="clean_humanform()">Add Human</button>
				<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#addBird"  onclick="clean_birdform()">Add Bird</button>
				<button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#addJrnl"  onclick="clean_jrnlform()">Add Journal</button>
				<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#addPath"  onclick="clean_pathform()">Add Run</button>
			</div>
		</div>
	</div>	<!--end addlinks-->

<!-- ONGLETS -->
 <div id="onglets">
            <ul><!--list of onglets -->
                <li><a href="#human_infos">Human list</a></li>
                <li><a href="#bird_infos">Bird list</a></li>
                <li><a href="#path_infos">Journal list</a></li>
                <li><a href="#days_infos">Run list</a></li>
            </ul>

<!-- Zone d'affichage de la table principale birdTable-->
	<div class="row" id="bird_infos">
		<!--<div class="row" id="table_birds">-->
		<div class="col-md-12"><br/><!--Debug-->
			<div class="table-group table-responsive" style="margin-left: 10px;">
				<table class="table table-striped table-bordered table-hover table-condensed">
				<?php
					include_once("fonctions.php");
					$base=connectBase();

					$sql="SELECT * FROM bird ORDER BY death_date";
				    $result = mysqli_query($base,$sql) or die ('Erreur SQL !'.$sql.'<br />'.mysqli_error($base));

					echo '<thead>
							<tr>
								<th>Name</th>
								<th>Sex</th>
								<th>Birth date</th>
								<th>Death date</th>
								<th>Owner</th>
								<th>Father</th>
								<th>Mother</th>
								<th width=25px></th>
								<th width=25px></th>
							</tr>
						</thead>';
					while($row = mysqli_fetch_array($result)) {
						$sqlmom="SELECT nom FROM bird WHERE bird.id=".$row['mother_id'];
						$sqldad="SELECT nom FROM bird WHERE bird.id=".$row['father_id'];
						$dad=mysqli_fetch_array(mysqli_query($base, $sqldad))['nom']; //or die ('Erreur SQL !'.$sql.'<br />'.mysqli_error($base));
						$mom=mysqli_fetch_array(mysqli_query($base, $sqlmom))['nom']; // or die ('Erreur SQL !'.$sql.'<br />'.mysqli_error($base));
						echo '<tbody>';
					    echo '<tr>';
					    echo '<td onclick="updateci(\''.$row['id'].'\',\''.$row['nom'].'\')"> <strong>' . $row['nom'] . '</strong></td>';
					    if($row['sex'] == 0){
							echo '<td onclick="updateci(\''.$row['id'].'\',\''.$row['nom'].'\')"> male </td>';
						}else{
							echo '<td onclick="updateci(\''.$row['id'].'\',\''.$row['nom'].'\')"> female</td>';
						}
					    echo '<td onclick="updateci(\''.$row['id'].'\',\''.$row['nom'].'\')">' . $row['birth_date'] . '</td>';
					    if ($row['death_date'] == "0000-00-00"){
							echo '<td onclick="updateci(\''.$row['id'].'\',\''.$row['nom'].'\')"> Alive </td>';
						}else{
							echo '<td onclick="updateci(\''.$row['id'].'\',\''.$row['nom'].'\')">' . $row['death_date'] . '</td>';
					    }
					    echo '<td onclick="updateci(\''.$row['id'].'\',\''.$row['nom'].'\')">' . $row['owner'] . '</td>';
					    //Changer l'id en nom
					    echo '<td onclick="updateci(\''.$row['id'].'\',\''.$row['nom'].'\')">' . $dad . '</td>';
					    echo '<td onclick="updateci(\''.$row['id'].'\',\''.$row['nom'].'\')">' . $mom . '</td>';
					    //Edit/delete
					    echo '<td width=25px><button type="button" class="btn btn-warning btn-xs" onclick="bird_edit_form('.$row['id'].')" data-toggle="modal" data-target="#addBird"> Edit </button></td>';
					    echo '<td width=25px><a type="button" class="btn btn-danger  btn-xs" href="delete.php?type=bird&id='.$row['id'].'&idimg='.$row['picture'].'"> Delete </a></td>';
					    echo '</tr>';
					    echo '</tbody>';
					}
					mysqli_close($base);
				?>
				</table>
			</div><!-- end div table-group -->
		</div><!--col-md-12-->
		<!--Erreur -->
		<div class="col-sm-12" id="licorne"></div>
		<div class="col-sm-12" id="infos"></div>
		<!--Zone d'affichage des informations de l'oiseau -->
		<div class="row">
				<div class="col-lg-12">
					<h3><p id="namestat"></p></h3>
					<div class="col-sm-2" id="pict"></div>
					<div class="col-sm-3" id="information"></div>
					<!-- Zone d'affichage du graph de poids en fonction du jour -->
					<div class="col-sm-7">
						<div class="col-sm-12" id="graphw"></div>
						<div class="col-sm-12"><svg width="1500" height="500" id="stats"></svg></div>
					</div>
				</div>
		<br/>
		</div><!--End birds information -->

	</div><!--End bird onglet -->

	<!-- Information sur les Humains :-->
	<div id="human_infos" class="row">
		<div class="col-md-6">
			<br/><!--Debug-->
			<div class="table-group" style="margin-left: 10px;">
				<table class="table table-striped table-bordered table-hover table-condensed">
					<thead>
						<tr>
							<th>Name</th>
							<th>Firstname</th>
							<th width=25px></th>
							<th width=25px></th>
						</tr>
					</thead>
					<tbody>
						<?php
							include_once("fonctions.php");
							$base=connectBase();
							$sql="SELECT * FROM human";
							$result = mysqli_query($base,$sql) or die ('Erreur SQL !'.$sql.'<br />'.mysqli_error($base));

							while($row = mysqli_fetch_array($result)) {
							    echo '<tr>';
									echo '<td > <strong>' . $row['name'] . '</strong></td>';
									echo '<td >'. $row['firstname'] .' </td>';
									echo '<td width=25px><button type="button" class="btn btn-warning btn-xs" onclick="human_edit_form('.$row['id'].')" data-toggle="modal" data-target="#addHuman"> Edit </button></td>';
									echo '<td width=25px><a href="delete.php?type=human&id='.$row['id'].'" class="btn btn-danger btn-xs" role="button">Delete</a></td>';
								echo '</tr>';
							}
							mysqli_close($base);
						?>
					</tbody>
				</table>
				<br/><br/>
			</div>
		</div>

	</div><!--End HUMAN-->

	<!-- PATH Information-->
	<div class="row" id="path_infos" style="margin-left: 10px;">
		<div class="row" id="path_choice" style="margin-left: 10px;">
			<br/><!--Debug-->
			<select name="path" onchange=update_path(this.value) >
				<?php
					$base=connectBase();
					$sql="SELECT * FROM run";
					$result = mysqli_query($base, $sql) or die ('Erreur SQL !'.$sql.'<br />'.mysqli_error($base));

					while($row = mysqli_fetch_array($result)) {
					    echo '<option value="0'.$row['id'].'"><strong>' . $row['run_name'] . '</strong></option>';
					}
					mysqli_close($base);
				?>
			</select>
			<span id="butoneditdel"> </span>
		</div>
		<div class="row" id="path_desc" style="margin-left: 10px;">
			<span id="path-description"></span>
		</div>
		<br/>
	</div><!--End path -->
	<!-- DAYS Information-->
	<div class="row" id="days_infos" style="margin-left: 10px;">
		<div class="row" id="path_choice" style="margin-left: 10px;">
			<br/><!--Debug-->
			<select name="birds" onchange=update_bird(this.value) >
				<?php
					$base=connectBase();
					$sql="SELECT * FROM bird";
					$result = mysqli_query($base,$sql) or die ('Erreur SQL !'.$sql.'<br />'.mysqli_error($base));
					while($row = mysqli_fetch_array($result)) {
					    echo '<option value="'.$row['id'].'"><strong>' . $row['nom'] . '</strong></option>';
					}
					mysqli_close($base);
				?>
			</select>
			<span id="daystable"> </span>
		</div>
		<div class="row" id="path_desc" style="margin-left: 10px;">
			<span id="path-description"></span>
		</div>
		<br/>
	</div><!--End path -->
</div><!--End onglets div-->

<!-- Modal -->
	<!-- Modal add-->
	 <!--Modal formBird -->
  <div class="modal fade" id="addBird" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="bird-form-title" >Add a Bird</h4>
        </div>
        <div class="modal-body">
          <?php
			include_once("formBird.php");
           ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  	 <!--Modal formJrnl -->
  <div class="modal fade" id="addJrnl" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="jrnl-form-title">Add a Bird's journey</h4>
        </div>
        <div class="modal-body">
          <?php
			include_once("formJrnl.php");
           ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
	 <!--Modal formHuman -->
	<div class="modal fade" id="addHuman" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title" id="human-form-title" >Add a Human</h4>
				</div>
				<?php
					include_once("formHuman.php")
				?>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	 <!--Modal formPath -->
	<div class="modal fade" id="addPath" role="dialog">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title" id="path-form-title">Add a Path</h4>
				</div>
				<?php	include_once("formPath.php") ?>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
