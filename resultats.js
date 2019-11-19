const width_canevas = 1000;
const height_canevas = 1000;
const nb_barre = 2;
const width_barre = 20;				

function line(x1, y1, x2, y2){
	var c = document.getElementById("dessin");
	var ctx = c.getContext("2d");
	ctx.beginPath();
	ctx.moveTo(x1, y1);
	ctx.lineTo(x2, y2);
	ctx.stroke(); 
}

function printCarreHaut(posX, posY, width, heigth, color){
	var c = document.getElementById("dessin");
    var ctx = c.getContext("2d");
	ctx.beginPath();
   	ctx.rect(posX, (height_canevas/2)-posY-heigth, width, heigth);
   	ctx.stroke();
	ctx.fillStyle = color;
	ctx.fill();

}

function printCarreBas(posX, posY, width, heigth, color){
	var c = document.getElementById("dessin");
    var ctx = c.getContext("2d");
	ctx.beginPath();
   	ctx.rect(posX, posY, width, heigth);
   	ctx.stroke();
	ctx.fillStyle = color;
	ctx.fill();

}

function printBarre(decalage,width, plein, reduit, sj, sa){
	var acc = 0;
	printCarreHaut(decalage,0,width,plein,"red");
	acc += plein;
	printCarreHaut(decalage,acc,width,reduit, "green");
	acc = (height_canevas/2);
	printCarreBas(decalage,acc,width,sj, "blue");
	acc += sj;
	printCarreBas(decalage,acc,width,sa, "yellow");
}

function printPlusieuresBarres(width, data){
	var decalage = 0;
	for (var barre in data) {
		        printBarre(
	                decalage,
	                width,
			        data[barre]["plein"]*4,
			        data[barre]["reduit"]*4,
			        data[barre]["sj"]*4,
	         		data[barre]["sa"]*4
	         	);
		decalage=decalage+width_barre+8;
	}
}

$.ajax({
	type:'post',
	url:"getDessin.php",
	success:function(data){
	        console.log(data)
	        
			
			
			line(0,(height_canevas/2),height_canevas,(height_canevas/2));	        
			printPlusieuresBarres(width_barre,data);	                
	            
	}
})
