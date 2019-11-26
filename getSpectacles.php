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


				print("</br><table><horaire>". $horaire . "</horaire>  <lieu> au " . $lieu . " à " . $village . "</lieu>, <titrespectacle>". $titre ."</titrespectacle>, par <troupe>" . $compagnie . " </troupe> ");
				print('<form action ="resa.php" method="GET"><input type="submit" value="Réserver"/><input type="hidden" name="line" value="'.$cptLine.'"/></form></table>');
				$cptLine++;
			}
		}
		print("</div>");



			?>
		</div>
	</main>
</body>
</html>
