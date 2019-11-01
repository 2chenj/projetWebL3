<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Theatres de Bourbon</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
  </head>
  <body>


<?php
	if(!empty($_POST)){ // je verifie que le formulaire a bien été posté
		$articleDejaExistant = 0;
		$article_added = $_POST; // j'enregistre les valeurs envoyées dans post (inutile, mais je le fais...)

		if(isset($_COOKIE['panier']) AND !empty($_COOKIE['panier'])) {   // je vérifie que le cookie existe
			$cart = unserialize($_COOKIE['panier']);  // je recupère les possibles articles déjà dans le panier
	                foreach ($cart as $id => $value){
        	                if($value['lineConfirmation'] == $article_added['lineConfirmation']){
                	                $cart[$id]['tarifPlein'] += $article_added['tarifPlein'];
                        	        $cart[$id]['tarifReduit'] += $article_added['tarifReduit'];
                                	$cart[$id]['tarifEnfant'] += $article_added['tarifEnfant'];

	                                $articleDejaExistant = 1;
        	                }
	                }
		}

		if($articleDejaExistant == 0){
			$cart[] = array(   // j'ajoute dans le tableau cart l'article, avec les informations qui sont dans article
				'lineConfirmation' 	=> $article_added['lineConfirmation'],
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
	}else{ // si pas de requète POST, on affiche le panier
		foreach(unserialize($_COOKIE['panier']) as $article){
			//print_r($article);
			$lineConfirmation =  $article['lineConfirmation'];

			if (($handle = fopen("ResultatsFestival.csv", "r")) !== FALSE) {
                                fgetcsv($handle, 1000, ","); //On retire la 1ere ligne du csv (legendes)
                                $cptLine = 1;
                                while (($data = fgetcsv($handle, 1000, "\n")) !== FALSE) {
					if($cptLine==$lineConfirmation){
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

?>
</body>
</html>
