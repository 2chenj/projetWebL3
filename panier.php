<?php include ("menu.html"); ?>

<div class="bandeau">
	<h1>Théâtres de Bourbon : Panier </h1>
</div>

<main>
	<div class="decalage">
		<?php

		function nbPlaces($panier){
			$res = 0;
		//le panier doit etre unserialize
			foreach($panier as $article){
				$res+=$article['tarifPlein']+$article['tarifReduit']+$article['tarifEnfant'];
			}
			return $res;
		}

		function enleveNplaces($n, $panier){
		//on offre des tarifs réduits

			foreach ($panier as $id => $value){	

				while($n>0 && $panier[$id]['tarifReduit']>0){
					
					//on offre la place
					$panier[$id]['tarifReduit']-=1;
					$panier[$id]['offert']+=1;
					$n-=1;
					
				}	        

			}


			if($n>0){
        	//on offre des tarifs pleins
				foreach ($panier as $id => $value){	


					while($n>0 && $panier[$id]['tarifPlein']>0){
					//on offre la place
						$panier[$id]['tarifPlein']-=1;
						$panier[$id]['offert']+=1;
						$n-=1;

					}

				}

			}

			return $panier;
		}


		function offrePlaces($panier){
			$nbPlaces = nbPlaces($panier);
			if($nbPlaces>0){
				$placesAenlever = (int)($nbPlaces/6);
				if($placesAenlever>0){
					$panier = enleveNplaces($placesAenlever,$panier);
				}
			}
			return $panier;
		}


	if(isset($_POST['lineReservation'])){ // je verifie que le formulaire a bien été posté
		
		$articleDejaExistant = 0;
		$article_added = $_POST; // j'enregistre les valeurs envoyées dans post 
		//verfier qu'il y a asser de places
		if(isset($_COOKIE['panier']) && !empty($_COOKIE['panier'])) {   // je vérifie que le cookie existe
			$cart = json_decode($_COOKIE['panier'], true);  // je recupère les possibles articles déjà dans le panier
			foreach ($cart as $id => $value){
				if($value['lineReservation'] == $article_added['lineReservation']){
					$cart[$id]['tarifPlein'] += $article_added['tarifPlein'];
					$cart[$id]['tarifReduit'] += $article_added['tarifReduit'];
					$cart[$id]['tarifEnfant'] += $article_added['tarifEnfant'];
					$cart[$id]['offert']=0;
					$articleDejaExistant = 1;
				}
			}
		}
		
		//si l'article n'est pas encore dans le panier et qu'on réserve au moins une place
		if($articleDejaExistant == 0 && ($article_added['tarifPlein']!=0 || $article_added['tarifReduit']!=0 || $article_added['tarifEnfant']!=0)){
			$cart[] = array(   // j'ajoute dans le tableau cart l'article, avec les informations qui sont dans article
				'lineReservation' 	=> $article_added['lineReservation'],
				'tarifPlein'		=> $article_added['tarifPlein'],
				'tarifReduit'           => $article_added['tarifReduit'],
				'tarifEnfant'		=> $article_added['tarifEnfant'],
				'offert'		=> 0
			);
			
		}

		

		setcookie('panier', json_encode($cart), (time() + 2592000)); // je remplace/ajoute un nouveaux cookie, avec les informations du panier; je garde le cookie pour 2592000 (~1 mois)
		header("Location:panier.php"); //on recharge la page pour afficher le panier
		print_r($cart);

	}else{
		if(isset($_POST['confirmation']) && isset($_COOKIE['panier'])){
			//si la réservation est confirmée
			// Lecture du fichier CSV.
			
			$cart = offrePlaces(json_decode($_COOKIE['panier'], true));

			if ($handle = fopen('ResultatsFestival.csv', 'r'))
			{
			    $row = 0; // Variable pour numéroter les lignes
			    $newcontenu = [];
			    // Lecture du fichier ligne par ligne :
			    while (($ligne = fgetcsv($handle,1000)) !== FALSE)
			    {

			    	$nouvelle_ligne = $ligne;
				    // Si le numéro de la ligne est égal au numéro de ligne d'un article :
			    	if($row!=0){
			    		foreach($cart as $article){
			    			if($row == $article['lineReservation']){
			    				$nouvelle_ligne[6] = ($ligne[6])+$article['tarifPlein'];
			    				$nouvelle_ligne[7] = ($ligne[7])+$article['tarifReduit'];
			    				$nouvelle_ligne[8] = ($ligne[8])+$article['offert'];
			    				$nouvelle_ligne[11] = ($ligne[11])+$article['tarifEnfant'];							  		
			    			}
			    		}
			    	}

			    	$newcontenu[$row] = $nouvelle_ligne;
			    	$row++;					
			    }
			    setcookie('panier');

			}

			fclose($handle);
			$fichierecriture = fopen('ResultatsFestival.csv', 'w');
			foreach($newcontenu as $nbLine => $lineContent){
				fputs($fichierecriture, implode($lineContent, ',')."\n");
				
			}
			fclose($fichierecriture);

		}else{
			// VIDE PANIER
			if(isset($_POST["videPanier"])){
				setcookie('panier');
				header("Location:panier.php");
			}else{
					// si pas de requète POST, on affiche le panier
				if(isset($_COOKIE['panier']) && !empty(json_decode($_COOKIE['panier'], true))){
					
						//si un panier existe
						//on offre les places uniquement pour l'affichage
					$cart =offrePlaces(json_decode($_COOKIE['panier'], true));

					foreach($cart as $article){
						
						$lineReservation =  $article['lineReservation'];
						if (($handle = fopen("ResultatsFestival.csv", "r")) !== FALSE) {
				    	                        fgetcsv($handle, 1000); //On retire la 1ere 	ligne du csv (legendes)
				    	                        $cptLine = 1;
				    	                        while (($fields = fgetcsv($handle, 1000)) !== 	FALSE) {
				    	                        	if($cptLine==$lineReservation){
				    	                        		
				    	                        			$jour = $fields[0];
				    	                        			$horaire = $fields[1];
				    	                        			$titre = $fields[2];
				    	                        			$lieu = $fields[3];
				    	                        			$village = $fields[4];
				    	                        			$compagnie = $fields[5];
				    	                        		
				    	                        		print("<div class='Spectacle'><p>".$article['tarifPlein']." places tarif plein, ".$article['tarifReduit']." places tarif réduit, ".$article['tarifEnfant']." places tarif enfant et ".$article['offert']." places offertes</p>");
				    	                        		print("<p><horaire>". $horaire . "</horaire> , <lieu> au " . $lieu . " à " . $village . "</lieu>, <titrespectacle>". $titre ."</titrespectacle>, par <troupe>" . $compagnie . "</troupe></p></div>");
				    	                        		break;
				    	                        	}
				    	                        	$cptLine+=1;
				    	                        }
				    	                    }
				    	                }


						// form vider panier		
				    	                print('<form action ="panier.php" method="POST">');
				    	                print('<input type="submit" value="viderPanier"/>');
				    	                print('<input type="hidden" name="videPanier" value="true"/>');
				    	                print('</form>');

						// form réserver
				    	                print('<form action ="panier.php" method="POST">');
				    	                print('<input type="submit" value="Réserver"/>');
				    	                print('<input type="hidden" name="confirmation" value="true"/>');
				    	                print('</form>');

				    	                print("</div>");
				    	                print("</figure>");



				    	            }else{
					//si pas de panier
				    	            	print("<h2> Votre panier est vide</h2>");
				    	            }
				    	        }
				    	    }
				    	}
				    	?>
				    </div>
				</main>
			</body>
			</html>
