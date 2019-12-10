function line(x1, y1, x2, y2){
	ctx.beginPath();
	ctx.moveTo(x1, y1);
	ctx.lineTo(x2, y2);
	ctx.stroke(); 
}

/* 	affiche un carré au dessus de la ligne 0 du du graph
	c-a-d un tarif plein ou un tarif réduit
	et mémorise ce carré dans les zones d'infobulle
	avec son nombre de places et le montant correspondant
*/
function printCarreHaut(posX, posY, width, height, color){
	var nbPlaces = 0;
	var tarif = "";
	if(color == "red"){
		tarif = "plein";
		nbPlaces = height /(15 * 0.1);
	}else{
		if(color == "green"){
			tarif = "reduit";	
			nbPlaces = height / (10*0.1);
		}else{
			console.log("erreur tarif printCarreHaut");
		}
	}
	var barre = {
		X : posX,
		Y : (height_canevas/2)-posY-height,
		width : width,
		height : height, 
		nbPlaces : nbPlaces,
		tarif : tarif
		};
	
	tabBlocs.push(barre); 
	ctx.beginPath();
	ctx.fillStyle = color;
	ctx.fillRect(posX, (height_canevas/2)-posY-height, width, height);
	

}

/* 	affiche un carré en dessous de la ligne 0 du du graph
	c-a-d un tarif SJ ou un tarif SA
	et mémorise ce carré dans les zones d'infobulle
	avec son nombre de places et le montant correspondant
*/
function printCarreBas(posX, posY, width, height, color){
	var nbPlaces = 0;
	var tarif = "";
	if(color == "blue"){
		tarif = "sj";
		nbPlaces = height /(10 * 0.9);
	}else{
		if(color == "yellow"){
			tarif = "sa";
			nbPlaces = height /(15 * 0.9);
		}else{
			console.log("erreur tarif printCarreHaut");
		}
	}

	var barre = {
		X : posX,
		Y : posY,
		width : width,
		height : height,
		nbPlaces : nbPlaces,
		tarif : tarif
		};
	
	tabBlocs.push(barre); 

	ctx.beginPath();
	ctx.fillStyle = color;
	ctx.fillRect(posX, posY, width, height);

	
}

/* affichage et stockage des zones d'un barre (représentation, lieu ou troupe)
 */
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

/* 	affiche toutes les barres à afficher (représentations, lieux ou troupes) et les noms correspondants 
	si ils sont donnés par le paramètre 'noms'
*/
function printPlusieuresBarres(width, data, decalageWidth, decalageHeight, noms){
	var cpt =0;
	ctx.font = '10px serif';
	
	// si le paramètre 'noms' est défini, on peut faire l'affichage des noms 
	var printNoms = (typeof(noms) != 'undefined');
	

	for (var barre in data) {
		console.log(data[barre]["plein"]);
		printBarre(
				decalageWidth,
				decalageHeight,
				width,
				data[barre]["plein"],
				data[barre]["reduit"],
				data[barre]["sj"],
				data[barre]["sa"],
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


/*	affiche les axes du graph (les lignes avec le montant en euros correspondant)
*/
function printAxe(decalageHeight,grossisement){
	ctx.font = '10px serif';
	var text = "";
	for(var i =0; i<height_canevas/2 ; i+=50){
		//graduations positives 
		
		text = (height_canevas/2) - i.toString();
		
		ctx.fillText( 	
						text*grossisement ,
						0,
						decalageHeight + i + 10
					);
		
		line(
				0,
				decalageHeight + i,  
				width_canevas,
				decalageHeight + i
			);
		
		//graduations négatives
		text = - i.toString();
		
		ctx.fillText(
						text*grossisement,
						0,
						height_canevas/2 + decalageHeight + i + 10
					);
		
		line(
				0,
				height_canevas/2 + decalageHeight + i,
				width_canevas,
				height_canevas/2 + decalageHeight + i
			);
		
	}
	ctx.font = '15px serif';
	ctx.fillText(
					"(En Euros)",
					0,
					decalageHeight - 10
				);
	
}

/*	affiche la légende (au dessus du graph) 
	pour la correspondance entre les couleurs et les tarifs
*/
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


