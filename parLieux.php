<?php include ("menu.html"); ?>

<div class="bandeau">
	<h1>Théâtres de Bourbon : Lieu par lieu </h1>
</div>

<main>
	<div class="decalage">

		<?php
			if( ($handle = fopen("ResultatsFestival.csv","r")) !== FALSE )
			{
				fgetcsv($handle,1000,",");
				$place ="null";
				$cptLine = 1;
			//hashmap string -> array of string
				$sousTableau = [];
				while ( ($allDate = fgetcsv($handle,1000,"\n")) !== FALSE ) 
				{

					foreach ($allDate as $lines) 
					{
						$replaced = preg_replace_callback(
							'/"(\\\\[\\\\"]|[^\\\\"])*"/',
							function($match){
								$tempo = preg_replace("[,]",'&#44;',$match);
								implode($tempo);
								return $tempo[0];
							} ,
							$lines
						);

						$fields = preg_split("[,]",$replaced);
						$fields[12] = $cptLine;
						$cptLine++;

						//putt the whole line deragmented into the hasmap city -> lines, delim = ","

						$sousTableau[$fields[3]] [] = $fields;
						//array_push($sousTableau[$fields[3]],$fields);
						//former fields
					}
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

							if (($handle = fopen("imagesLieux.csv", "r")) !== FALSE) 
							{
								while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) 
								{


									if ($city == $data[0])
									{
									 $imgLieu = $data[1];
									 $txtLieu = $data[2];
											// affichage de l'image
									 print("<div>");
									 print('<figure class = "lieu"><img  src="images/lieux/'.$imgLieu.'" width=100% height=100%></img></figure>'); 

									 print("<p>".$txtLieu."</p>"); 
											//on ajoute une div avec "clear : both" pour que la taille du bloc .Lieu s'adapte à celle de l'image 
									 print("<style>.Lieu div {clear : both;}</style>");
									 print("<div></div>");

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
					 	print("</br><div> <jour> ". $jour. "</jour>, <titrespectacle>". $titre ."</titrespectacle>, par <troupe>" . $compagnie . "</troupe>, <horaire>". $horaire . "</horaire>");
					 	print('<form action ="resa.php" method="GET"><input type="submit" value="Réserver"/><input type="hidden" name="line" value="'.$cptLine.'"/></form></div>');    
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
