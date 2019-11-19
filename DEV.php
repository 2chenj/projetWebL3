<?php if( ($handle = fopen("distanceEntreVilles.csv","r")) !== FALSE ){
    fgetcsv($handle,1000,",");
    $place ="null";
    $cptLine = 1;
    //hashmap string -> array of string
    $mon_tab = [];
    $villes_et_dist = [];
    while ( ($allDate = fgetcsv($handle,1000,"\n")) !== FALSE ) {

      foreach ($allDate as $lines) {
		$valTab = preg_split("/,/",$lines);
		$mon_tab[ array_shift($valTab)] = $valTab;
      }
    }
    //j'affiche mon_tab
    foreach( $mon_tab as $cle => $sous_tab){
	    echo $cle."  est associé à : ";
	    foreach( $sous_tab as $val){
	    	echo "[".$val."]";
	    
	    }echo "</br>";
    }


    //  l'objective de la suite de fonction est de retourner le te temps et les km seperant deux ville doné
    
    // vans dans un tab et recupere les dince de chaque d'une ille
    function getIndex($tab_assiciative , $ville){
	    $ind = -1;
	    $compteur = 0;
	    foreach( $tab_assiciative as $cle_ville => $tab_val ){
	    	if ( $cle_ville == $ville){
			$ind =  $compteur;
			return $ind;
		}
		$compteur++;
	    }
	    return $ind;
    }
    // retourn le valeur aasocie à deux ville   ie  km et temps
    function getAssocOf2City($tab_assiciative, $ville1, $ville2 ){
	    $index = getIndex($tab_assiciative, $ville2);
	    if( $index == -1 ){
		    echo " nous n'avons aucun spectacle dans cette ville la";
		    return;
	    }
	    foreach( $tab_assiciative as $cle_ville => $val_tab ){
		if( $cle_ville == $ville1 ){
			return $val_tab[$index];
		}
	   }
    
    }

    // retourn une distance ou un temps
    function getDistOrTime($tab_assiciative, $ville1 , $ville2 , $temps_ou_dist){
	   $val_non_formate =  getAssocOf2City($tab_assiciative , $ville1, $ville2);
	   $format1 = preg_replace("~/~","", $val_non_formate);
	   $format2 = preg_replace("(km|h|min)",":",$format1);
	   $formated = preg_split("~:~",$format2);	

	   echo " no formaté ".$val_non_formate."</br>";
	   echo " no / : ".$format1."</br>";
	   echo "no km : ".$format2."</br>";
	   echo "taille : ".strlen($format2)."</br>";
	   print_r($formated);


    
    
    }

	//min main !!!! 
    echo "indice = ".getIndex( $mon_tab, "Vichy")."</br>";
    echo " val no formaté = ".getAssocOf2City( $mon_tab, "Vichy" ,"Veauce")."</br>";
    echo " val = ".getDistOrTime($mon_tab,"Vichy","Veauce","d");


    
}
?>
