<?php 

if (isset($_POST['neighborhood']) && $_POST['neighborhood'] <> '') {

	$redirect = $_POST['neighborhood'];
	
	$redirect = str_replace(" ", "+", $redirect);
	
	header( 'Location: http://brooklyn.whichhood.org/name/' . $redirect );
	
} 

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>brooklyn.whichhood.org</title>
	<meta name="generator" content="TextMate http://macromates.com/">
	<meta name="author" content="frank">
	
	<LINK href="/style.css" rel="stylesheet" type="text/css"></LINK>
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
	<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
	<script src="ol/OpenLayers.js"></script>
	
	<script type="text/javascript" charset="utf-8">
	$(function() {
		var map;
		var markersArray = [];
		var initialCenter = new google.maps.LatLng(-74,40);
		var bBCode;
		
	    var mapOpts = {
	      zoom: 15,
	      center: initialCenter,
	      mapTypeId: google.maps.MapTypeId.TERRAIN,
		  mapTypeControl: false, 
		  navigationControl: true,
		  navigationControlOptions: {
		    style: google.maps.NavigationControlStyle.SMALL
		  }
	
	    }
	
	
	    map = new google.maps.Map(document.getElementById("map"), mapOpts);
		
		var small = {
		        icon: 'http://labs.google.com/ridefinder/images/mm_20_blue.png',
		        shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'	  
		    };

		
		
		var bounds = new google.maps.LatLngBounds();
		
		<?php 
		include('konnect.php');
		include('functions.php');
		
			if ($_GET['neighborhood'] <> '') {
				
				$focus = $_GET['neighborhood'];
		
				$markers = getMarkers($focus);
				
				foreach ($markers as $marker) {
			
			     	print "var point = new google.maps.LatLng(parseFloat(" . $marker["y"] . "),parseFloat(" . $marker["x"] . ")); \n";
			    	print "bounds.extend(point); var marker = new google.maps.Marker({ position: point, icon: small.icon, map: map });\n" ;	
				}	
			}
		
		?>
			

		map.fitBounds(bounds);
		
		var listener = google.maps.event.addListener(map, "idle", function() { 
		  if (map.getZoom() > 14) map.setZoom(14); 
		  google.maps.event.removeListener(listener); 
		});
		

		});
		
	</script>	
	
	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-19558271-1']);
	  _gaq.push(['_setDomainName', '.whichhood.org']);
	  _gaq.push(['_trackPageview']);

	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	</script>
	
</head>

<body>
	
	
	<?php
	
	
	print "<h1>Blocks in " . $focus . " </h1>";
	
	$names = getNeighborhoods();
	
	
	print "<form action='http://brooklyn.whichhood.org/view.php' method='POST'>";
	print "<select name='neighborhood' onchange='submit();'";
	
	print "<option value=''> <em>choose...</em></option>";
	
	foreach ($names as $name) {
		$clean = trim($name, "'");
		
		print "<option value='" . $clean . "'>" . $clean . "</option>";
	}
	
	print "</select></form>";	
	print "<br><br>";
	
	?>
<div id="map"></div>
<p><a href="http://brooklyn.whichhood.org">Back</a>.</p>
</body>
</html>
