	<!-- title>Add a human in the data base</title -->
	<script type="text/javascript">
		$(document).ready(function() {
			// Lorsque je soumets le formulaire
			$('#pathForm').on('submit', function(e) {
				e.preventDefault(); // J'empêche le comportement par défaut du navigateur, c-à-d de soumettre le formulaire
				var $this = $(this); // L'objet jQuery du formulaire

				// Je récupère les valeurs
				var name = $('#name_path').val();
				var description = $('#description').val();

				// Je vérifie une première fois pour ne pas lancer la requête HTTP
				// si je sais que mon PHP renverra une erreur
				if(name === '' || description === '') {
					alert('Les champs doivent êtres remplis');
					console.log("erreur un de ces champs est vide :");
					console.log(name);
					console.log (description);
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
	                        alert(json.reponse);
	                    }
					});
				}
			});
		});
	</script>

	<h1>New hunt path in the DB  </h1>
<form id="pathForm" action="addPath.php" method="post" class="form-horizontal" role="form">
	<input hidden="TRUE" id="id_path", name="ids"> </input>
	<input hidden="TRUE" id="typs", name="typs" value="path"> </input>
		<div class="form-group">
			<label class="control-label col-sm-2" for="name">Name:</label>
			<input type=="text" name="name" id="name_path"/>
		</div>
		<div  id="champs"  class="form-group">
			<input type="text" name="node[]" />
			<script type="text/javascript" >
				var div = document.getElementById('champs');
				function addInput(nam){
					var input = document.createElement("input");
					input.type = "text";
					input.name = "node[]";
					div.appendChild(input);
				}
				function addField() {
					div.appendChild(document.createElement("br"));
					addInput("node[]");
				}
			</script> 
		</div>
		<div  class="form-group">
			<button type="button" onclick="addField()" >Add a node</button>
		</div>
	<button id="boutonAddPath" class="btn btn-success btn-md"  type="submit">Send it </button>
</form>

