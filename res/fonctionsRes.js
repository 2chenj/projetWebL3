function line(x1, y1, x2, y2){
	ctx.beginPath();
	ctx.moveTo(x1, y1);
	ctx.lineTo(x2, y2);
	ctx.stroke(); 
}

function printCarreHaut(posX, posY, width, heigth, color){
	ctx.beginPath();
	ctx.fillStyle = color;
	ctx.fillRect(posX, (height_canevas/2)-posY-heigth, width, heigth);
	
	var tarif = "";
	if(color == "red"){
		tarif = "plein"
	}else{
		if(color == "green"){
			tarif = "reduit"	
		}else{
			console.log("erreur tarif printCarreHaut");
		}
	}
	var barre = {
		X : posX,
		Y : (height_canevas/2)-posY-heigth,
		width : width,
		heigth : heigth,
		tarif : tarif
		};
	
	tabBlocs.push(barre); 
}

function printCarreBas(posX, posY, width, heigth, color){
	ctx.beginPath();
	ctx.fillStyle = color;
	ctx.fillRect(posX, posY, width, heigth);

	var tarif = "";
	if(color == "blue"){
		tarif = "sj"
	}else{
		if(color == "yellow"){
			tarif = "sa"	
		}else{
			console.log("erreur tarif printCarreHaut");
		}
	}

	var barre = {
		X : posX,
		Y : posY,
		width : width,
		heigth : heigth,
		tarif : tarif
		};
	
	tabBlocs.push(barre); 
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

function printPlusieuresBarres(width, data, decalageWidth, decalageHeight,noms){
	var cpt =0;
	ctx.font = '15px serif';
	
	// si le paramètre 'noms' est défini, on peut faire l'affichage des noms 
	var printNoms = (typeof(noms) != 'undefined');
		
	console.log(data);
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
			if(printNoms){
				// affichage noms
				ctx.fillStyle = "black";
				ctx.fillText(
					noms[cpt],
					decalageWidth,
					height_canevas-10
				);
				cpt++;
			}
		
		decalageWidth=decalageWidth+width_barre+espace_barres;
	}
	console.log(tabBlocs);
}

function printAxe(decalageWidth, decalageHeight,grossisement){
	ctx.font = '10px serif';
	var text = "";
	for(var i =0; i<height_canevas/2 ; i+=50){
		//graduations positives 
		
		text = (height_canevas/2) - i.toString();
		
		ctx.fillText( 	
						text*grossisement ,
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
						text*grossisement,
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
	ctx.font = '15px serif';
	ctx.fillText(
					"(En Euros)",
					decalageWidth,
					decalageHeight - 10
				);
	
}

function printLegendes(){
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


