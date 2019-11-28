<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>
<body>
	<p id="text"></p>
<?php
	
	if(isset($_COOKIE['panier']) && !empty(unserialize($_COOKIE['panier']))){
		$panier = unserialize($_COOKIE['panier']);
		foreach($panier as $article){
			
			if (($handle = fopen("ResultatsFestival.csv", "r")) !== FALSE)
			{
				fgetcsv($handle, 1000);//On retire la 1ere ligne du csv (legendes)
				$jour = "null";
				$row = 1;
				while (($fields = fgetcsv($handle, 1000)) !== FALSE)
				{
					if($row == $article["lineReservation"]){
						$ville1 = $fields[4];
						break;
					}
				}
			}

			if (($handle = fopen("ResultatsFestival.csv", "r")) !== FALSE)
			{
				fgetcsv($handle, 1000);//On retire la 1ere ligne du csv (legendes)
				$jour = "null";
				$row = 1;
				while (($fields = fgetcsv($handle, 1000)) !== FALSE)
				{
					$ville2 = $fields[4];
					echo '
					<script>
						$.ajax({
							type:"POST",
							url:"DEV.php",
							data: "ville1='.$ville1.'&ville2='.$ville2.'&horaire=17h15", 
							success:function(data){
								document.getElementById("text").innerHTML = data;
	        				}
						})
					</script>
					';
				}
			}
		}
	}else{
		print("<h2>Panier Vide</h2>");
	}

?>
</body>
</html>
	
