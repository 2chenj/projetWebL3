<?php include ("menu.html"); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script  src="testTemps.js"></script>
<div class="bandeau">
	<h1>Théâtres de Bourbon : Lieu par lieu </h1>
</div>

<main>
	<div class="decalage">

		<?php
		if( ($handle = fopen("ResultatsFestival.csv","r")) !== FALSE )
		{
			fgetcsv($handle,1000);
			$place ="null";
			$cptLine = 1;
			//hashmap string -> array of string
			$sousTableau = [];
			while ( ($fields = fgetcsv($handle,1000)) !== FALSE ) 
			{
				$fields[12] = $cptLine;
				$cptLine++;

						//putt the whole line deragmented into the hasmap city -> lines, delim = ","

				$sousTableau[$fields[3]] [] = $fields;
						//array_push($sousTableau[$fields[3]],$fields);
						//former fields

			}//end of while fgetcsv

			ksort($sousTableau);
				//show hashmap
			$firstCity = true;

			foreach ($sousTableau as $city => $lines) 
			{
				$firstRepresentation = true;
				foreach ($lines as $fields)
				{
					$village = $fields[4];
					if($place != $fields[3])
					{
						$place = $fields[3];
						if($firstCity)
						{
							print("<div class='Lieu'><h2>".$city." à ".$village."</h2>\n");
							$firstCity = false;
						}else{
							print("</div><div class='Lieu'><h2>".$city." à ".$village."</h2>\n");
						}
						//On va chercher l'image du lieu

						if (($handle = fopen("csv/imagesLieux.csv", "r")) !== FALSE) 
						{
							while (($fieldsDescription = fgetcsv($handle, 1000)) !== FALSE) 
							{


								if ($city == $fieldsDescription[0])
								{
									$imgLieu = $fieldsDescription[1];
									$txtLieu = $fieldsDescription[2];
											// affichage de l'image
									print("<div id=".$fields[12].">");
									print('<figure class = "lieu"><img  src="images/lieux/'.$imgLieu.'" width=100% height=100%></img></figure>'); 

									print("<p>".$txtLieu."</p>"); 
											//on ajoute une div avec "clear : both" pour que la taille du bloc .Lieu s'adapte à celle de l'image 
									print("<div style=clear : both;></div>");

									print("</div>");
								}
							}
						}
					}

					 	// on récupère les données de la ligne
					$jour = $fields[0];
					$horaire = $fields[1];
					$titre = $fields[2];
					$compagnie = $fields[5];
					$cptLine = $fields[12];
					if($firstRepresentation){
						print("<h2>Programme :</h2>");
						$firstRepresentation = false;
					}
					print("</br><table> <jour> ". $jour. "</jour>, <titrespectacle>". $titre ."</titrespectacle>, par <troupe>" . $compagnie . "</troupe>, <horaire>". $horaire . " </horaire>");
					print('<form action ="resa.php" method="GET"><input type="submit" value="Réserver"/><input type="hidden" name="line" value="'.$cptLine.'"/></form></table>');    
				}//end of foreach $city
			}//end of foreach $sousTableau
			print("</div>");
		}else{
			echo "le fchier n'a pas pu être ouvert par fopen";
		}
		?>
	</div>
</main>

</body>
</html>
