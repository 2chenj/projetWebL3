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
					
				
			}
			
		}
		
		fclose($handle);
	}
?>


  </body>
</html>
