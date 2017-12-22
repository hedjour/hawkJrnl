<script type="text/javascript">
	/*You can also place this code in a separate file and link to it like epoch_classes.js*/
	//window.onload = function () {};
		$(function() {
			$( '#bd_cal' ).datepicker({ dateFormat: "yy-mm-dd"});
			$( '#bd_cal' ).datepicker();
			$( '#dd_cal' ).datepicker({ dateFormat: "yy-mm-dd"});
			$( '#dd_cal' ).datepicker();
			$( '#cd_cal' ).datepicker({ dateFormat: "yy-mm-dd"});
			$( '#cd_cal' ).datepicker();
		});
		$(document).ready(function() {
			$("#country").hide()
			$("#cd_cal").hide()
		});
</script>
<script type="text/javascript">
	$(document).ready(function() {
		// Lorsque je soumets le formulaire
		$('#birdForm').on('submit', function(e) {
			e.preventDefault(); // J'empêche le comportement par défaut du navigateur, c-à-d de soumettre le formulaire

			var $this = $(this); // L'objet jQuery du formulaire

			// Je récupère les valeurs Adapter la page ici
			/* Value to get
	 * ""
	 * bird_name //nom in the db
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
	var bird_name= $('#bird_name').val();
	var sex= $('#sex').val();
	var species= $('#species').val();
	var birth_date= $('#bd_cal').val();
	var death_date= $('#dd_cal').val();
	var owner= $('#owner').val();
	var privat= $('#pub').val();
	var father_id= $('#father').val();
	var mother_id= $('#mother').val();
	var wild= $('#wild').val();
	var captureDate= $('#cd_cal').val();
	var country= $('#country').val();
	var picture= $('#userfile').val(); //$('#country').val();
	console.log("Verif picture :");
	console.log(picture);

			// Je vérifie une première fois pour ne pas lancer la requête HTTP
			// si je sais que mon PHP renverra une erreur
			if(bird_name == '' || sex == '' || species == '' || birth_date == '' || owner == '' || privat == '' || father_id == '' ||  mother_id == '' || wild	== '' ) { //* || picture
				alert('Les champs nom -'+bird_name+'-\n-sex-'+sex+'- \n species -'+ species +'-\n birth date -'+ birth_date+'-\n owner -'+owner+'-\n privat-'+privat+'-\n father -'+father_id+'-\n and mother -'+mother_id+'- \n wild'+wild);
				console.log("Send made");
				console.log(mother_id);
				console.log(father_id);

			}else if( wild=='0' && (captureDate == '' || country == '') ){
				alert('Is this animal wild ? if yes I need his capture country and his date of capture');
			} else {
				// Envoi de la requête HTTP en mode asynchrone
				$.ajax({
					url: $this.attr('action'), // Le nom du fichier indiqué dans le formulaire
					type: $this.attr('method'), // La méthode indiquée dans le formulaire (get ou post)
					data: $this.serialize(), // Je sérialise les données (j'envoie toutes les valeurs présentes dans le formulaire)
					dataType: 'json', // JSON
					success: function(json) {
	                        alert(json.reponse);//TODO Voir pour considérer le code
	                        location.reload();
	                    },
	        error: function(json){
									alert("An error occured in add bird\n " +json.reponse);
						}
				});
			}
		});
	});
</script>

<form id="birdForm" action="addBird.php" method="post" enctype="multipart/form-data"  class="form-horizontal" role="form">
	<input hidden="TRUE" id="id_bird", name="ids"> </input>
	<input hidden="TRUE" id="typs", name="typs" value="bird"> </input>
	<div class="form-group">
		<label class="control-label col-sm-2" for="bird_name">Name:</label>
		<input type=="text" name="bird_name" id="bird_name"/>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="sex">Sex:</label>
		<select name="sex" id="sex">
			<option value="0">Male</option>
			<option value="1">Female</option>
		</select>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="species">Species:</label>
		<input type=="text" name="species" id="species"/>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="bd_cal">Birth Date:</label>
		<input id="bd_cal" type=="text" name="bd_cal" value="<?php echo $TODAY; ?>" />
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="dd_cal">Death Date:</label>
		<input name="dd_cal" id="dd_cal" type=="text"/>
	</div>

	<div class="form-group">
		<label class="control-label col-sm-2" for="owner">Owner:</label>
		<input type="text" name="owner" id="owner"/>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="pub">Private / Public:</label>
		<select name="pub" id="pub">
			<option value="0">Private</option>
			<option value="1">Public</option>
		</select>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="mother">Mother:</label>
		<select name="mother" id="mother">
		<?php
			$base=connectBase();
			$query = mysqli_query($base, "SELECT * FROM bird WHERE bird.sex = '1'" );
				 while ($result = mysqli_fetch_assoc($query)) {
					 echo '<option value="'.$result['id'].'">'.$result['nom'].'</option>';
				}
			mysqli_close($base);
		?>
		</select>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="father">Father:</label>
		<select name="father" id="father">
			<?php
				$base=connectBase();
				$query = mysqli_query($base, "SELECT * FROM bird WHERE bird.sex = '0' ");
				while ($result = mysqli_fetch_assoc($query)) {
					echo '<option value="'.$result['id'].'">'.$result['nom'].'</option>';
				}
				mysqli_close($base);
			?>
		</select>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="wild">Wild:</label>
		<select name="wild" id="wild" onchange=wildchange(this.value)>
			<option value="1">No</option>
			<option value="0">Yes</option>
		</select>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="cd_cal">Capture date:</label>
		<input name="cd_cal" id="cd_cal" type=="text" value="<?php //echo $TODAY ;?>"/>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="country">Country:</label>
		<input type="text" name="country" id="country"/>
	</div> <!-- Faire attention à tous placer en minuscule. -->
	<div class="form-group">
		<label class="control-label col-sm-2" for="userfile">Image:</label>
		<input id="userfile" name="userfile" type="file" size="15" />
	</div>
	<input id="boutonaddBird" name="boutonaddBird" class="btn btn-success btn-md"  type="submit" form="birdForm" formmethod="POST" value="Send it"/>
</form>
