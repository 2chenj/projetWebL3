<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Theatres de Bourbon</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
  </head>
  <body>


<?php

<<<<<<< HEAD
if (($handle = fopen("ResultatsFestival.csv", "r")) !== FALSE) {
				fgetcsv($handle, 1000, ",");//On retire la 1ere ligne du csv (legendes)
				$jour = "null";
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
					
					$fields = preg_split("[,]", $replaced);
					if($jour != $fields[0]){
						$jour = $fields[0];
						echo "<h2> " . $jour . "</h2>";
					}
					echo "<div class= \"Lieu\">\n";
					echo $fields[2] . ", par " . $fields[5] . " à " . $fields[4] . "\n</div>\n";
					
				
=======
            // affichage des message de bonjour
            $cont = file_get_contents("ResultatsFestival.csv");

            // on coupe le contenu du fichier avec le caractere de saut de ligne

            $spectacles = explode("\n", $cont);

            //on affiche ligne apres ligne telle quelle

		
      	$lastDate = explode(",", $spectacles[0])[0];
        foreach ($spectacles as $i => $v){

			print("<tr>");
			$tabValue = explode(",", $v);
		
			if($lastDate != $tabValue){
				print("<h2>".$value."</h2>");
			}
			}else{
			switch($id){
						case 2:
							print("<horaire>".$value."</horaire>");
						case 3:
							print("<lieu>".$value."</lieu>");
					}
					//if($id<6)print("<td>".$value."</td>\n");
				}
>>>>>>> 2bedeb68d7a117d8f821406247fc8e837a249e8c
			}
			
		}
		
		fclose($handle);
	}
?>


  </body>
</html>
