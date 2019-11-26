<?php if( ($handle = fopen("csv/distanceEntreVilles.csv","r")) !== FALSE ){
    fgetcsv($handle,1000,",");
    $place ="null";
    $cptLine = 1;
    //hashmap string -> array of string
    $sousTableau = [];
    $villes_et_dist = [];
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

          $fields = preg_split("[;]",$replaced);
	  array_push ($sousTableau, $fields);

      }
    }
    foreach( $sousTableau as $tableau){
	    printf("</br> element  0 : ".$tableau." fin de l'ement </br>");
    }
}
?>
