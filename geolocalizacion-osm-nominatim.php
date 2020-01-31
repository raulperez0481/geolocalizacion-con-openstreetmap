<?php
    
	function geocode($address){

			$opts = array('http'=>array('header'=>"User-Agent: StevesCleverAddressScript 3.7.6\r\n"));
			$context = stream_context_create($opts);
			$url ="https://nominatim.openstreetmap.org/search?format=json&q=$address";
			
			
    		// get the json response
    		$resp_json = file_get_contents($url, false, $context);

    		// decode the json
    		$resp = json_decode($resp_json, true);

   		return array($resp[0]['lat'], $resp[0]['lon']);
	
}

	$cRet = "<script>
   								var osmUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
   								var osmAttrib='Map data © <a href=https://openstreetmap.org>OpenStreetMap</a> contributors';
									var osm = L.tileLayer(osmUrl, {maxZoom: 40,attribution: osmAttrib});
									var map = L.map('map',{scrollWheelZoom: false}).setView([42.8477, -2.6683], 14).addLayer(osm);
						</script>";


if (isset($_GET['direccion'])){

	
	$address=$_GET['direccion'];
	$address = urlencode($address);
	
		$resp=geocode($address);
		$lati = $resp[0];
		$longi = $resp[1];


  $cRet  .= "<script>var marker = L.marker([ $lati, $longi]).addTo(map).bindPopup('Where the GISC was born.');";            
  $cRet  .= "</script>";
}


?>
    

<!DOCTYPE html>
<html>

			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<title>Geolocalización en mapa de OpenStreetMap con Leaflet y Nominatim</title>
			<link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css">
			<style type="text/css">
					
					form{
						
						
							width: 50%;
							margin-top: 50px;
							margin-left: 150px;
					
					}
					
					label, p{
					
						margin-left: 30px;
					
					}
					
					input[type=text]{
  							width: 80%;
  							padding: 12px 20px;
  							margin: 8px 0;
							border: 1px solid #ccc;
							border-radius: 4px;
  							box-sizing: border-box;
					}
					
					div{
					
							 text-align: center;
					}
					
					input[type=submit]{
					
							padding: 5px;
    						font-size: 1em;
    						width: 30%;

					}
					
					label{
					
						font-size: 1.4em;
						padding-right: 10px;
					}
					
					p{
							padding: 0;
							width: 300px;
							margin-left: 150px;
							margin-top: -8px;
							margin-bottom: 20px;
					}
					
			</style>
			</head>
			
			<body>
			
						<form action="geolocalizacion-osm-nominatim.php" method="GET">
								<h1>Geolocaliza una dirección</h1>  
								 <label>Direccion</label>
								 		<input type="text" name="direccion"/>
								 <p>( Ej: vitoria, calle francia, 4 )</p>	
								 <div>	
										<input type="submit" value="Geolocalizar"/>
								</div>
						</form>
						
						<script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js"></script>	  
						<div id="map" class="map map-home" style="margin:12px 0 12px 0;height:800px;"></div>
							
						<?php echo $cRet; ?>
	
			 </body>
</html>

    
    