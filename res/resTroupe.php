<?php
	//on indique que le contenu est du JSON
	header('Content-Type: application/json');

	//lecture csv ResultatsFestival
	if( ($handle = fopen("../csv/ResultatsFestival.csv","r")) !== FALSE )
	{
		fgetcsv($handle,1000);
		$cptLine = 1;
		$sousTableau = [];
		
		while ( ($fields = fgetcsv($handle,1000)) !== FALSE )
		{
			//on ajoute le numéro de la ligne à chaque fin de ligne dans la nouvelle colonne 12
			$fields[12] = $cptLine;
			$cptLine++;
			//On ajoute la ligne qu'on est en train de parcourir au tableau "sousTableau" à l'index correspondant à la troupe de cette ligne 
			$sousTableau[$fields[5]] [] = $fields;
		}//end of while fgetcsv

		//on trie le tableau
		ksort($sousTableau);
		$row=0;
		
		foreach($sousTableau as $lines) {
			//pour chaque troupe dans "sousTableau" on a une ou plusieures lignes
			$plein = 0;
			$reduit = 0;
			$sj = 0;
			$sa = 0;
		
			foreach($lines as $fields) {
				// on récupère les données de la ligne et les ajoute au total de la troupe
				$plein += (int)$fields[6] * (15 * 0.1) /2; 
				$reduit += (int)$fields[7] * (10 * 0.1) /2;
				$sj += (int)$fields[9] * (10 * 0.9) /2;
				$sa += (int)$fields[10] * (15 * 0.9) /2;	
			}//end of foreach $city
			
			//on enregistre les résultats de la troupe dans "tab"
			$tab[$row]= (array(
								"plein"=>$plein,
								"reduit"=>$reduit,
								"sj"=>$sj,
								"sa"=>$sa, 
								"troupe"=>$fields[5]
							));
			$row++;
			
		}//end of foreach $sousTableau

  	}else{
		echo "le fchier n'a pas pu être ouvert par fopen";
	}//fin if fopen
	
	//fermeture du fichier en lecture
	fclose($handle);
	//affichage de "tab" encodé en JSON pour être passé à un script JS
  	print(json_encode($tab));
?>
