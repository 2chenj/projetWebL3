const width_canevas = 1700;
const height_canevas = 1200;
const nb_barre = 2;
const width_barre = 25;				
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
		graph.title = "";
		//console.log("test : x="+x+"  y="+y);
		//console.log("blocX : "+tabBlocs[0].X +" blocY : "+tabBlocs[0].Y);
		for(var i = 0; i < tabBlocs.length; i ++) {
			
			xd = tabBlocs[i].X;
			yd = tabBlocs[i].Y;
			
			if ((x > xd) && (x < xd+tabBlocs[i].width) && (y > yd) && (y < yd+tabBlocs[i].heigth) ) {
				graph.title = tabBlocs[i].heigth*grossisement +" euros de places tarif "+tabBlocs[i].tarif;
				break;
			}
		}
	}),
	false);