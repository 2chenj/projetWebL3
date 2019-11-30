<?php include ("menu.html"); ?>

<div class="bandeau">
	<h1>Théâtres de Bourbon : Jour par jour </h1>
</div>

<main>
	<div class="decalage">
		<?php

		if (($handle = fopen("ResultatsFestival.csv", "r")) !== FALSE)
		{
			fgetcsv($handle, 1000);//On retire la 1ere ligne du csv (legendes)
			$jour = "null";
			$cptLine = 1;
			while (($fields = fgetcsv($handle, 1000)) !== FALSE)
			{
				if($jour != $fields[0])
				{
					$jour = $fields[0];
					if($cptLine == 1)
					{
						print("<div class='Spectacle'><h2> " . $jour . "</h2>\n");
					}else{
						print("</div><div class='Spectacle'><h2> " . $jour . "</h2>\n");
					}
				}
				$horaire = $fields[1];
				$titre = $fields[2];
				$lieu = $fields[3];
				$village = $fields[4];
				$compagnie = $fields[5];


				print('
					</br>
					<div id ='.$cptLine.'>
						<table>
							<horaire>'. $horaire .'</horaire>
							<lieu> au '. $lieu .' à '. $village .'</lieu>,
							<titrespectacle>'. $titre .'</titrespectacle>, par 
							<troupe>' . $compagnie . ' </troupe> 
						
							<form action ="resa.php" method="GET">
								<input type="submit" value="Réserver"/>
								<input type="hidden" name="line" value="'.$cptLine.'"/>
							</form>
						</table>
					</div>
				');
				$cptLine++;
			}
		}
		print("</div>");

		?>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script>
			function timeToInt(time){
				var tab = time.split("h");
				var res = (parseInt(tab[0])*60) + parseInt(tab[1]);
				return res;
			}
			//on récupère le cookie panier
			var panier = eval(decodeURIComponent(document.cookie));
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
							
							var jour1 = data['jour'];
							var heure1 = timeToInt(data['heure']);
							var ville1 = data['ville'];
	      					console.log("ville 1 = "+ville1);
							console.log("heure1 = "+heure1);
							for(var i=1; i<44;i++)
							{
								(function (i){
									$.ajax({
										type:"GET",
										url:"getVille.php",
										data: "ligne="+i, 
										success:function(data2){
											var jour2 = data2['jour'];
											var heure2 = timeToInt(data2['heure']);
											var ville2 = data2['ville'];
											
											if(jour1==jour2){
												
												$.ajax({
													type:"POST",
													url:"DEV.php",
													data: "ville1="+ville1+"&ville2="+ville2+"&horaire="+heure1, 
													success:function(data3){
														//document.getElementById(i).innerHTML = data;
														console.log(i+": d = "+data3['d']+" t = "+data3['t']+" heure2 = "+heure2);
														//comparer les horaires 
														
														var diffTemps = 0;

														if(heure2 > heure1){
															var fin1 = heure1 + 120; //on rajoute deux heures à la pièce pour avoir son heure de fin
															diffTemps = heure2 - fin1;
															console.log("diffTemps = "+diffTemps);
															if(diffTemps > 0){
																if(data3['t'] >= diffTemps){
																	console.log("OK POUR : "+i);
																}
															}else{
																console.log("PAS LE TEMPS POUR : "+i);
															}

														}else{
															var fin2 = heure2 + 120;
															diffTemps = fin2 - heure1;
															console.log("diffTemps = "+diffTemps);
															if(diffTemps > 0){
																console.log("JE SAIT PAS POUR : "+i);
															}else{
																console.log("PAS LE TEMPS POUR : "+i);
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
			//on récupère le lieu et l'horaire de chaque pièce 
			
				/*
				
				*/
		</script>

		</div>
	</main>
</body>
</html>
