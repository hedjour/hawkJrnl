///Function for Statistique information
function isIn(li,x){
        for(var j = 0;j<li.length;j++){
            if (li[j] == x){
                return true;
            }
        }
        return false;
    }

function ob_nb(li){
        var ob = {};
        var n = li.length;
        for (var j = 0; j<li.length ; j++){
            if (isIn(Object.keys(ob),li[j])){
                ob[li[j]] += 1/n;
            }
            else{
                ob[li[j]] = 1/n;
            }
        }

        return ob;
    }

function polarToCartesian(centerX, centerY, radius,angleInDegrees){
        var angleInRadians = (angleInDegrees-90) * Math.PI / 180.0;

        return {
            x: centerX + (radius * Math.cos(angleInRadians)),
            y: centerY + (radius * Math.sin(angleInRadians))
        };
    }

function describeArc(x, y, radius, startAngle, endAngle){

        var start = polarToCartesian(x, y, radius, endAngle);
        var end = polarToCartesian(x, y, radius, startAngle);

        var arcSweep = endAngle - startAngle <= 180 ? "0" : "1";

        var d = [
            "M", start.x, start.y,
            "A", radius, radius, 0, arcSweep, 0, end.x, end.y
                ].join(" ");

        return d;
    }

function svg_disque(x,y,ob_pr,ob_coul){
        var angle_aux = 0;
        var li =  Object.keys(ob_pr);
        m = "";
        for (var j = 0; j <li.length; j++) {
            m += '<path fill="none" stroke="'+ob_coul[li[j]]+'" stroke-width="15" d ="'+describeArc(x, y, 25, angle_aux, (angle_aux+ob_pr[li[j]]*360-0.01))+'"/>';
             angle_aux += ob_pr[li[j]]*360;
        }
        return m;
    }

function svg_barre_hor(li,ob_coul,xmin,xmax,y){
        if (li.length == 0){
            return undefined;
        }
        var ind = li[0];
        var n = (xmax-xmin)/li.length;
        m = '<line style="fill:'+ob_coul[li[0]]+';stroke:'+ob_coul[li[0]]+';stroke-width:10px;" x1="'+xmin+'" y1="'+y+'" ';
        for (var j = 1; j<li.length;j++){
            if (li[j] != ind){
                m += 'x2="'+(xmin+n*(j))+'" y2="'+y+'" />\n';
                m += '<line style="fill:'+ob_coul[li[j]]+';stroke:'+ob_coul[li[j]]+';stroke-width:10px;" x1="'+(xmin+n*(j))+'" y1="'+y+'" ';
                ind = li[j];
            }
        }
        m += 'x2="'+(xmin+n*(j))+'" y2="'+y+'" />';
        //console.log(m);
        return m;
    }
    
function svg_legende(x,y,ob_coul,ob_name){
	console.log("svglegend");//DEBUG
	console.log(ob_coul);//DEBUG
	console.log(ob_name);//DEBUG
        var m = "";
        var k = x;
        var li = Object.keys(ob_name)
        
        for (var j = 0; j<li.length;j++){
            m += '<rect x="'+x+'" y="'+(y+25*j)+'" width="20" height="10" style="fill:'+ob_coul[li[j]]+';stroke:black;stroke-width:1px;"/>';
            m += '<text style="fill:black;text-anchor:start;" x="'+(x+25)+'" y="'+(y+25*j+10)+'" >'+ob_name[li[j]]+'</text>';
        }    
        return m;
        
    }

function init_col(list){ //TODO Vérifier que cela fonctionne correctement
	// Luminosite initial
	var val_luminosite_pr = 169;
	var col = {};
	var nbb = list.length;
	for (var i = 0; i < nbb; i++) {
		var coltmp = "";
		if (i < nbb/4){
			coltmp = 'rgb('+parseInt(i*val_luminosite_pr/nbb*4)+','+parseInt(val_luminosite_pr)+','+parseInt(0)+')';
		}
		if (i < nbb/2 && i >= nbb/4){
			coltmp = 'rgb('+parseInt(val_luminosite_pr)+','+parseInt(val_luminosite_pr-i*val_luminosite_pr/nbb*4+val_luminosite_pr)+','+parseInt(0)+')';
		}
		if (i < nbb*3/4 && i >= nbb/2){
			coltmp = 'rgb('+parseInt(val_luminosite_pr)+','+parseInt(0)+','+parseInt(i*val_luminosite_pr/nbb*4-2*val_luminosite_pr)+')';
		}
		if (i < nbb && i >= nbb*3/4){
			coltmp = 'rgb('+parseInt(val_luminosite_pr-i*val_luminosite_pr/nbb*4+3*val_luminosite_pr)+','+parseInt(0)+','+parseInt(val_luminosite_pr)+')';
		}
		col[list[i]] = coltmp; ///BUG ICI FIXME
	}
	return col;
}
function tab2obj(tab){
	var ln=tab.length;
	var obj = {}; 
	for (i =0;i<ln;i++){
		obj[tab[i].split(":")[0]]=tab[i].split(":")[1];
	}
	return obj;
}

function tab2l(tab){
	var ln=tab.length;
	var l = []; 
	for (i =0;i<ln;i++){
		l[i]=tab[i].split(":")[0];
	}
	return l;
}
