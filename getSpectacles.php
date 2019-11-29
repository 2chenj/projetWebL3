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
							console.log("ville = "+data);
	      				}
					})
				
			}
			//on récupère le lieu et l'horaire de chaque pièce 
			for(var i=1; i<44;i++){
				var ville = document.getElementById(i).getElementsByTagName("lieu").item(0).textContent.split("à ")[1];
				
				var horaire = document.getElementById(i).getElementsByTagName("horaire").item(0).textContent;
				
			}
				/*
				$.ajax({
					type:"POST",
					url:"DEV.php",
					data: "ville1="+ +"&ville2="++"&horaire="+, 
					success:function(data){
						document.getElementById(i).innerHTML = data;
	      			}
				})
				*/
		</script>

		</div>
	</main>
</body>
</html>
