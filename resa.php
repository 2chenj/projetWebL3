<?php include ("menu.html"); ?>

<div class="bandeau">
	<h1>Théâtres de Bourbon : Réservation </h1>
</div>

<main>
	<div class="decalage">

	<?php
	
	if (isset($_GET["line"])){
		$nbSpectacle=$_GET["line"];
		$row = 1;
		if ($handle = fopen('csv/ResultatsFestival.csv', 'r'))
		{
	
			fgetcsv($handle, 1000, ","); //On ignore la 1ere ligne du csv (legendes)

			//On parcourt le tableau $spectacles
			while (($fields = fgetcsv($handle,1000,",")) !== FALSE)
			{
				if ($row == $nbSpectacle)
				{
					
					$date      = $fields[0];
					$heure     = $fields[1];
					$titre     = $fields[2];
					$lieu      = $fields[3];
					$village   = $fields[4];
					$compagnie = $fields[5];
			
					//On va chercher l'image du spcectacle
					if ($handle = fopen('csv/affichesSpectacles.csv', 'r')){
						while (($fields = fgetcsv($handle, 1000)) !== FALSE){
							if($fields[0] == $titre){
								$affiche = $fields[1];
							}
						}
					}		
			
					print('<div class="Spectacle">');
					print("<h2>".$titre."</h2>");
					print("<p>la compagnie ".$compagnie." vous présente la pièce ".$titre." le ".$date." au village de ".$village." à ".$heure." dans le ".$lieu.".</p>");
					print('<figure id="spectacle">');
					print('<img  src="images/spectacles/'.$affiche.'" width=40% height=40%></img>');
					
				}
				$row++;
			}
		}
	
		print('<form action ="panier.php" method="POST">');
		
		//selection du nb de places
		print('
				<table>
					<tr>
						<td>tarif plein</td>
						<td>tarif réduit</td>
						<td>tarif enfant</td>
	
					</tr>
					<tr>
						<td><input type="number" name="tarifPlein" value="0" min="0"></td>
						<td><input type="number" name="tarifReduit" value="0" min="0"></td>
						<td><input type="number" name="tarifEnfant" value="0" min="0"></td>
						<td><input type="submit" value="Réserver"/></td>
						<input type="hidden" name="lineReservation" value="'.$nbSpectacle.'"/>
					</tr>
				</table>
		</form>
		</div>
		</figure>
		');
	}
	?>


	</div>
</main>
</body>
</html>

