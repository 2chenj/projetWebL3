<?php include ("menu.html"); ?>

<div class="bandeau">
  <h1>Théâtres de Bourbon : Troupe par troupe </h1>
</div>

<main>
  <div class="decalage">

<?php
  if( ($handle = fopen("ResultatsFestival.csv","r")) !== FALSE ){
    fgetcsv($handle,1000,",");
    $cptLine = 1;
    //hashmap string -> array of string
    $sousTableau = [];
    while ( ($allDate = fgetcsv($handle,1000,"\n")) !== FALSE ) {

      foreach ($allDate as $lines) {
        $replaced = preg_replace_callback(
          '/"(\\\\[\\\\"]|[^\\\\"])*"/',
            function($match){
            $tempo = preg_replace("[,]",'&#44;',$match);
            implode($tempo);
            return $tempo[0];
          } ,
          $lines
        );
          $fields = preg_split("[,]",$replaced);
		  $fields[12] = $cptLine;
		  $cptLine++;

          //former if places
/*
          if(  ! in_array($fields[3],$sousTableau) ){
            //if unseen city, create a new map for it
            $sousTableau[ $fields[3] ]=[];
          }*/
          //putt the whole line deragmented into the hasmap city -> lines, delim = ","

          $sousTableau[$fields[5]] [] = $fields;
          //array_push($sousTableau[$fields[3]],$fields);
          //former fields
      }




    }//end of while fgetcsv

    ksort($sousTableau);
    //show hashmap
    $firstTroupe = true;
		foreach ($sousTableau as $compagnie => $lines) {
		if($firstTroupe){
			print("<div class='Spectacle'><h2>".$compagnie."</h2>\n");
			$firstTroupe = false;
		}else{
			print("</div><div class='Spectacle'><h2>".$compagnie."</h2>\n");
		}
		  foreach ($lines as $fields) {
        
        $jour = $fields[0];
        $horaire = $fields[1];
        $titre = $fields[2];
        $ville = $fields[3];
        $village = $fields[4];
		$cptLine = $fields[12];

        print("<p> <jour> ". $jour. "</jour>, <horaire>". $horaire . "</horaire> , <lieu> au " . $ville . " à " . $village . "</lieu>, <titrespectacle>". $titre ."</titrespectacle> \n");
        print('<form action ="resa.php" method="GET"><input type="submit" value="Réserver"/><input type="hidden" name="line" value="'.$cptLine.'"/></form></p>');
        $cptLine++;
      }//end of foreach $city

    }//end of foreach $sousTableau
    print("</div>");

  }else{
    echo "le fchier n'a pas pu être ouvert par fopen";
  }//fin if fopen
?>

</div>
</main>
</body>
</html>
