<?php
	$lineString = $_POST["lineString"];
	$encoded_string = json_encode ($lineString);

	require "db.php"; 	

	$query = pg_query($db_towers,"SELECT ST_AsGeoJSON(the_geom) AS geojson, towers.cell, towers.radio, towers.net, towers.samples, towers.range, towers.averagesignal
		FROM towers WHERE ST_DWithin(
				ST_Transform(towers.the_geom,26986),
				ST_Transform((SELECT ST_MakePolygon(ST_AddPoint(foo.open_line, ST_StartPoint(foo.open_line))) FROM 
				(SELECT ST_GeomFromText(ST_AsText(ST_GeomFromGeoJSON('$encoded_string')), 4326) As open_line) As foo),26986),	
			towers.range)=true;"); 

	$num_rows = pg_num_rows($query);

	if ($num_rows == 0) { 
		echo $num_rows;
	   exit(0);
	};

	//echo json_encode ($lineString);

	$rows = pg_fetch_all($query);
	$towers = []; 

	foreach ($rows as $point){
		$coordinates = json_decode($point["geojson"]);
		$cell = $point["cell"];	
		$radio = $point["radio"];	
		$net = $point["net"];
		$samples = $point["samples"];
		$range = $point["range"];
		$averagesignal = $point["averagesignal"];
		
		switch ($net)
		{
			case "1": $operator = "Orange"; break; //Orange
			case "2": $operator = "Telecom"; break; //Telecom
			case "3": $operator = "Swan (4ka)"; break; //Swan
			case "6": $operator = "O2"; break; //O2
			default: $operator = "0";
		}
		
		$towers[] = [
			"type"=> "Feature",
			"geometry"=> $coordinates,
			"properties"=> [
				"net"=> $net,
				"title"=> $operator ." " .$radio,
				"description"=> "CellId: ".$cell ."<br/>Range: ".$range ." m<br/>Samples: ".$samples,
				"range"=> $range
			]
		];
	}
	
	echo json_encode ($towers);	
?>	