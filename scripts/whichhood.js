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
// also update the hidden blockid field with the bbcode of the recently-gathered point
function onEachFeature(feature, layer) {
  var pointLoc = feature.geometry.coordinates.reverse();
  map.panTo(pointLoc); 
  $("#neighborhood input[name=block]").val(feature.properties.bbcode);
}

// pass the neighborhood to be saved
	function passName(neighborhood, block) {
    $.post("new.php", { neighborhood: neighborhood, block: block} );
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
    var givenName = $("#neighborhood input[name=neighborhood]").val();
    var blockid = $("#neighborhood input[name=block]").val();
    console.log(blockid);
    if 	(givenName == "" || givenName == null || !isNaN(givenName) || givenName.charAt(0) == ' ') {
      $('#neighborhood input[name=neighborhood]').focus();
      return false; 
    } else {
      passName(givenName, blockid);  
      getPoint();
      $('#neighborhood input[name=neighborhood]').focus();
  	  return false; 
  	}
  	});

});