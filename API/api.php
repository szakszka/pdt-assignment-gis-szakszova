<?php
	require 'db.php';
	$query = pg_query($db_towers, "WITH different_towers(cell, hints) AS (
		select cell, count(*) from towers WHERE range > 0 group by cell)
		SELECT count(cell), sum(hints) from different_towers;");
	$rows = pg_fetch_row($query);
	echo "$rows[0]";
?>