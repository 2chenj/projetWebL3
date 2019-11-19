<?php 
        header('Content-Type: application/json');

        
        $plein = 11;
        $reduit = 8;
        $sj = 2;
        $sa = 1;
        $tab =array("barre1" => (array("plein"=>$plein, "reduit"=>$reduit,"sj"=>$sj,"sa"=>$sa)),
        			"barre2" => (array("plein"=>$plein+2, "reduit"=>$reduit+8,"sj"=>$sj+4,"sa"=>$sa+12)));
		
        print(json_encode($tab));

?>
