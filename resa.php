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
			print('<img  src="images/spectacles/'.$affiche.'" width=40% height=40%></img>');

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
}
?>


	</div>
	</main>
  </body>
</html>

