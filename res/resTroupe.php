<?php
	
	header('Content-Type: application/json');

  if( ($handle = fopen("../csv/ResultatsFestival.csv","r")) !== FALSE ){
	fgetcsv($handle,1000);
	$cptLine = 1;
	//hashmap string -> array of string
	$sousTableau = [];
	while ( ($fields = fgetcsv($handle,1000)) !== FALSE ) {
		  $fields[12] = $cptLine;
		  $cptLine++;


		  $sousTableau[$fields[5]] [] = $fields;
	}//end of while fgetcsv

	ksort($sousTableau);
	//show hashmap
	
	$row=0;
	foreach($sousTableau as $lines) {
		$plein = 0;
		$reduit = 0;
		$sj = 0;
		$sa = 0;
		foreach($lines as $fields) {
			$plein += (int)$fields[6] * (15 * 0.1) /2; 
			$reduit += (int)$fields[7] * (10 * 0.1) /2;
			$sj += (int)$fields[9] * (10 * 0.9) /2;
			$sa += (int)$fields[10] * (15 * 0.9) /2;	
		}//end of foreach $city
	
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
  fclose($handle);
  print(json_encode($tab));
?>
