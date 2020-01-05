<?php 
	//on indique que le contenu est du JSON    
	header('Content-Type: application/json');
	$row = 0;
	
	//lecture csv ResultatsFestival
	if ($handle = fopen('../csv/ResultatsFestival.csv', 'r'))
	{
		fgetcsv($handle, 1000, ","); //On ignore la 1ere ligne du csv (legendes)
		while (($data = fgetcsv($handle,1000,",")) !== FALSE)
		{
			//pour chaque ligne on récupère les données sur les places réservées		
			$plein = (int)$data[6] * (15 * 0.1) * 2 ;
			$reduit = (int)$data[7] * (10 * 0.1) * 2 ;
			$sj = (int)$data[9] * (10 * 0.9) * 2 ;
			$sa = (int)$data[10] * (15 * 0.9) * 2 ;
			
			//on stocke ces données dans une nouvelle ligne de tab (qui sera donc de taille 44 à la fin)
			$tab[$row]= (array("plein"=>$plein, "reduit"=>$reduit,"sj"=>$sj,"sa"=>$sa));
			$row++;
		}
	}

	//fermeture du fichier en lecture
	fclose($handle);
	//affichage de "tab" encodé en JSON pour être passé à un script JS
	print(json_encode($tab));
?>
