<?php
header('Content-Type: application/json');
if( ($handle = fopen("../ResultatsFestival.csv","r")) !== FALSE )
		{
			fgetcsv($handle,1000);
			$place ="null";
			$cptLine = 1;
			//hashmap string -> array of string
			$sousTableau = [];
			$row=0;
			while ( ($fields = fgetcsv($handle,1000)) !== FALSE ) 
			{
				$fields[12] = $cptLine;
				$cptLine++;

						//putt the whole line deragmented into the hasmap city -> lines, delim = ","

				$sousTableau[$fields[3]] [] = $fields;
						//array_push($sousTableau[$fields[3]],$fields);
						//former fields

			}//end of while fgetcsv

			ksort($sousTableau);
				//show hashmap
			$firstCity = true;

			
			foreach ($sousTableau as $city => $lines) 
			{
				$plein = 0;
				$reduit = 0;
				$sj = 0;
				$sa = 0;
				foreach ($lines as $fields)
				{
					$village = $fields[4];
					if($place != $fields[3])
					{
						$place = $fields[3];
					}

					 	// on récupère les données de la ligne
					$plein += (int)$fields[6] * (15 * 0.1)  /2;
					$reduit += (int)$fields[7] * (10 * 0.1) /2;
					$sj += (int)$fields[9] * (10 * 0.9)     /2;
					$sa += (int)$fields[10] * (15 * 0.9)    /2;
					
			
			
				}//end of foreach $city
						$tab[$row]= (array("plein"=>$plein, "reduit"=>$reduit,"sj"=>$sj,"sa"=>$sa));
						$row++;
						$firstRepresentation = false;

			}//end of foreach $sousTableau
		}else{
			echo "le fchier n'a pas pu être ouvert par fopen";
		}
		fclose($handle);
		print(json_encode($tab));
?>