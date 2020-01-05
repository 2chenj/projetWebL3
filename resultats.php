
<?php include ("menu.html"); ?>
 
 <!-- on enlève l'image "peleMele" pour avoir plus de place pour le graph-->
<style type="text/css">
  body{
    background-image: url();
  }
</style>


    	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  		 <script type="text/javascript" src="res/fonctionsRes.js"></script>
				
				<!-- choix du graph (par représentation, lieu ou troupe) -->
  				<h1>
  				<table>
  						<tr>
  							<form action ="resultats.php" method="POST">
  					 			<input type="submit" value="par représentaion" name="representaion"/>
  							</form>		
  								<form action ="resultats.php" method="POST">
  							 	<input type="submit" value="par lieu" name="lieu"/>
  							</form>
  							<form action ="resultats.php" method="POST">
  					 			<input type="submit" value="par troupe" name="troupe"/>
  							</form>
  						</tr>
  				</table>
				</h1>
				</br>

  		<!-- CANVAS -->
  		
      
      <canvas id="dessin" width="1700" height="1200">
  			<?php 
				if(isset($_POST["lieu"])){
					print('<script type="text/javascript" src = "res/resLieu.js"></script>');
				}else{
					if(isset($_POST["troupe"])){
						print('<script type="text/javascript" src = "res/resTroupe.js"></script> ');
					}else{
						print('<script type="text/javascript" src = "res/resRepresentation.js"></script> ');	
					}
					
				}
			?>	   		 	
  		</canvas>
      
  </body>
</html>
