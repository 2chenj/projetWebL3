<?php
	
			
			if (($handle = fopen("ResultatsFestival.csv", "r")) !== FALSE)
			{
				fgetcsv($handle, 1000);//On retire la 1ere ligne du csv (legendes)
				$jour = "null";
				$row = 1;
				while (($fields = fgetcsv($handle, 1000)) !== FALSE)
				{
					if($row == $_GET["ligne"]){
						$ville = $fields[4];
						print($ville);
						break;
					}
					$row++;
				}
			}
			
	
?>

	
