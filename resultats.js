$.ajax({
	type:'post',
	url:"getDessin.php",
	success:function(data){
	        console.log(data)
	        var c = document.getElementById("dessin");
	        var ctx = c.getContext("2d");

	                
	             		ctx.beginPath();
	                	ctx.rect(
	                		data.forme.x[0] ,
	                		data.forme.y[0] ,
	                		data.forme.x[1] - data.forme.x[0] , 
	                		data.forme.y[1] - data.forme.y[0]
	                	);
	                	ctx.stroke();
	                	ctx.fillStyle = "red";
						ctx.fill();
	            
	}
})
