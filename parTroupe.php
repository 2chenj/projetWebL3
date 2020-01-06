<?php include ("menu.html"); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script  src="testTemps.js"></script>
<div class="bandeau">
  <h1>Théâtres de Bourbon : Troupe par troupe </h1>
</div>

<main>
  <div class="decalage">

<?php
	//on parcours le csv ResultatsFestival
  	if( ($handle = fopen("csv/ResultatsFestival.csv","r")) !== FALSE )
  	{
		fgetcsv($handle,1000);//On retire la 1ere ligne du csv (legendes)
		$cptLine = 1;
		//hashmap string -> array of string
		$sousTableau = [];
		while ( ($fields = fgetcsv($handle,1000)) !== FALSE )
		{
			//on ajoute le numéro de ligne à la fin de la ligne
			$fields[12] = $cptLine;
			$cptLine++;

			//former if places

		  	//putt the whole line deragmented into the hasmap city -> lines, delim = ","
			//on ajoute la ligne $fields dans $sousTableau à l'index qui est le nom de la troupe de $fields
		  	$sousTableau[$fields[5]] [] = $fields;
		  	
			//former fields
		}//end of while fgetcsv

		//trie tableau ordre alphabétique
		ksort($sousTableau);
		//show hashmap
		$firstTroupe = true;
		foreach ($sousTableau as $compagnie => $lines) {
			
			/*si on est surla premiere ligne du dessus on écrit dans un nouveau bloc de classe 'Spectacle' qu'on ne ferme pas
			et sinon on ferme un bloc avant de créer le nouveau qu'on ne ferme pas*/
			if($firstTroupe){
				print("<div class='Spectacle'><h2>".$compagnie."</h2>\n");
				$firstTroupe = false;
			}else{
				print("</div><div class='Spectacle'><h2>".$compagnie."</h2>\n");
			}
			
			foreach ($lines as $fields)
			{
				// on récupère les données de la ligne
				$jour = $fields[0];
				$horaire = $fields[1];
				$titre = $fields[2];
				$ville = $fields[3];
				$village = $fields[4];
				$cptLine = $fields[12];
				
				//affichage représentation avec bouton réserver
				print("</br><div id=".$cptLine."><table> <jour> ". $jour. "</jour>, <horaire>". $horaire . "</horaire> , <lieu> au " . $ville . " à " . $village . "</lieu>, <titrespectacle>". $titre ." </titrespectacle> ");
				print('<form action ="resa.php" method="GET"><input type="submit" value="Réserver"/><input type="hidden" name="line" value="'.$cptLine.'"/></form></table></div>');
				$cptLine++;
			}//end of foreach $city

		}//end of foreach $sousTableau
		print("</div>");

  	}else{
		echo "le fchier n'a pas pu être ouvert par fopen";
  	}//fin if fopen
?>

</div>
</main>
</body>
</html>
