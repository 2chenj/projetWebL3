<?php 
        header('Content-Type: application/json');

        $x = array(20,300);
        $y = array(20,300);
        $tab =array("forme" => (array("x"=>$x, "y"=>$y) ));

        print(json_encode($tab));

?>
