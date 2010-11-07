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
	      mapTypeId: google.maps.MapTypeId.ROADMAP,
		  mapTypeControl: false, 
		  navigationControl: true,
		  navigationControlOptions: {
		    style: google.maps.NavigationControlStyle.SMALL
		  }
	
	    }
	
	
	    map = new google.maps.Map(document.getElementById("map"), mapOpts);
	
		var overlayMap = new google.maps.Map(
		  document.getElementById('overlay_map'), {
		  mapTypeId: google.maps.MapTypeId.ROADMAP, 
		  disableDefaultUI: true,
		  zoom: 11,
	      center: initialCenter
		});	
	
		
		var overDiv = overlayMap.getDiv();
		map.getDiv().appendChild(overDiv);
		overDiv.style.position = "absolute";
		overDiv.style.right = "0px";
		overDiv.style.bottom = "14px";
		overDiv.style.zIndex = 10;

		google.maps.event.addListener(overlayMap, 'idle', function() {
		  overlayMap.getDiv().style.zIndex = 10;
		});
		
		overlayMap.bindTo('center', map, 'center');
		
		var markers = [];
		
		getPoint();
	
		function getPoint() {
			$('#add-block input[name=neighborhood]').focus();
			$.getJSON("point.php", function(data){
			    centerMap(data.x, data.y);
				bBCode = data.id;
			 });
		};
	
		function centerMap(lon, lat) {
			mapCenter = new google.maps.LatLng(lat, lon);
			map.setCenter(mapCenter);
			map.setZoom(15);
			clearOverlays();
			var marker = new google.maps.Marker({
		        position: mapCenter, 
		        map: map
		    });   
		
			markers.push(marker);
		
		}
		
		function clearOverlays() { //tidy up the map and info pane
			if (markers) {
			    for (i in markers) {
			      markers[i].setMap(null);
			    }
			  }
		}
		
		function saveName() {
			
		}
		
		$("#add-block").submit(function(){ 
		givenName = $("#add-block input[name=neighborhood]").val();
		if 	(givenName == "" || givenName == null || !isNaN(givenName) || givenName.charAt(0) == ' ') {
			$('#add-block input[name=neighborhood]').focus();
			return false; 
		} else {
		  passName(); 
		  return false; 
		}
		});
	
		function passName() {
	//		$('#status').text('Saving...');
	//		$('#status').show();
			
			var data = $("#add-block input[name=neighborhood]").serializeArray(); 
			data[data.length] = {name:'id', value: bBCode};
				  $.post("http://brooklyn.whichhood.org/new.php", data, function(json){ 
				    if (json.status =="fail") { 
				    	// error here
				}
				    if (json.status =="success") { 
				 		//something here
				    } 
				  }, "json"); 
				
					$('#add-block input[name=neighborhood]').focus();
					getPoint();
					
		};
		
		$('#skip').bind('click', function() {
             getPoint();
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
	
	<h1><a name="top"></a>Which neighborhood is this block in?</h1>
<div id="map"></div>
<div id="overlay_map"></div>
<a href="#about">About</a>
<form id="add-block" action="new.php" enctype="multipart/form-data" method="POST" name="addform">
<p><input type="text" name="neighborhood" value="neighborhood" class="bigtext" onFocus="this.value='';"></input></p>
<input  type="hidden" name="lng" value="" ></input>
<input type="submit" value="Name it!" style="background: white; color: black; font-size: 1.2em">
<input type="button" id="skip" value="Not sure, skip it." style="background: white; color: black; font-size: 1.2em">

</form>
<br><br><br><br>
<p><a href="#about">About</a> | Get involved | Data</p>

<div id=about>
<p><a name="about"></a><strong>About</strong></p>
<p>WhichHood.org is an experimental sketch for a collaborative neighborhood mapping tool. It's an in-progress hack by @fkh and @harupeanut from the Great Urban Hack, November 6/7. <a href="http://ietherpad.com/9nCYFyqftE">Read the hackathon task list</a>.</p>
<p>High-quality neighborhood boundaries could form the basis for many civic apps -- news, issue reporting, local retail, planning, etc. But those maps don't exist. Any available data typically represent an administrative or real estate focused view. The "official" boundaries don't adapt and grow as rapidly as neighborhoods do in our daily use. What if a community data source existed, generated from thousands of individual contributions? What if adding data to that resource was kinda fun? Maybe a bit competitive? A game?</p>

<p>[Why drawing boundaries is too hard, how these points could be used]</p>
	
<p><a href="#top">Top</a></p>.

<p><a name="data"></a><strong>Get involved</strong></p>
<p>[link to githut and roadmap] </p>
<p><a href="#top">Top</a></p>.

<p>
<a name="data"></a><strong>Data</strong></p>
<p>[link to data download and latest snapshots].</p>
<p><a href="#top">Top</a></p>.

</div>


</body>
</html>
                                                                       	