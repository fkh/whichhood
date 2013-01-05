var geojsonLayer = new L.geoJson();	
var markers = new L.featureGroup();
var bounds = new L.LatLngBounds;

//-- FUNCTIONS --//

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

// get a point from the database, including the current map bounds.
function getBoundedPoint() {
    
  bounds = map.getBounds();
  var bbox = bounds.toBBoxString();
  
  console.log(bbox);
  
  $.ajax({
      type: "POST",
      url: "point.php",
      data: { 
              'bounds': bbox
            },
      dataType: 'json',
      success: function (response) {
        markers.removeLayer(geojsonLayer);
        geojsonLayer = L.geoJson(response, {
          onEachFeature: onEachFeature
        }).addTo(map);
      }
  });
};

// geojson coords are reversed, so swap them and pan to the location of the recently-added marker
// also update the hidden blockid field with the bbcode of the recently-gathered point
function onEachFeature(feature, layer) {
  var pointLoc = feature.geometry.coordinates.reverse();
  
  //if user has zoomed in, don't change anything
  if (map.getZoom() <= 14) {
    map.panTo(pointLoc);
    map.setZoom(14);    
  } else {
  }
  $("#neighborhood input[name=block]").val(feature.properties.block);
  $("#spinner").hide(20);
}

// pass the neighborhood to be saved
	function passName(neighborhood, block) {
    $.post("new.php", { neighborhood: neighborhood, block: block} );
	};
	
	function lockZoom() {	  
	  if (map.getZoom() <= 14) { 
      $("#locked-warning").hide();
    } else {
      $("#locked-warning").show();    
    }
    
	}
	
//-- JQUERY --//

$(document).ready(function() { 

  // load first point once user is ready to start  
  $('#start').click(function (event){ 
    $('#start').hide();
    $('#nabeform').show();
    $("#spinner").show();
    getBoundedPoint();
    $('#nabearea').focus();
  });
  
  // intercept the form submission
  $("#neighborhood").submit(function (event){ 
    
    $("#spinner").show();
      
    //avoid submitting bad data
    var givenName = $("#neighborhood input[name=neighborhood]").val();
    var blockid = $("#neighborhood input[name=block]").val();
    if 	(givenName == "" || givenName == null || !isNaN(givenName) || givenName.charAt(0) == ' ') {
      $('#neighborhood input[name=neighborhood]').focus();
      return false; 
    } else {
      passName(givenName, blockid);  
      getBoundedPoint();
      $('#neighborhood input[name=neighborhood]').focus();
  	  return false; 
  	}
  	});
  	
  //skip if not sure
  $('#skip').bind('click', function() {
    $("#spinner").show();
    getBoundedPoint();
    $('#nabearea').focus();
  });

});