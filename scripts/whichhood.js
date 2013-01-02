var geojsonLayer = new L.geoJson();	
var markers = new L.featureGroup();

// get a point from the database
function getPoint() {
  
  $.ajax({
      type: "POST",
      url: "point.php",
      dataType: 'json',
      success: function (response) {
        markers.removeLayer(geojsonLayer);
        geojsonLayer = L.geoJson(response, {
          onEachFeature: onEachFeature
        }).addTo(map);
      }
  });
};


//-- FUNCTIONS --//

// geojson coords are reversed, so swap them and pan to the location of the recently-added marker 
function onEachFeature(feature, layer) {
  var pointLoc = feature.geometry.coordinates.reverse();
  map.panTo(pointLoc);    
}

// pass the neighborhood to be saved
	function passName(neighborhood) {
    $.post("new.php", { neighborhood: neighborhood} );
	};
	
	
//-- JQUERY --//

$(document).ready(function() { 

  // load first point once user is ready to start  
  $('#start').click(function (event){ 
  getPoint();
  });
  
  // intercept the form submission
  $("#neighborhood").submit(function (event){ 
        
    //avoid submitting bad data
    givenName = $("#neighborhood input[name=neighborhood]").val();
    if 	(givenName == "" || givenName == null || !isNaN(givenName) || givenName.charAt(0) == ' ') {
      $('#neighborhood input[name=neighborhood]').focus();
      return false; 
    } else {
      passName(givenName);  
      getPoint();
      $('#neighborhood input[name=neighborhood]').focus();
  	  return false; 
  	}
  	});

});