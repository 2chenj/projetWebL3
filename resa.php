<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>réservation</title>
    <link rel="stylesheet" href="style.css">

  </head>
  <body>
  	<div class="menu">
			<ul>
					<h3> le site</h3>
					<li> qui sommes nous ?</li>
					<li><a href="getSpectacles.php">jour par jour</a></li>
					<li> lieu par lieu</li>
					<li> spectacles </li>
					<li>tarifs</li>			
			</ul> 
			<ul>

					<li>le festival </li>
					<li> carte blanche </li>
					<li> l'association </li>
					<li> devinir membre </li>
					<li> faire un don</li>
					<li> nous contacter</li>
		  </ul>
  </div>  
  
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
	
			print('<div class="decalage">');
			print('<div class="Spectacle">');
			print("<h2>".$titre."</h2>");
			print("<p>la compagnie ".$compagnie." vous présente la pièce ".$titre." le ".$date." au village de ".$village." à ".$heure." dans le ".$lieu.".</p>");
			print('<figure id="spectacle">');
			print('<img  src="images/'.$affiche.'" width=100% height=100%></img>');

		}
	}

	print('<form action ="resa.php" method="GET">');
	print('<input type="submit" value="Réserver"/>');
	print('<input type="hidden" name="lineConfirmation" value="'.$nbSpectacle.'"/>');
	print('</form>');
	print("</div>");
	print("</div>");
	print("</figure>");
}else{
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
				    
				    if ($ligne[7]<=0){
				    	//si il n'y a plus de place on ne change pas la ligne
				    	print(" a échouée</p>");
		            	$newcontenu[$row] = $ligne;				    	
				    }else{
						// on baisse de 1 le nombre de places 'regular' -> colonne 7
					    $nouvelle_ligne[7] = ($ligne[7])-1;
		            	$newcontenu[$row] = $nouvelle_ligne;
		            	print("a bien été effectuée</p>");
		            }
		            print("<p>Il reste ".$nouvelle_ligne[7]." places pour cette scéance.</p>");
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
}
?>



  </body>
</html>
