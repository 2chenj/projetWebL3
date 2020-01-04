
<?php
	$tableauBidimension = array();
if (($handle = fopen("csv/distanceEntreVilles.csv", "r")) !== FALSE) {
				fgetcsv($handle, 1000,",");//On retire la 1ere ligne du csv (legendes)
				$jour = "null";
				$cptLine = 1;
			
				while (($data = fgetcsv($handle, 1000, "\n")) !== FALSE) {
						
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
				}	
					$fields = preg_split("[,]", $replaced);
					$tableauBidimension [$fields[0]] = $fields;		
				}
				print_r($tableauBidimension);
}
	function distAndTemps($tableauBidimension,$ville1, $ville2, $horraire){
				//i get indexes of the 2 cities
				$indexVille1 =0;
				$indexVille2 = 0;
				foreach($tableauBidimension as $ville => $ligneParVille){
					$indexForEach = 0;
					if($ville == $ville1){
						$indexVille1 = $indexForEach;
					}elseif($ville == $ville2){
						$indexVille2 = $indexForEach;
					}
					$indexForEach++;
				}
			echo "</br>   ".$tableauBidimension[$indexVille1][$indexVille2]."</br>";
	}

		distAndTemps($tableauBidimension,"Moulins", "Cmermont-Ferrand",2);

?>







