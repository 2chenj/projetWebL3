const width_canevas = 1700;
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
   	ctx.fillStyle = color;
   	ctx.fillRect(posX, (height_canevas/2)-posY-heigth, width, heigth);

}

function printCarreBas(posX, posY, width, heigth, color){
	var c = document.getElementById("dessin");
    var ctx = c.getContext("2d");
	ctx.beginPath();
	ctx.fillStyle = color;
   	ctx.fillRect(posX, posY, width, heigth);

}

function printBarre(decalageWidth, decalageHeight, width, plein, reduit, sj, sa){
	var acc = -decalageHeight;
	printCarreHaut(
					decalageWidth,
					acc,
					width,
					plein,
					"red"
				  );

	acc += plein;
	printCarreHaut(
					decalageWidth,
					acc,
					width,
					reduit ,
					"green"
				  );

	acc = (height_canevas/2) + decalageHeight;
	printCarreBas(
					decalageWidth,
					acc,
					width,
					sj ,
					"blue"
				  );

	acc += sj;
	printCarreBas(
					decalageWidth,
					acc,
					width,
					sa ,
					"yellow"
				  );

}

function printPlusieuresBarres(width, data, decalageWidth, decalageHeight){
	for (var barre in data) {
			printBarre(
				decalageWidth,
				decalageHeight,
				width,
				data[barre]["plein"],
				data[barre]["reduit"],
				data[barre]["sj"],
				data[barre]["sa"]
			);
		decalageWidth=decalageWidth+width_barre+8;
	}
}

function printAxe(decalageWidth, decalageHeight){
	var c = document.getElementById("dessin");
    var ctx = c.getContext("2d");
    ctx.font = '10px serif';
    var text = "";
	for(var i =0; i<height_canevas/2 ; i+=50){
		//graduations positives 
		
		text = (height_canevas/2) - i.toString();
		
		ctx.fillText( 	
						text/2 ,
						decalageWidth,
						decalageHeight + i + 10
					);
		
		line(
				decalageWidth,
				decalageHeight + i,  
				width_canevas,
				decalageHeight + i
			);
		
		//graduations négatives
		text = - i.toString();
		
		ctx.fillText(
						text/2,
						decalageWidth,
						height_canevas/2 + decalageHeight + i + 10
					);
		
		line(
				decalageWidth,
				height_canevas/2 + decalageHeight + i,
				width_canevas,
				height_canevas/2 + decalageHeight + i
			);
	}
}

function printLegendes(){
	var c = document.getElementById("dessin");
    var ctx = c.getContext("2d");
    ctx.font = '20px serif';
    
    var colors = ["red","green","blue","yellow"];
    var texts = ["plein","réduit","SJ","SA"]; 
	var posX = 200;
    
    for(var i = 0; i<4; i++){
    	
    	posX += 250;
    	ctx.fillStyle = colors[i];	
    	ctx.fillRect(posX,0,20,20);
    	ctx.fillStyle = "black";
    	ctx.fillText(" : tarif ".concat(texts[i]), posX + 20, 15);		

    }

}


$.ajax({
	type:'post',
	url:"getDessin.php",
	success:function(data){
	        console.log(data)
	        var decalageWidth = 200;
	        var decalageHeight = 50;

	        printLegendes();
	        printAxe(decalageWidth-20, decalageHeight);
			//line(decalageWidth-20,(height_canevas/2),width_canevas,(height_canevas/2));	        
			printPlusieuresBarres(width_barre, data, decalageWidth, decalageHeight);	                
	            
	}
})
