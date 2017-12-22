	<script type="text/javascript">
		$(document).ready(function() {
			// Lorsque je soumets le formulaire
			$('#humanForm').on('submit', function(e) {
				e.preventDefault(); // J'empêche le comportement par défaut du navigateur, c-à-d de soumettre le formulaire
				var $this = $(this); // L'objet jQuery du formulaire
		 
				// Je récupère les valeurs
				var firstname = $('#firstname').val();
				var name = $('#name').val();
		 
				// Je vérifie une première fois pour ne pas lancer la requête HTTP
				// si je sais que mon PHP renverra une erreur
				if(name === '' || firstname === '') {
					alert('Name et firstname are empty');
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
	                    error: function(json) {
	                        alert("An unexpected error occured :\n" + json.reponse);
	                    }
					});
				}
			});
		});
	</script>
	
	<h1>New human in the DB  </h1>
	<form id="humanForm" action="addHuman.php" method="post" class="form-horizontal" role="form">
	<input hidden="TRUE" id="id_human", name="ids"> </input>
	<input hidden="TRUE" id="typs", name="typs" value="human"> </input>
	<div class="form-group">
		<label class="control-label col-sm-2" for="first_name">First Name:</label>
		<input type=="text" name="first_name" id="first_name"/>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="name">Name:</label>
		<input type="text" name="name" id="name"/>
	</div>

		<button id="boutonaddHuman" class="btn btn-success btn-md"  type="submit">Send it </button>
	</form>
