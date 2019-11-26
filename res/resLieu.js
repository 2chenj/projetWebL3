const width_canevas = 1700;
const height_canevas = 1000;
const nb_barre = 2;
const width_barre = 150;				

$.ajax({
	type:'post',
	url:"res/resLieu.php",
	success:function(data){
	        console.log(data)
	        var decalageWidth = 200;
	        var decalageHeight = 50;

	        printLegendes();
	        printAxe(decalageWidth-20, decalageHeight,2);
			//line(decalageWidth-20,(height_canevas/2),width_canevas,(height_canevas/2));	        
			printPlusieuresBarres(width_barre, data, decalageWidth, decalageHeight);	                
	            
	}
})
