<?php 
        header('Content-Type: application/json');
		$row = 0;
		if ($handle = fopen('ResultatsFestival.csv', 'r'))
			{
			fgetcsv($handle, 1000, ","); //On ignore la 1ere ligne du csv (legendes)
			while (($data = fgetcsv($handle,1000,",")) !== FALSE)
			    {

					
					$plein = $data[6];
					$reduit = $data[7];
					$sj = $data[9];
					$sa = $data[10];
					
					$tab[$row]= (array("plein"=>$plein, "reduit"=>$reduit,"sj"=>$sj,"sa"=>$sa));
					$row++;
				}
        }
		fclose($handle);
        print(json_encode($tab));
?>
