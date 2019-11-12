<?php include ("menu.html"); ?>

<div class="bandeau">
	<h1>Théâtres de Bourbon : Jour par jour </h1>
</div>

<main>
	<div class="decalage">
		<?php

		if (($handle = fopen("ResultatsFestival.csv", "r")) !== FALSE) {
				fgetcsv($handle, 1000, ",");//On retire la 1ere ligne du csv (legendes)
				$jour = "null";
				$cptLine = 1;
				while (($data = fgetcsv($handle, 1000, "\n")) !== FALSE) {
						
				foreach($data as $value) {
					$replaced = preg_replace_callback(
						'/"(\\\\[\\\\"]|[^\\\\"])*"/',
						function ($match){
							$temp = preg_replace("[,]", '&#44;', $match);
							implode($temp);
							return $temp[0];
						},
						$value
					);
					
					$fields = preg_split("[,]", $replaced);
					if($jour != $fields[0]){
						$jour = $fields[0];
						if($cptLine == 1){
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
			
			
					print("<div><horaire>". $horaire . "</horaire> , <lieu> au " . $lieu . " à " . $village . "</lieu>, <titrespectacle>". $titre ."</titrespectacle>, par <troupe>" . $compagnie . "</troupe>\n");
					print('<form action ="resa.php" method="GET"><input type="submit" value="Réserver"/><input type="hidden" name="line" value="'.$cptLine.'"/></form></div></br>');
					$cptLine++;
				}
			}
		}
		print("</div>");
		


?>
	</div>
</main>
</body>
</html>
