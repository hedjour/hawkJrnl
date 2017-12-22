		<script type="text/javascript">
			/*You can also place this code in a separate file and link to it like epoch_classes.js*/
			//window.onload = function () {};
				$(function() {
					$( '#dat' ).datepicker({ dateFormat: "yy-mm-dd"});
					$( '#dat' ).datepicker();
				 });
		</script>
		<script type="text/javascript">
		$(document).ready(function() {
			// Lorsque je soumets le formulaire
			$('#jrnlForm').on('submit', function(e) {
				e.preventDefault(); // J'empêche le comportement par défaut du navigateur, c-à-d de soumettre le formulaire

				var $this = $(this); // L'objet jQuery du formulaire

				// Je récupère les valeurs
			/*
			**date
			*bird_id
			*weight
			*perf
			*state
			*food
			*path
			*quarrytaken
			*taker
			*
			*/
			var dat= $('#dat').val();
			console.log(dat);
			var bird_id= $('#bird_id').val();
			var weight= $('#weight').val();
			var perf= $('#perf').val();
			var state= $('#state').val();
			var food= $('#food').val();
			var path= $('#path').val();
			var quarrytaken= $('#quarrytaken').val();
			var taker= $('#taker').val();


				// Je vérifie une première fois pour ne pas lancer la requête HTTP
				// si je sais que mon PHP renverra une erreur
				if( dat === '' || bird_id === '' || weight === '' || perf === '' || state === '' || food === '' || path === '' || quarrytaken === '' || taker  === '') {
					alert('Les champs doivent êtres remplis');
				} else {
					// Envoi de la requête HTTP en mode asynchrone
					$.ajax({
						url: $this.attr('action'), // Le nom du fichier indiqué dans le formulaire
						type: $this.attr('method'), // La méthode indiquée dans le formulaire (get ou post)
						data: $this.serialize(), // Je sérialise les données (j'envoie toutes les valeurs présentes dans le formulaire)
						dataType: 'json', // JSON
						success: function(json) {
		                        alert(json.reponse);
		                        location.reload();
		                    },
		                error: function(reponse){
							alert("An error occured in add jrnl\n " +json.reponse);
							}
					});
				}
			});
		});
	</script>

<form id="jrnlForm" action="addJrnl.php" method="post">
	<input hidden="TRUE" id="id_jrnl", name="ids"> </input>
	<input hidden="TRUE" id="typs", name="typs" value="jrnl"> </input>
	<div class="form-group"><!--Day-->
		<label class="control-label col-sm-2" for="dat">Date:</label>
		<input id="dat" name="dat" type=="text" value="<?php echo $TODAY; ?>" />
	</div>
	<div class="form-group"><!--Bird-->
		<label class="control-label col-sm-2" for="bird_id">Bird:</label>
		<select name="bird_id" id="bird_id">
			<?php
			$base=connectBase();
			$query = mysqli_query($base, "SELECT * FROM bird WHERE bird.death_date=0000-00-00");
			while ($result = mysqli_fetch_assoc($query)) {
				 echo '<option value="'.$result['id'].'">'.$result['nom'].'</option>';
			}
			mysqli_close($base);
			?>
		</select>
	</div>
	<div class="form-group"><!--Weight-->
		<label class="control-label col-sm-2" for="weight">Weight:</label>
		<input type="double" name="weight" id="weight" value="0.0" />
	</div>
	<div class="form-group"><!--Perf-->
		<label class="control-label col-sm-2" for="perf">Performance:</label>
		<input type="text" name="perf" id="perf" />
	</div>
	<div class="form-group"><!--State-->
		<label class="control-label col-sm-2" for="state">State:</label>
		<select name="state" id="state">
			<option value="hung">Hungry</option>
			<option value="hunt">Hunter</option>
			<option value="fat">Fat</option>
		</select>
	</div>
	<div class="form-group"><!--Food-->
		<label class="control-label col-sm-2" for="food">Food (number):</label>
		<input type="int" name="food" id="food"/>
	</div>
	<div class="form-group"><!--Path-->
		<label class="control-label col-sm-2" for="path">Path:</label>
		<select name="path" id="path">
			<?php
				$base=connectBase();
				$query = mysqli_query($base, "SELECT * FROM possiblerun");
				while ($result = mysqli_fetch_assoc($query)) {
					echo '<option value="'.$result['id'].'">'.$result['run_name'].'</option>';
				}
				mysqli_close($base);
			?>
		</select>
	</div>
	<div class="form-group"><!--Quarry Taken-->
		<label class="control-label col-sm-2" for="quarrytaken">Quarry Taken:</label>
		<input type="text" name="quarrytaken" id="quarrytaken"/>
	</div>
	<div class="form-group"><!--Taker-->
		<label class="control-label col-sm-2" for="taker">Taker:</label>
		<select name="taker" id="taker">
			<?php
				$base=connectBase();
				$query = mysqli_query($base, "SELECT * FROM human");
				while ($result = mysqli_fetch_assoc($query)) {
					echo '<option value="'.$result['id'].'">'.$result['firstname']."-".$result['name'].'</option>';
				}
				mysqli_close($base);
			?>
		</select>
	</div>
<button id="boutonaddJrnl" class="btn btn-success btn-md"  type="submit">Send it </button>
</form>
