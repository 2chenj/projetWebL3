<canvas id="graph"></canvas><br><br>
<script>

            var texts = [
                "text1",
                "text2",
                "text3",
                "text4",
                "text5",
                "text6",
                "text7"
            ];

            var graph;
            var xPadding = 30;
            var yPadding = 30;
            
            // Notice I changed The X values
            var data = { values:[
                { X: 0, Y: 12, width: 13, height: 20},
                { X: 20, Y: 32, width: 13, height: 10},
                { X: 40, Y: 18, width: 13, height: 10},
                { X: 60, Y: 34, width: 13, height: 10},
                { X: 80, Y: 40, width: 13, height: 10},
                { X: 100, Y: 80, width: 13, height: 10},
                { X: 120, Y: 80, width: 13, height: 10}
            ]};

            // Returns the max Y value in our data list
            function getMaxY() {
                var max = 0;
                
                for(var i = 0; i < data.values.length; i ++) {
                    if(data.values[i].Y > max) {
                        max = data.values[i].Y;
                    }
                }
                
                max += 10 - max % 10;
                return max;
            }

            // Returns the max X value in our data list
            function getMaxX() {
                var max = 0;
                
                for(var i = 0; i < data.values.length; i ++) {
                    if(data.values[i].X > max) {
                        max = data.values[i].X;
                    }
                }
                
                // omited
              //max += 10 - max % 10;
                return max;
            }
            
                graph = document.getElementById("graph");
                var c = graph.getContext('2d');            
                // Draw the dots
                for(var i = 0; i < data.values.length; i ++) {  
                    c.beginPath();
                    c.rect(data.values[i].X, data.values[i].Y, data.values[i].width, data.values[i].height);
                    c.fill();
                }


        graph.addEventListener(
            "mousemove", 
            (function(evt) {
                var rect = evt.target.getBoundingClientRect();
                var x = evt.clientX - rect.left;
                var y = evt.clientY - rect.top;
                var xd, yd;
                console.log("test : x="+x+"  y="+y);
                graph.title = "";
    			for(var i = 0; i < data.values.length; i ++) {
                    
                    xd = data.values[i].X;
                    yd = data.values[i].Y;
                    
                    if ((x > xd-data.values[i].width) && (x < xd+data.values[i].width) && (y > yd-data.values[i].height) && (y < yd+data.values[i].height) ) {
    			        graph.title = texts[i];
                        break;
                    }
                }
            }),
            false);
</script>
</canvas>