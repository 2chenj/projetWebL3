<?php 
        header('Content-Type: application/json');
		$row = 0;
		if ($handle = fopen('../ResultatsFestival.csv', 'r'))
			{
			fgetcsv($handle, 1000, ","); //On ignore la 1ere ligne du csv (legendes)
			while (($data = fgetcsv($handle,1000,",")) !== FALSE)
			    {

					
					$plein = (int)$data[6] * 2 ;
					$reduit = (int)$data[7] * 2 ;
					$sj = (int)$data[9] * 2 ;
					$sa = (int)$data[10] * 2 ;
					
					$tab[$row]= (array("plein"=>$plein, "reduit"=>$reduit,"sj"=>$sj,"sa"=>$sa));
					$row++;
				}
        }
		fclose($handle);
        print(json_encode($tab));
?>
