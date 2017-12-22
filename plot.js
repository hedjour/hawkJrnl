/*

<script type="text/javascript" src="plot.js"></script>
<script type="text/javascript">
	document.getElementById("canv").innerHTML += plot_liste_d([[0,0],[4,3],[5,2],[7,6],[8,1]],30,10,960,485,"red","linear");
	document.getElementById("canv").innerHTML += plot_liste_d([[0,0],[4,3],[5,2],[7,6],[8,1]],30,10,960,485,"blue","smooth");
	document.getElementById("canv").innerHTML += plot_liste_d([[0,0],[4,3],[5,2],[7,6],[8,1]],30,10,960,485,"green",50);
</script>
* 
//html 

<svg id="canv" viewBox="0 0 1000 500" preserveAspectRatio="xMinYMin meet" class="svg-content"><rect id="rec'+n_ob.key+'" x="2" y="2" width="996" height="496" style="fill:none;stroke:black;stroke-width:3px;"/></svg>



*/



function max_d(liste_point){
	if (liste_point.length > 0){
		var x = liste_point[0][0];
		var y = liste_point[0][1];
		
		for (var j = 0; j < liste_point.length; j++) {
			if (x < liste_point[j][0]){
				x = liste_point[j][0];
			}
			if (y < liste_point[j][1]){
				y = liste_point[j][1];
			}			
		}
		return [x,y];
	}
	return undefined;
}


function min_d(liste_point){
	if (liste_point.length > 0){
		var x = liste_point[0][0];
		var y = liste_point[0][1];
		
		for (var j = 0; j < liste_point.length; j++) {
			if (x > liste_point[j][0]){
				x = liste_point[j][0];
			}
			if (y > liste_point[j][1]){
				y = liste_point[j][1];
			}			
		}
		return [x,y];
	}
	return undefined;
}



function plot_liste_d(liste_point,x_deb,y_deb,l_hor,l_ver,couleur,type,format_x){
	
	if (format_x == undefined){
		format_x = ti2time;
	}
	
	var l_max = max_d(liste_point);
	
	var l_min = min_d(liste_point);
	
	console.log(l_max);
	
	var mot_final = "";
	
	mot_final += '<line x1="'+parseInt((l_min[0]-l_min[0])*(l_hor)/(l_max[0]-l_min[0])+x_deb-10)+'" y1="'+parseInt(l_ver +15+y_deb)+'" x2="'+parseInt((l_max[0]-l_min[0])*(l_hor)/(l_max[0]-l_min[0])+x_deb+10)+'" y2="'+parseInt(l_ver +15+y_deb)+'" style="stroke:rgb(0,0,0);stroke-width:4"/>\n';
	
	mot_final += '<line x1="'+parseInt((l_min[0]-l_min[0])*(l_hor)/(l_max[0]-l_min[0])+x_deb-10)+'" y1="'+parseInt(l_ver +17+y_deb)+'" x2="'+parseInt((l_min[0]-l_min[0])*(l_hor)/(l_max[0]-l_min[0])+x_deb-10)+'" y2="'+parseInt(l_ver + y_deb - (l_max[1]-l_min[1])*(l_ver)/(l_max[1]-l_min[1])-2)+'" style="stroke:rgb(0,0,0);stroke-width:4"/>\n';
	
	
	//var mot_final = '<polyline style="fill:none;stroke:'+couleur+';stroke-width:3" points="';
	mot_final += '<path style="fill:none;stroke:'+couleur+';stroke-width:3" d="M';
	
	var mot_hor = "";
	
	for (var j = 0; j < liste_point.length; j++) {
		if (j != 0){
			if (type == "smooth"){
				mot_final += " C " + ((parseInt((l_min[0]-liste_point[j][0])*(l_hor)/(l_min[0]-l_max[0]))+parseInt((l_min[0]-liste_point[j-1][0])*(l_hor)/(l_min[0]-l_max[0]))+x_deb*2)/2) + " " + parseInt(l_ver + y_deb - (l_min[1]-liste_point[j-1][1])*(l_ver)/(l_min[1]-l_max[1])) + " " + ((parseInt( (l_min[0]-liste_point[j][0])*(l_hor)/(l_min[0]-l_max[0]))+parseInt((l_min[0]-liste_point[j-1][0])*(l_hor)/(l_min[0]-l_max[0]))+x_deb*2)/2) + " " + parseInt(l_ver + y_deb - (l_min[1]-liste_point[j][1])*(l_ver)/(l_min[1]-l_max[1]))  ;
			}
			
			if (type == "linear"){
				mot_final += " L";
			}
			
			if (type != "linear" && type != "smooth"){
				mot_final += " C " + parseInt((l_min[0]-liste_point[j-1][0])*(l_hor)/(l_min[0]-l_max[0])+x_deb+type) + " " + parseInt(l_ver + y_deb - (l_min[1]-liste_point[j-1][1])*(l_ver)/(l_min[1]-l_max[1])) + " " + parseInt((l_min[0]-liste_point[j][0])*(l_hor)/(l_min[0]-l_max[0])+x_deb-type) + " " + parseInt(l_ver + y_deb - (l_min[1]-liste_point[j][1])*(l_ver)/(l_min[1]-l_max[1]))  ;
			}
			
			
		}
		
		
		if (true){//j % parseInt(1) == parseInt(0)){
			mot_hor += '<text style="fill:black;text-anchor:start;" x="'+parseInt((l_min[0]-liste_point[j][0])*(l_hor)/(l_min[0]-l_max[0])+x_deb)+'" y="'+parseInt(l_ver +30+y_deb)+'" transform="rotate('+(90)+' '+parseInt((l_min[0]-liste_point[j][0])*(l_hor)/(l_min[0]-l_max[0])+x_deb)+','+parseInt(l_ver +30+y_deb)+')">'+format_x(liste_point[j][0])+'</text>';
			
			mot_hor += '<line x1="'+parseInt((l_min[0]-liste_point[j][0])*(l_hor)/(l_min[0]-l_max[0])+x_deb)+'" y1="'+parseInt(l_ver +15+y_deb)+'" x2="'+parseInt((l_min[0]-liste_point[j][0])*(l_hor)/(l_min[0]-l_max[0])+x_deb)+'" y2="'+parseInt(l_ver +22+y_deb)+'" style="stroke:rgb(0,0,0);stroke-width:4"/>\n';
			
			mot_hor += '<text style="fill:black;text-anchor:end;" x="'+parseInt(0*(l_hor)/(l_min[0]-l_max[0])+x_deb-20)+'" y="'+parseInt(l_ver + y_deb - (l_min[1]-liste_point[j][1])*(l_ver)/(l_min[1]-l_max[1])+5)+'" >'+(liste_point[j][1])+'</text>';
			
			mot_hor += '<line x1="'+parseInt(0*(l_hor)/(l_min[0]-l_max[0])+x_deb-10)+'" y1="'+parseInt(l_ver + y_deb - (l_min[1]-liste_point[j][1])*(l_ver)/(l_min[1]-l_max[1]))+'" x2="'+parseInt(0*(l_hor)/(l_min[0]-l_max[0])+x_deb-17)+'" y2="'+parseInt(l_ver + y_deb - (l_min[1]-liste_point[j][1])*(l_ver)/(l_min[1]-l_max[1]))+'" style="stroke:rgb(0,0,0);stroke-width:4"/>\n';
			
			
		}
		
		mot_final += " " + parseInt((l_min[0]-liste_point[j][0])*(l_hor)/(l_min[0]-l_max[0])+x_deb) + " " + parseInt(l_ver + y_deb - (l_min[1]-liste_point[j][1])*(l_ver)/(l_min[1]-l_max[1]));
	}
	mot_final +=  '" />';
	//console.log(mot_hor);
	mot_final += mot_hor;
	
	return mot_final;
	
}

var glob_liste_jour = ["di","lu","ma","me","je","ve","sa"];

// Convertisseur timestamp en heure
function ti2time(temps){
	var date = new Date(temps);
	return "" + glob_liste_jour[date.getDay()] + " " + date.getDate() + "/" + (date.getMonth()+1) + "/" + date.getFullYear();
}
