<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>réservation</title>
    <link rel="stylesheet" href="style.css">

  </head>
  <body>
<?php
if (isset($_GET["line"]))$nbSpectacle=$_GET["line"];
$spectacles = file('ResultatsFestival.csv');

//On parcourt le tableau $spectacles
foreach ($spectacles as $lineNumber => $lineContent){
	if ($lineNumber == $nbSpectacle){
//		print($lineContent);
		$lineContentTab =explode(",",$lineContent);
		$date = $lineContentTab[0];
		$heure = $lineContentTab[1];
		$titre = $lineContentTab[2];
		$lieu = $lineContentTab[3];
		$village = $lineContentTab[4];
		$compagnie = $lineContentTab[5];

		print("<h2>".$titre."</h2>");
		print("la compagnie ".$compagnie." vous présente la pièce ".$titre." le ".$date." au village de ".$village." à ".$heure." dans le ".$lieu.".");
	}
}
?>



  </body>
</html>

