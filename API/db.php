<?php
	$host        = "host=localhost";
	$port        = "port=5432";
	$dbname_osm      = "dbname=osm_slovakia";
	$dbname_towers   = "dbname=cell_towers_slovakia";
	$credentials = "user=postgres password=root";

	$db_osm = pg_connect( "$host $port $dbname_osm $credentials"  );
	if(!$db_osm){
		echo "Error : Unable to open database $dbname_osm\n";
	}
   
	$db_towers = pg_connect( "$host $port $dbname_towers $credentials"  );
	if(!$db_towers){
		echo "Error : Unable to open database $dbname_towers\n";
	}
?>