<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Theatres de Bourbon</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
  </head>
  <body>

<!-- ce qei ressemble à l'entête plus le petit panier à droite-->

<div class="bandeau">
	<div class="petitPanier">
		<table>
			Billets en vente exclusivement sur les lieux du festival: Monétay, Monteignet, Veauce  du 2 au 6 août dès 11h00 et le 6 août à Moulins de 19h00 à 20h00.
									Attention! à Moulins le début du spectacle à 20h00.
	</table>
	</div>
										<h1> Festival Théâtres de Bourbon </h1>
</div>

<!-- le menu à gauche -->
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
<!-- fin index.html-->

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
						echo "<h2> " . $jour . "</h2>\n";
					}
			
					$horaire = $fields[1];
					$titre = $fields[2];
					$lieu = $fields[3];
					$village = $fields[4];
					$compagnie = $fields[5];
			
			
					print("<p><horaire>". $horaire . "</horaire> , <lieu> au " . $lieu . " à " . $village . "</lieu>, <titrespectacle>". $titre ."</titrespectacle>, par <troupe>" . $compagnie . "</troupe>\n");
					print('<form action ="resa.php" method="GET"><input type="submit" value="Réserver"/><input type="hidden" name="line" value="'.$cptLine.'"/></form></p>');
					$cptLine++;
				}
			}
		}			


?>
	</div>
</main>
</body>
</html>
