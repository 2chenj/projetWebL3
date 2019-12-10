const width_canevas = 1700;
const height_canevas = 1200;
const nb_barre = 2;
const width_barre = 24;				
const espace_barres = 10;				
graph = document.getElementById("dessin");
ctx = graph.getContext("2d");
tabBlocs = [];
grossisement = 0.5;

$.ajax({
	type:'get',
	url:"res/resRepresentation.php",
	success:function(data){
	        console.log(data)
	        var decalageWidth = 200;
	        var decalageHeight = 50;

	        printLegendes();
	        printAxe(decalageWidth-20, decalageHeight,grossisement);
			//line(decalageWidth-20,(height_canevas/2),width_canevas,(height_canevas/2));	        
			printPlusieuresBarres(width_barre, data, decalageWidth, decalageHeight);	                
	            
	}
})

graph.addEventListener(
	"mousemove", 
	(function(evt) {
		var rect = evt.target.getBoundingClientRect();
		var x = evt.clientX - rect.left;
		var y = evt.clientY - rect.top;
		var xd, yd;
		var text = "";
		graph.title = "";

		for(var i = 0; i < tabBlocs.length; i ++) {
			
			xd = tabBlocs[i].X;
			yd = tabBlocs[i].Y;
			
			if ((x > xd) && (x < xd+tabBlocs[i].width) && (y > yd) && (y < yd+tabBlocs[i].height) ) {
				
				text = tabBlocs[i].nbPlaces*grossisement +" places tarif "+tabBlocs[i].tarif+" pour "+tabBlocs[i].height*grossisement +" euros";
				
				if(tabBlocs[i].tarif == "plein" || tabBlocs[i].tarif == "reduit"){
					graph.title = text+" de bénéfice";
				}else{
					graph.title = text+" de perte";
				}
				
				break;
			}else{
				graph.title="";
			}
		}
	}),
	false);