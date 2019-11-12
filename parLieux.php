<?php include ("menu.html"); ?>

<div class="bandeau">
  <h1>Théâtres de Bourbon : Lieu par lieu </h1>
</div>

<main>
  <div class="decalage">

<?php
  if( ($handle = fopen("ResultatsFestival.csv","r")) !== FALSE ){
    fgetcsv($handle,1000,",");
    $place ="null";
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

          $sousTableau[$fields[3]] [] = $fields;
          //array_push($sousTableau[$fields[3]],$fields);
          //former fields
      }




    }//end of while fgetcsv
    ksort($sousTableau);
    //show hashmap
    $firstCity = true;
    foreach ($sousTableau as $city => $lines) {
      foreach ($lines as $fields) {
        $village = $fields[4];
        if($place != $fields[3]){
          $place = $fields[3];
          if($firstCity){
          	print("<div class='Spectacle'><h2>".$city." à ".$village."</h2>\n");
          	$firstCity = false;
          }else{
          	print("</div><div class='Spectacle'><h2>".$city." à ".$village."</h2>\n");
          }
        }
        $jour = $fields[0];
        $horaire = $fields[1];
        $titre = $fields[2];
        $compagnie = $fields[5];
		$cptLine = $fields[12];
        print("<p> <jour> ". $jour. "</jour>, <titrespectacle>". $titre ."</titrespectacle>, par <troupe>" . $compagnie . "</troupe>, <horaire>". $horaire . "</horaire> \n");
        print('<form action ="resa.php" method="GET"><input type="submit" value="Réserver"/><input type="hidden" name="line" value="'.$cptLine.'"/></form></p>');

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
