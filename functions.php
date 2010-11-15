<?php

function getPoint() {

	$db = dbConnect();
	
	$rs = $db->Execute('select * from blocks order by random() limit 1;'); 
	
	while ($row = $rs->FetchNextObject()) {
		$x = $row->X;
		$y = $row->Y;
		$id = $row->ID;
	}
	
	$blockPoint = array(x => $x, y => $y, id => $id);

	return $blockPoint;
}



function countNames() {

	$db = dbConnect();
	
	$rs = $db->Execute('select count(*) as "count" from names;'); 
	
	while ($row = $rs->FetchNextObject()) {
		$count = $row->COUNT;
	}	
	
	$totalCount = array(names => $count);

	return $totalCount;
}


function getNeighborhoods() {
	//returns a list of neighborhood names, where more than one marker has been named.
	$db = dbConnect();
	
	$rs = $db->Execute('select count(*) as "Number", names.neighborhood from names group by names.neighborhood having count(*) > 1 order by names.neighborhood ASC;');
	
	$names = array();
	
	while ($row = $rs->FetchNextObject()) {
		
		array_push($names, $row->NEIGHBORHOOD);

	}
	
	return $names;
	
}


function getMarkers($focus) {
	//return all the markers for a particular place name;

			
	$db = dbConnect();

	
	$sql = "SELECT * FROM \"blocks\", \"names\" where \"blocks\".\"ID\" = \"names\".\"block\" and \"names\".\"neighborhood\" = '\\'" . $focus . "\\'';";
	
	$rs = $db->Execute($sql);
	
	$markers = array();
	
	while ($row = $rs->FetchNextObject()) {
			
		$location = array("x" => $row->X, "y" => $row->Y);
		array_push($markers, $location);
		
	}

	return $markers;
}


function stats(){
	//count total number of nabes and total blocks...
	
	
}

?>
