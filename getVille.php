<?php
	if(isset($_GET["ligne"])){}
		
		//on indique que le contenu est du JSON
		header('Content-Type: application/json');

		//lecture csv ResultatsFestival
		if (($handle = fopen("csv/ResultatsFestival.csv", "r")) !== FALSE)
		{
			fgetcsv($handle, 1000);//On retire la 1ere ligne du csv (legendes)
			$jour = "null";
			$row = 1;
			while (($fields = fgetcsv($handle, 1000)) !== FALSE)
			{
				if($row == $_GET["ligne"]){
					//si on est sur la ligne demandée, on affiche le jour, l'heure et la ville en JSON
					$jour = $fields[0];
					$heure = $fields[1];
					$ville = $fields[4];
					$tab = array('jour' => $jour, 'heure' => $heure, 'ville' => $ville);
					print(json_encode($tab));
					break;
				}
				$row++;
			}
		}
	}		
	
?>

	
