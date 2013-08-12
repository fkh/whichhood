	var bars = [];
			
	$(function() {
				
		var map;
		var markersArray = [];
		var initialCenter = new google.maps.LatLng(-74,40);
		var bBCode;
		
	    var mapOpts = {
	      zoom: 15,
	      center: initialCenter,
	      mapTypeControlOptions: {mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'custom'] },
		  mapTypeControl: false, 
		  navigationControl: true,
		  navigationControlOptions: {
		    style: google.maps.NavigationControlStyle.SMALL
		  }
	
	    }
	
	
	    map = new google.maps.Map(document.getElementById("map"), mapOpts);
	
var mapStyle = [
		  {
		    featureType: "administrative.neighborhood",
		    elementType: "labels",
		    stylers: [
		      { visibility: "off" }
		    ]
		  },{
		    featureType: "administrative.locality",
		    elementType: "labels",
		    stylers: [
		      { visibility: "off" }
		    ]
		  }];
		
		var overlayMap = new google.maps.Map(
		  document.getElementById('overlay_map'), {
		 mapTypeId: google.maps.MapTypeId.ROADMAP, 
		disableDefaultUI: true,
		  zoom: 11,
	      center: initialCenter
		});	
	
		  var styledMapOptions = {
		      name: "whichhood"
		  }

		  var whichhoodMapType = new google.maps.StyledMapType(
		      mapStyle, styledMapOptions);

		  map.mapTypes.set('custom', whichhoodMapType);
		  map.setMapTypeId('custom');
	
		
		
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
				bBCode = data.id; // wow, not block...
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
		  bars.push(1);
		 sparktick(bars);
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
			bars.push(0);
			sparktick(bars);
             getPoint();
          });
		
	});
