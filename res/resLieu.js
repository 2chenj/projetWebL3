const width_canevas = 1700;
const height_canevas = 1200;
const nb_barre = 2;
const width_barre = 100;
const espace_barres = 150;

$.ajax({
	type:'post',
	url:"res/resLieu.php",
	success:function(data){
	        console.log(data)
	        var decalageWidth = 200;
	        var decalageHeight = 50;

	        printLegendes();
	        printAxe(decalageWidth-20, decalageHeight,2);
			printPlusieuresBarres(width_barre, data, decalageWidth, decalageHeight,["1","2","3","4","5","6","7","8"]);	                
	            
	}
})
