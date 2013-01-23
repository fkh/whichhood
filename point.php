<?php
  include('functions.php');

  if ($_POST['bounds'] <> '') { 
    // we have bounds so we should get a bounded point
  
  $bounds = pg_escape_string($_POST['bounds']);
  
	$mapPoint = getRandomBoundedPoint($bounds);
	
} else {
  // no bounds, just get a point anywhere
  
  $mapPoint = getRandomPoint();
  	
}

print($mapPoint);

?>