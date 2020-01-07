var nbRepresentations = 44;
//donne un entier à partir d'une heure sous la forme xhy où x est le nb d'heures et y le nomre de minutes
function timeToInt(time){
	var tab = time.split("h");
	var res = (parseInt(tab[0])*60) + parseInt(tab[1]);
	return res;
}

//donne une heure sous la forme xhy à partir d'un entier
function intToTime(nb){
	var nbHeures = parseInt(nb/60);
	var nbMin = nb-(nbHeures*60);
	if(nbMin<10){
		nbMin = nbMin+"0";
	}
	return nbHeures+"h"+nbMin;
}

//vérifie si un entier est dans un tableau
function estDans(nb, tab){
	for (var i=0; i<tab.length; i++){
		if(tab[i] == nb){
			return true;
		}
	}
	return false;
}

//on récupère le cookie panier
var panier = eval(decodeURIComponent(document.cookie));

// on remplit tabLignes avec les num de ligne des pieces réservées
var i = 0;
var tabLignes= [];
for (var article in panier){
	tabLignes[i] = panier[article]["lineReservation"]; 
	i++;
}

//pour chaque article
for(var article in panier){
		console.log(panier[article]);
		//on récupère la ligne dans le csv de cet article
		var ligne = panier[article]["lineReservation"];
		console.log("ligne  => "+ligne);
		//parcourir le csv pour trouver la ville (doit être exécuté côté serveur, donc il faut appeler un script php)
		//le script php doit prendre en argument 'ligne' et renvoyer le nom de ville correspondant
		$.ajax({
			type:"GET",
			url:"getVille.php",
			data: "ligne="+ligne, 
			success:function(data){
				//on récupère les données sur la ville et la date de la représentation qui est dans le panier				
				var jour1 = data['jour'];
				var heure1 = timeToInt(data['heure']);
				var ville1 = data['ville'];
				var length = data['length'];
				console.log("ville 1 = "+ville1);
				console.log("heure1 = "+heure1);
				console.log("length = "+length);
				
				for(var i=1; i<length;i++)
				{
					//pour chaque représentation
					(function (i){
						$.ajax({
							type:"GET",
							url:"getVille.php",
							data: "ligne="+i, 
							success:function(data2){
								//on récupère les données sur la ville et la date de la représentation				
								var jour2 = data2['jour'];
								var heure2 = timeToInt(data2['heure']);
								var ville2 = data2['ville'];
								
								
								if(jour1==jour2 && i!=ligne && !estDans(i,tabLignes)){
									//si cette représentation à lieu le même jour que celle de l'article qu'on parcours et n'est pas dans le panier
									//on utilise le script DEV.php pour calculer la distance et le temps entre les 2 représentations
									
									$.ajax({
										type:"POST",
										url:"DEV.php",
										data: "ville1="+ville1+"&ville2="+ville2+"&horaire="+heure1, 
										success:function(data3){
											var elt = document.getElementById(i);
											//comparer les horaires 
											
											var diffTemps = 0;
											if(heure2 >= heure1){
												//si la représentation 2 est après la 1 
												var fin1 = heure1 + 120; //on rajoute deux heures à la pièce pour avoir son heure de fin
												diffTemps = heure2 - fin1;
												
												if((diffTemps <= 0) && (data3['t'] > diffTemps)){
													
													/*si la différence de temps est <= 0 et que le temps pour aller d'une pièce à l'autre est > à la différence de temps entre ces deux représentations,
													 on affiche la ligne en question avec un fond rouge et on lui rajoute une explication en 'title' qui sera le texte de l'infobulle au survol de la souris*/
													elt.style.backgroundColor = "red";
													elt.rel = "tooltip";
													elt.title = "Attention, vous avez une resprésentation réservée pour le même jour à "+intToTime(heure1)+" qui finit à "+intToTime(fin1)+ 
																" et il y a "+intToTime(data3['t'])+" min de trajet entre les deux salles vous n'aurez donc pas le temps d'assister aux 2 resprésentations";
												}
											}else{
												//si la représentation 1 est après la 2 
												var fin2 = heure2 + 120; //on rajoute deux heures à la pièce pour avoir son heure de fin
												diffTemps = fin2 - heure1;
												
												if( !((diffTemps <= 0) && data3['t'] > diffTemps)){
													/*si la différence de temps est <= 0 et que le temps pour aller d'une pièce à l'autre est > à la différence de temps entre ces deux représentations,
													 on affiche la ligne en question avec un fond rouge et on lui rajoute une explication en 'title' qui sera le texte de l'infobulle au survol de la souris*/
													elt.style.backgroundColor = "red";
													elt.rel = "tooltip";
													elt.title = "Attention, vous avez une resprésentation réservée pour le même jour à "+intToTime(heure2)+" qui finit à "+intToTime(fin2)+ 
																" et il y a "+intToTime(data3['t'])+" min de trajet entre les deux salles vous n'aurez donc pas le temps d'assister aux 2 resprésentations";
												}
											}
										}
									})
								}
							}
						})
					})(i);
				}	
			}
		})
}