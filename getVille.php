<?php
	
			header('Content-Type: application/json');
			if (($handle = fopen("ResultatsFestival.csv", "r")) !== FALSE)
			{
				fgetcsv($handle, 1000);//On retire la 1ere ligne du csv (legendes)
				$jour = "null";
				$row = 1;
				while (($fields = fgetcsv($handle, 1000)) !== FALSE)
				{
					if($row == $_GET["ligne"]){
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
			
	
?>

	
