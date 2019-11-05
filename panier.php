<?php include ("menu.html"); ?>

<div class="bandeau">
	<h1>Théâtres de Bourbon : Panier </h1>
</div>

<main>
	<div class="decalage">
<?php
	if(isset($_POST['lineReservation'])){ // je verifie que le formulaire a bien été posté
		$articleDejaExistant = 0;
		$article_added = $_POST; // j'enregistre les valeurs envoyées dans post (inutile, mais je le fais...)

		if(isset($_COOKIE['panier']) AND !empty($_COOKIE['panier'])) {   // je vérifie que le cookie existe
			$cart = unserialize($_COOKIE['panier']);  // je recupère les possibles articles déjà dans le panier
	                foreach ($cart as $id => $value){
						if($value['lineReservation'] == $article_added['lineReservation']){
                	                $cart[$id]['tarifPlein'] += $article_added['tarifPlein'];
                        	        $cart[$id]['tarifReduit'] += $article_added['tarifReduit'];
                                	$cart[$id]['tarifEnfant'] += $article_added['tarifEnfant'];

	                                $articleDejaExistant = 1;
        	                }
	                }
		}

		if($articleDejaExistant == 0){
			$cart[] = array(   // j'ajoute dans le tableau cart l'article, avec les informations qui sont dans article
				'lineReservation' 	=> $article_added['lineReservation'],
				'tarifPlein'		=> $article_added['tarifPlein'],
				'tarifReduit'           => $article_added['tarifReduit'],
				'tarifEnfant'		=> $article_added['tarifEnfant']
				);
		}
			setcookie('panier', serialize($cart), (time() + 2592000)); // je remplace/ajoute un nouveaux cookie, avec les informations du panier; je garde le cookie pour 2592000 (~1 mois)
			header("Location:panier.php"); //on recharge la page pour afficher le panier
			if(isset($_COOKIE['panier'])){
				print_r(unserialize($_COOKIE['panier']));
			}
	
	}else{
		if(isset($_POST['confirmation']) && isset($_COOKIE['panier'])){
			//si la réservation est confirmée
			// Lecture du fichier CSV.
			if ($monfichier = fopen('ResultatsFestival.csv', 'r'))
			{
			    $row = 0; // Variable pour numéroter les lignes
			    $newcontenu = [];

			    // Lecture du fichier ligne par ligne :
			    while (($ligne = fgetcsv($monfichier)) !== FALSE)
			    {
		        	// Si le numéro de la ligne est égal au numéro de ligne d'un article :
			        foreach(unserialize($_COOKIE['panier']) as $article){
						if($row == $article['lineReservation']){
							$titre = $ligne[2];
							$lieu = $ligne[3];
							$date = $ligne[0];
					 	    // Variable contenant la nouvelle ligne :
							$nouvelle_ligne = $ligne;
							print("<p>votre réservation pour ".$titre." le ".$date." à ".$lieu);
							numCol = 0;
							$strTarif="";
								
						}
					}
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
//	    			fputcsv($fichierecriture, $lineContent,chr(0));
					fputs($fichierecriture, implode($lineContent, ',')."\n");
	    		}
    			fclose($fichierecriture);
		   
//#########################################################################################################################################
		}else{
			// si pas de requète POST, on affiche le panier
			foreach(unserialize($_COOKIE['panier']) as $article){
				print_r($article);
				$lineReservation =  $article['lineReservation'];

				if (($handle = fopen("ResultatsFestival.csv", "r")) !== FALSE) {
        	                        fgetcsv($handle, 1000, ","); //On retire la 1ere ligne du csv (legendes)
                	                $cptLine = 1;
                        	        while (($data = fgetcsv($handle, 1000, "\n")) !== FALSE) {
						if($cptLine==$lineReservation){
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
		                	                        $jour = $fields[0];
        		                	                $horaire = $fields[1];
	                	                	        $titre = $fields[2];
        	                	                	$lieu = $fields[3];
	        	                	                $village = $fields[4];
        	        	                	        $compagnie = $fields[5];
							}
							print("<div class='Spectacle'><p>".$article['tarifPlein']." places tarif plein, ".$article['tarifReduit']." places tarif réduit et ".$article['tarifEnfant']." places tarif enfant</p>");
							print("<p><horaire>". $horaire . "</horaire> , <lieu> au " . $lieu . " à " . $village . "</lieu>, <titrespectacle>". $titre ."</titrespectacle>, par <troupe>" . $compagnie . "</troupe></p></div>");

							break;
						}
						$cptLine+=1;
					}
				}
			}

		}
//	}

?>
</div>
</main>
</body>
</html>
