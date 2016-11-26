<?php
	require 'db.php';
	$query = pg_query($db_towers, "WITH different_towers(cell, hints) AS (
		select cell, count(*) from towers WHERE range > 0 group by cell)
		SELECT count(cell), sum(hints) from different_towers;");
	$rows = pg_fetch_row($query);
	
	$query = pg_query($db_towers, "select max(towers.range) from towers;");
	$max = pg_fetch_row($query);
	
	echo json_encode(array("count"=>$rows[0],"max"=>$max[0]));
?>