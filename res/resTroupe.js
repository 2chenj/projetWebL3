const width_canevas = 1700;
const height_canevas = 1200;
const nb_barre = 2;
const width_barre = 100;				

$.ajax({
	type:'post',
	url:"res/resTroupe.php",
	success:function(data){
	        var decalageWidth = 200;
	        var decalageHeight = 50;

	        printLegendes();
	        printAxe(decalageWidth-20, decalageHeight,2);
			//line(decalageWidth-20,(height_canevas/2),width_canevas,(height_canevas/2));	        
			printPlusieuresBarres(width_barre, data, decalageWidth, decalageHeight);	                
	            
	}
})
