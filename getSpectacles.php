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

            // affichage des message de bonjour
            $cont = file_get_contents("ResultatsFestival.csv");

            // on coupe le contenu du fichier avec le caractere de saut de ligne

            $spectacles = explode("\n", $cont);

            //on affiche ligne apres ligne telle quelle
		$lastDate = "none";
		print("<table>");
        foreach ($spectacles as $i => $v){

			print("<tr>");
			$tabValue = explode(",", $v);

			foreach ($tabValue as $id => $value){
				if($id==0){
					if($lastDate != $value){
						print("<td>".$value."</td>\n");
					}else{
						print("<td></td>\n");
					}
					

				}else{
					if($id<6)print("<td>".$value."</td>\n");
				}
			}
			
	        print('<td><form action ="resa.php" method="GET"><input type="submit" value="Réserver"/><input type="hidden" name="line" value="'.$i.'"/></form></td>');
			print("</tr>");
			$lastDate = $tabValue[0];
        }

		print("</table>");
?>


  </body>
</html>
