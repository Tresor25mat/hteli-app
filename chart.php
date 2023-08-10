<?php 



?>


<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        
        <!-- Styles -->
		<style>
			#chartdiv {
			  width: 100%;
			  height: 350px;
			} 

			#chartdiv1 {
			  width: 100%;
			  height: 500px;
			  font-size: 11px;
			}

			.amcharts-pie-slice {
			  transform: scale(1);
			  transform-origin: 50% 50%;
			  transition-duration: 0.3s;
			  transition: all .3s ease-out;
			  -webkit-transition: all .3s ease-out;
			  -moz-transition: all .3s ease-out;
			  -o-transition: all .3s ease-out;
			  cursor: pointer;
			  box-shadow: 0 0 30px 0 #000;

			}

			.amcharts-pie-slice:hover {
			  transform: scale(1.1);
			  filter: url(#shadow);
			}                           
                          
		</style>
		<script src="lib/components/jquery/dist/jquery.min.js"></script>
		<script src="amcharts/amcharts.js"></script>
		<script src="amcharts/serial.js"></script>
		<script src="amcharts/pie.js"></script>
		<script src="amcharts/plugins/export/export.min.js"></script>
		<link rel="stylesheet" href="amcharts/plugins/export/export.css" type="text/css" media="all" />
		<script src="amcharts/themes/light.js"></script>




		<script>
			var chart2 = AmCharts.makeChart("chartdiv1", {
			  "type": "pie",
			  "startDuration": 2,
			   "theme": "chalk",
			  "addClassNames": true,
			  "legend":{
			    "position":"bottom",
			    "marginRight":100,
			    "autoMargins":false
			  },
			  "innerRadius": "30%",
			  "defs": {
			    "filter": [{
			      "id": "shadow",
			      "width": "200%",
			      "height": "200%",
			      "feOffset": {
			        "result": "offOut",
			        "in": "SourceAlpha",
			        "dx": 0,
			        "dy": 0
			      },
			      "feGaussianBlur": {
			        "result": "blurOut",
			        "in": "offOut",
			        "stdDeviation": 5
			      },
			      "feBlend": {
			        "in": "SourceGraphic",
			        "in2": "blurOut",
			        "mode": "normal"
			      }
    			}]
  				},
  				"dataProvider": [


			    {
			    	"site": "TRESOR",
			    	"enregistrement": 25,
			    	"color": "#44CC11"
			  	}

				  , {
				    	"site": "MATONDO",
				    	"enregistrement":  75,
				    	"color": "#ED1C24"
				    } 


 				],
				  "valueField": "enregistrement",
				  "titleField": "site",
				  "colorField":"color",
				  "export": {
				    "enabled": false
				  }
				});

			chart2.addListener("init", handleInit);

			chart2.addListener("rollOverSlice", function(e) {
			  handleRollOver(e);
			});

			function handleInit(){
			  chart2.legend.addListener("rollOverItem", handleRollOver);
			}

			function handleRollOver(e){
			  var wedge = e.dataItem.wedge.node;
			  wedge.parentNode.appendChild(wedge);
			}

			</script>
    	</head>
    <body style="background: white">
      <br />
        <div style="display:inline-block; width: 100%; margin-top: -50px" >
          <div id="chartdiv1"></div>         
        </div>
    </body>
</html>