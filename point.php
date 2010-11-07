<?php
include('konnect.php');
include('functions.php');

	//get a random point (assumes you already have adodb set up in an include)
	$mapPoint = getPoint();
	$x = ($mapPoint[x]);
	$y = ($mapPoint[y]);
	$id = ($mapPoint[id]);

	print(json_encode(array(x => $x, y => $y, id => $id)));
	
?>