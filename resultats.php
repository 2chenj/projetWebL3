<?php include ("menu.html"); ?>
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  		 <script type="text/javascript" src="res/fonctionsRes.js"></script>
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
