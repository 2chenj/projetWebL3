<?php include ("menu.html"); ?>

<div class="bandeau">
	<h1>Théâtres de Bourbon : Réservation </h1>
</div>

<main>
	<div class="decalage">
<?php
if (isset($_GET["line"])){
	$nbSpectacle=$_GET["line"];
	$spectacles = file('ResultatsFestival.csv');

	//On parcourt le tableau $spectacles
	foreach ($spectacles as $lineNumber => $lineContent){
		if ($lineNumber == $nbSpectacle){
	//		print($lineContent);
			$lineContentTab =explode(",",$lineContent);
			$date = $lineContentTab[0];
			$heure = $lineContentTab[1];
			$titre = $lineContentTab[2];
			$lieu = $lineContentTab[3];
			$village = $lineContentTab[4];
			$compagnie = $lineContentTab[5];
	
	//On va chercher l'image du spcectacle
	$affiches = file('affichesSpectacles.csv');
	foreach ($affiches as $lineNumberAffiche => $lineContentAffiche){
		if ($titre == explode(",",$lineContentAffiche)[0]){
			$affiche = explode(",",$lineContentAffiche)[1];
		}
	}		
	
			
			print('<div class="Spectacle">');
			print("<h2>".$titre."</h2>");
			print("<p>la compagnie ".$compagnie." vous présente la pièce ".$titre." le ".$date." au village de ".$village." à ".$heure." dans le ".$lieu.".</p>");
			print('<figure id="spectacle">');
			print('<img  src="images/'.$affiche.'" width=40% height=40%></img>');

		}
	}

	print('<form action ="panier.php" method="POST">');
	
//selection du nb de places
	print('<input type="number" name="tarifPlein" value="0" min="0">');
	print('<input type="number" name="tarifReduit" value="0" min="0">');
	print('<input type="number" name="tarifEnfant" value="0" min="0">');
	print('<input type="submit" value="Réserver"/>');
	print('<input type="hidden" name="lineReservation" value="'.$nbSpectacle.'"/>');
print('</form>');
	print("</div>");
	print("</figure>");
}else{
	/*
	//si la réservation est confirmée
	if(isset($_GET["lineConfirmation"])){
		$lineConfirmation = $_GET["lineConfirmation"];
	
	
		// Lecture du fichier CSV.
		if ($monfichier = fopen('ResultatsFestival.csv', 'r'))
		{
		    $row = 0; // Variable pour numéroter les lignes
		    $newcontenu = [];
		     
		    // Lecture du fichier ligne par ligne :
		    while (($ligne = fgetcsv($monfichier)) !== FALSE)
		    {
		        
		        // Si le numéro de la ligne est égal au numéro de la ligne à modifier :
		        if ($row == $lineConfirmation)
		        {
		        	$titre = $ligne[2];
					$lieu = $ligne[3];
					$date = $ligne[0];
		            // Variable contenant la nouvelle ligne :
				    $nouvelle_ligne = $ligne ;

				    print($ligne[7]);
				    print("<p>votre réservation pour ".$titre." le ".$date." à ".$lieu." ");
				    
				    $numCol = 0;
				    $strTarif="";
					if($_GET['tarifPlein']>0){
						//ajouter panier
					   	$numCol=6;
					   	$strTarif="plein";
					   }else{
					   	if($_GET['tarifReduit'] > 0){
					   		//ajouter panier
							$numCol=7;
					   		$strTarif="réduit";
					   	}else{
					   		if($_GET['tarif']== "tarifEnfant"){
					   			//ajouter panier
								$numCol=11;
					   			$strTarif="enfant";
					   		}
					   	}
					}

				    if ($ligne[$numCol]<=0){
				    	//si il n'y a plus de place on ne change pas la ligne
				    	print(" a échouée</p>");
		            	$newcontenu[$row] = $ligne;				    	
				    }else{
						// on baisse de 1 le nombre de places pour le tarif choisi -> $numCol
	      		        $nouvelle_ligne[$numCol] = ($ligne[$numCol])-1;
		            	$newcontenu[$row] = $nouvelle_ligne;
		            	print("a bien été effectuée</p>");
		            }
		            print("<p>Il reste ".$nouvelle_ligne[$numCol]." places pour cette scéance en tarif ".$strTarif."</p>");
		        }
		        // Sinon, on réécri la ligne
		        else
		        {
		            $newcontenu[$row] = $ligne;
		        }
		        $row++;    
		    }
    		fclose($monfichier);
    		$fichierecriture = fopen('ResultatsFestival.csv', 'w');
	    	foreach($newcontenu as $nbLine => $lineContent){
//	    		fputcsv($fichierecriture, $lineContent,chr(0));
	    		 
				fputs($fichierecriture, implode($lineContent, ',')."\n");
				
    		}
    		
    		fclose($fichierecriture);
		}
	}
	*/
}
?>


	</div>
	</main>
  </body>
</html>

