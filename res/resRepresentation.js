const width_canevas = 1700;
const height_canevas = 1200;
const nb_barre = 2;
const width_barre = 25;				

$.ajax({
	type:'post',
	url:"res/resRepresentation.php",
	success:function(data){
	        console.log(data)
	        var decalageWidth = 200;
	        var decalageHeight = 50;

	        printLegendes();
	        printAxe(decalageWidth-20, decalageHeight,0.5);
			//line(decalageWidth-20,(height_canevas/2),width_canevas,(height_canevas/2));	        
			printPlusieuresBarres(width_barre, data, decalageWidth, decalageHeight);	                
	            
	}
})
