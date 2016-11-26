<?php
	require 'db.php';
	$query = pg_query($db_towers, "WITH different_towers(net, hits) AS (
				select net, count(DISTINCT  cell) FROM towers WHERE towers.range > 0 GROUP BY net)
				SELECT sum(hits) FROM different_towers;");
	$rows = pg_fetch_row($query);
	
	$query = pg_query($db_towers, "select max(towers.range) from towers;");
	$max = pg_fetch_row($query);
	
	$query = pg_query($db_towers, "SELECT net, count(DISTINCT  cell) FROM towers WHERE towers.range > 0 GROUP BY net ORDER BY net;");
	$operator = pg_fetch_all($query);
	
	echo json_encode(array("count"=>$rows[0], "max"=>$max[0], "orange"=>$operator[0]["count"], "telecom"=>$operator[1]["count"], "swan"=>$operator[2]["count"], "o2"=>$operator[3]["count"]));
?>