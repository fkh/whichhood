<?php

function getPoint() {

	$db = dbConnect();
	
	$rs = $db->Execute('select * from blocks where "ID" > 100 and "ID" < 2000 order by random() limit 1;'); 
	
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


?>
