const width_canevas = 3500;
const height_canevas = 1000;
const nb_barre = 2;
const width_barre = 25;				

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
   	
	ctx.fillStyle = color;
	ctx.fill();

}

function printCarreBas(posX, posY, width, heigth, color){
	var c = document.getElementById("dessin");
    var ctx = c.getContext("2d");
	ctx.beginPath();
	ctx.fillStyle = color;
   	ctx.fillRect(posX, posY, width, heigth);

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

function printPlusieuresBarres(width, data, decalage){
	for (var barre in data) {
		        printBarre(
	                decalage,
	                width,
			        data[barre]["plein"],
			        data[barre]["reduit"],
			        data[barre]["sj"],
	         		data[barre]["sa"]
	         	);
		decalage=decalage+width_barre+8;
	}
}

function printAxe(decalage){
	var c = document.getElementById("dessin");
    var ctx = c.getContext("2d");
    ctx.font = '10px serif';
	for(var i =0; i<height_canevas/2; i+=50){
		//graduations positives 
		ctx.fillText((height_canevas/2) - i.toString()/2,decalage,i+10);
		line(decalage,i,width_canevas,i);
		//graduations négatives
		ctx.fillText(- i.toString()/2,decalage,height_canevas/2+ i+10);
		line(decalage,height_canevas/2+i,width_canevas,height_canevas/2+i);
	}
}



$.ajax({
	type:'post',
	url:"getDessin.php",
	success:function(data){
	        console.log(data)
	        var decalage = 200;
	        printAxe(decalage-20);
			line(decalage-20,(height_canevas/2),width_canevas,(height_canevas/2));	        
			printPlusieuresBarres(width_barre,data,decalage);	                
	            
	}
})
