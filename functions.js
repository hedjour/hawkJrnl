/*
 * Faire une fonction JS appelée par wild si wild is no capture date is empty
 * Récupérer les fonctions actives désactives un champs de vincents en lui posant la question.
 * Gérer l'activation ou non des champs dans les formulaire
 */
///--------- Gestion des onglets : tabs
 $(function() {
                var tabs = $( "#onglets" ).tabs();
                tabs.find( ".ui-tabs-nav" ).sortable({
                  axis: "x",
                  stop: function() {
                    tabs.tabs( "refresh" );
                  }
                });
            }); 
 
///--------- Gestion de l'affichage des éléments
function updateci(id, nom){
	//Evolution possible controle clic permet d'afficher les courbes de plusieurs oiseaux
	//Affichage du nom de l'oiseau dans le
	document.getElementById('namestat').innerHTML="<h3>Statistiques de <strong>" + nom +"</strong></h3>" ;
	//Infos
	make_infos(id);
	//stat
	make_graphw(id);
	if (document.getElementById("graphw").innerHTML != "<strong> No Journal Information</strong>"){//We create stat if jrnl exist
		make_stat(id);
	}
}
function update_path(id){
	$.ajax({
		url:'getInfo.php',
		type: 'POST', // La méthode utilisée
		dataType: 'json', // JSON
		data:{ids:id, typs:"path_info"},
		success: function(reptable) {
			var desc = JSON.parse( JSON.stringify(reptable) );
			document.getElementById("path-description").innerHTML=desc.description;
			var but='<button type="button" class="btn btn-warning btn-xs" onclick="path_edit_form('+id+')" data-toggle="modal" data-target="#addPath">Edit</button>';
			but+='<a href="delete.php?type=path&id='+id+'" class="btn btn-danger btn-xs" role="button">Delete</a>';
			document.getElementById("butoneditdel").innerHTML=but;
		},
		error: function(a,status) {
			console.log("getPathinfo plante" +status );
		}
	});
}
function update_bird(id){
	$.ajax({
		url:'getInfo.php',
		type: 'POST', // La méthode utilisée
		dataType: 'json', // JSON
		data:{ids:id, typs:"jrnls_info"},
		success: function(reptable) {
			var desc = JSON.parse( JSON.stringify(reptable) );
			document.getElementById("path-description").innerHTML=desc.description;
			document.getElementById("daystable").innerHTML=desc['table'];
		},
		error: function(reptable,status) {
			var desc = JSON.parse( JSON.stringify(reptable) );
			document.getElementById("daystable").innerHTML = "Unexpected error occured when I interrogate the DB \n";
			console.log("status erreur");
			console.log(status);
		}
	});
	
	}

///-------------------------------------------Infos Statistique------------------------------
function make_infos(id){
	phrase='<h3>General informations</h3>';
	phrase+='<p class="info"> Species : <span id="spec"></span> </p>';
	phrase+='<p class="info"> Sex : <span id="sex"></span> </p>';
	phrase+='<p class="info"> Birth date : <span id="bd"></span> </p>';
	phrase+='<p id="death"></p>';
	phrase+='<p class="info"> Owner : <span id="own"></span> </p>';
	phrase+='<span id="captinfo"></span>'
	document.getElementById("information").innerHTML =phrase;
	
	$.ajax({
		url:'getInfo.php?id='+id+'&typ=ci', //TODO modifier pour faire que du POST
		type: 'POST', // La méthode utilisée
		dataType: 'json', // JSON
		data:{ids:id, typs:"ci"},
		success: function(reptable) {
			var table = JSON.parse( JSON.stringify(reptable) );
			//console.log(table); //DEBUG
			document.getElementById("pict").innerHTML ='<img width="214" height="273" src="'+table["path"] +'" alt="bird avatar">';
			document.getElementById("spec").innerHTML =table["species"];
			if (table['sex'] == 0){
				document.getElementById("sex").innerHTML ="male";
			}else{
				document.getElementById("sex").innerHTML ="female";
			}
			document.getElementById("bd").innerHTML =table["birth_date"];
			if (! (table['death_date'] == "0000-00-00") ){
				document.getElementById("death").innerHTML ='<p class=""> Death date :'+table['death_date'] +' </p>';
			}
			document.getElementById("own").innerHTML =table["owner"];
			if (table["wild"] == "0"){
				capturephrase='<h3>Capture informations</h3>';
				capturephrase+='<p> Date of capture :">'+table["captureDate"] +'</p>';
				capturephrase+='<p> Country of capture :">'+table["country"] +'</p>';
			}else{
				capturephrase=" ";
			}
			document.getElementById("captinfo").innerHTML=capturephrase;	
		},
		error: function(a,status) {
			console.log("getPathinfo plante" +status );
		}
	});
}

///-------------------------------------------Statistiques------------------------------

function make_graphw(id){	
	//Charge un fichier php qui donne les information à afficher concernant poids tout ça info animal
	//passage par du json
	$.ajax({
		//url:'getTablew.php?id='+id, // Le nom du fichier indiqué dans le formulaire//TODO modifier pour faire que du POST
		url:'getInfo.php?id='+id+'&typ=weight',
		type: 'POST', // La méthode utilisée
		dataType: 'json', // JSON
		data:{ids:id, typs:"weight"},
		success: function(reptable) {
			var table = JSON.parse( JSON.stringify(reptable) );
			var value = [];
			if(table.date.length > 0 && table.weight.length == table.date.length){
				for (i=0; i < table.date.length; i++){
						day= new Date(table.date[i])
						value.push([ Number(day) , parseFloat(table.weight[i]) ]);
				}
				document.getElementById("graphw").innerHTML ='<svg id="canv" width="1200" height="500"><rect id="rec\'+n_ob.key+\'" x="2" y="2" width="996" height="496" style="fill:none;stroke:black;stroke-width:3px;"/></svg>'
				document.getElementById("canv").innerHTML = plot_liste_d(value,100,50,700,300,"blue","smooth");
			}else{
				document.getElementById("graphw").innerHTML = "<strong> No Journal Information</strong>";
			}
			},
		error: function() {
			console.log("gettable plante");
		}
	});
}

//Todo modify pour afficher plusieurs oiseaux en simmultané en terme de courbe de poids
function maj_graphw(x,y){
	//Charge un fichier php qui donne les information à afficher concernant poids tout ça info animal
	//passage par du json
	$.ajax({
		url:'getTablew.php?id='+id, // Le nom du fichier indiqué dans le formulaire//TODO modifier pour faire que du POST
		type: 'POST', // La méthode utilisée
		dataType: 'json', // JSON
		data:{ids:id},
		success: function(reptable) {
			var table = JSON.parse( JSON.stringify(reptable) );
			var value = [];
			if(table.date.length > 0 && table.weight.length == table.date.length){
				for (i=0; i < table.date.length; i++){
						day= new Date(table.date[i])
						value.push([ Number(day) , parseFloat(table.weight[i]) ]);
				}
				document.getElementById("graph").innerHTML ='<svg id="canv" width="1000" height="500"><rect id="rec\'+n_ob.key+\'" x="2" y="2" width="996" height="496" style="fill:none;stroke:black;stroke-width:3px;"/></svg>'
				document.getElementById("canv").innerHTML += plot_liste_d(value,30,100,960,485,"blue","smooth");
			}else{
				document.getElementById("graph").innerHTML = "<strong> No Journal Information</strong>";
			}
			},
		error: function() {
			console.log("gettable plante");
		}
	});
}

function make_stat(id){	
///Human-stat
	$.ajax({
		url:'getInfo.php?id='+id+'&typ=hum', // Le nom du fichier indiqué dans le formulaire//TODO modifier pour faire que du POST
		type: 'POST', // La méthode utilisée
		dataType: 'json', // JSON
		data:{ids:id, typs:"hum"},
		success: function(reptable) {
			var table = JSON.parse( JSON.stringify(reptable) );
			var L=table.data;
			var nam=tab2obj(table.legend);
			var col=init_col(tab2l(table.legend));
			if(table.data.length > 0){
				//Ajoute le disque de travail avec les humains
				 document.getElementById("stats").innerHTML = svg_disque(50,50,ob_nb(L),col)+svg_legende(100,25,col,nam);
			}else{
				document.getElementById("stats").innerHTML = "";
			}
		},
		error: function(a,status) {
			console.log("getHuman stat plante" +status );
		}
	});
///PAth-stat
	$.ajax({
		url:'getInfo.php?id='+id+'&typ=path', // Le nom du fichier indiqué dans le formulaire//TODO modifier pour faire que du POST
		type: 'POST', // La méthode utilisée
		dataType: 'json', // JSON
		data:{ids:id, typs:"path"},
		success: function(reptable) {
			var table = JSON.parse( JSON.stringify(reptable) );
			var L=table.data;
			var nam=tab2obj(table.legend);
			var col=init_col(tab2l(table.legend));
			if(table.data.length > 0){
				 document.getElementById("stats").innerHTML += svg_disque(400,50,ob_nb(L),col)+svg_legende(450,25,col,nam);
			}
		},error: function(a,status) {
			console.log("gettable plante" +status);
		}
	});
///Status chasseur ou non:
$.ajax({
		url:'getInfo.php?id='+id+'&typ=state',
		type: 'POST', // La méthode utilisée
		dataType: 'json', // JSON
		data:{ids:id, typs:"state"},
		success: function(reptable) {
			var table = JSON.parse( JSON.stringify(reptable) );
			var L=table.data;
			var val_luminosite_pr = 169;
			var colhunt='rgb('+parseInt(val_luminosite_pr)+','+parseInt(255*val_luminosite_pr/3*4)+','+parseInt(0)+')';
			var colhung='rgb('+parseInt(0)+','+parseInt(val_luminosite_pr)+','+parseInt(255*val_luminosite_pr/3*4)+')';
			var colfatt='rgb('+parseInt(255*val_luminosite_pr/3*4)+','+parseInt(val_luminosite_pr)+','+parseInt(0)+')';
			var col={"hunt":colhunt,"hung":colhung,"fat":colfatt};
			if(table.data.length > 0){
				document.getElementById("canv").innerHTML += svg_barre_hor(L,col,90,810,5);
				document.getElementById("stats").innerHTML += svg_legende(600,25,col,{"hunt":"Hunter","hung":"Hungry","fat":"Fat"});
			}
		},error: function() {
			console.log("gettable plante");
		}
	});
}///Fin make_stat

///----------------------------------------------------Edit part--------------------------

///BIRD
function bird_edit_form(id){//Cette fonction modifie le modal et le formulaire de bird_edit
	$.ajax({
		url:'getInfo.php?id='+id+"&typ=bird_info",
		type:'POST',
		data:{ids:id, typs:"bird_info"}, //Formulation correcte TODO utiliser partout et transformer id en ids pour que ça fonctionne dans getInfo
		dataType:'json',
		success: function (reptable){
			var table = JSON.parse( JSON.stringify(reptable) );
			document.getElementById("bird-form-title").innerHTML="Edit bird"+table['nom'];
			document.getElementById("birdForm").action="edit.php";
			$('#id_bird').val(id);
			$('#bird_name').val(table['nom']);
			$('#sex').val(table['sex']);
			$('#species').val(table['species']);
			$('#bd_cal').val(table['birth_date']);
			$('#dd_cal').val(table['death_date']);
			$('#owner').val(table['owner']);
			$('#pub').val(table['privat']);
			$('#father').val(table['father_id']);
			$('#mother').val(table['mother_id']);
			$('#wild').val(table['wild']);
			$('#cd_cal').val(table['captureDate']);
			$('#country').val(table['country']);
			//document.getElementById("userfile

		},
		error: function(){
			console.log ("bird edit plante");
		}
	});
}
function clean_birdform(){
	$('#bird_name').val("");
	$('#sex').val(0);
	$('#species').val("");
	$('#bd_cal').val("");
	$('#dd_cal').val("");
	$('#owner').val("");
	$('#pub').val(0);
	$('#father').val(2);
	$('#mother').val(1);
	$('#wild').val(1);
	$('#cd_cal').val("");
	$('#country').val("");
	//$('#userfile').val();
}

///HUMAN
function human_edit_form(id){
	$.ajax({
			url:'getInfo.php?id='+id+'&typ=path_info',
			type: 'POST', // La méthode utilisée
			dataType: 'json', // JSON
			data:{ids:id, typs:"human_info"},
			success: function(reptable) {
				var table = JSON.parse( JSON.stringify(reptable) );
				document.getElementById("human-form-title").innerHTML="Edit Path "+table['name'];
				document.getElementById("humanForm").action="edit.php";
				$('#id_human').val(id);
				$('#first_name').val(table['firstname']);
				$('#name').val( table['name']);
			},
			error: function() {
				console.log("getPathinfo plante");
			}
	});
}
function clean_humanform(){
//	document.getElementById("bird-form-title").innerHTML="Add Human";		//Old version
	document.getElementById("bird-form-title").innerHTML="Add Bird";		//Odelin's try
	$('#first_name').val("");
	$('#name').val("");
}

///PATH
function path_edit_form(id){
	$.ajax({
			url:'getInfo.php',
			type: 'POST', // La méthode utilisée
			dataType: 'json', // JSON
			data:{ids:id, typs:"path_info"},
			success: function(reptable) {
				var table = JSON.parse( JSON.stringify(reptable) );
				document.getElementById("path-form-title").innerHTML="Edit Path "+table['run_name'];
				document.getElementById("pathForm").action="edit.php";
				$('#id_path').val(id);
				$('#name_path').val(table['run_name']);
				$('#description').val( table['description']);
			},
			error: function() {
				console.log("getPathinfo plante");
			}
	});
}
function clean_pathform(){
	document.getElementById("path-form-title").innerHTML="Add Path";
	$('#name_path').val("");
	$('#description').val("");
}

///JRNL
function jrnl_edit_form(id){
	$.ajax({
			url:'getInfo.php',
			type: 'POST', // La méthode utilisée
			dataType: 'json', // JSON
			data:{ids:id, typs:"jrnl_info"},
			success: function(reptable) {
				var table = JSON.parse( JSON.stringify(reptable) );
				document.getElementById("jrnl-form-title").innerHTML="Edit bird's day "+table['run_name'];
				document.getElementById("pathForm").action="edit.php";
				 //id 	day 	bird_id 	weight 	performance 	quarrytaken 	food 	state 	run 	taker
				$('#id_jrnl').val(id);
				$('#dat').val(table['day']);
				$('#bird_id').val(table['bird_id']);
				$('#weight').val(table['weight']);
				$('#perf').val(table['performance']);
				$('#state').val(table['state']);
				$('#food').val(table['food']);
				$('#path').val(table['run']);
				$('#quarrytaken').val(table['quarrytaken']);
				$('#taker').val(table['taker']);
			},
			error: function() {
				console.log("getPathinfo plante");
			}
	});
}
function clean_jrnlform(){
	document.getElementById("jrnl-form-title").innerHTML="Add Path";
	$('#dat').val("");
	$('#bird_id').val("7");//TODO adapt to the base
	$('#weight').val("");
	$('#perf').val("");
	$('#state').val("hunt");
	$('#food').val("");
	$('#path').val("2");
	$('#quarrytaken').val("");
	$('#taker').val("7");
}
function wildchange(val){
	if (val == 1){
		$("#country").hide()
		$("#cd_cal").hide()
	}else{
		$("#country").show()
		$("#cd_cal").show()
	}
	}
///----------------------------------------------------BIN--------------------------
