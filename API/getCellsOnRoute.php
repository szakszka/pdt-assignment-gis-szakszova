<?php
	ini_set('max_execution_time', 300);
	
	$lineString = $_POST["lineString"];
	$encoded_string = json_encode ($lineString);

	require "db.php";

	$nets = $_POST["nets"];
		
	$netList = '';
	
	if(!empty($nets)) {
		foreach($nets as $check) {
				$netList = $netList .',' .$check;
		}
	} 
	$netList= substr($netList, 1);	
	
	$query = pg_query($db_towers,"WITH operatorCoverOnRoute AS
				(
					SELECT ST_AsGeoJSON(the_geom) AS geojson, the_geom, towers.cell, towers.radio, towers.net, towers.samples, towers.range, towers.averagesignal,
					ST_Distance(ST_Transform(towers.the_geom,26986),
						ST_Transform((SELECT ST_MakeLine(ST_GeomFromText(ST_AsText(ST_GeomFromGeoJSON('$encoded_string')), 4326))), 26986)) as distance,
					ST_LineLocatePoint(ST_Transform(ST_GeomFromText(ST_AsText(ST_GeomFromGeoJSON('$encoded_string')), 4326),26986), ST_Transform(towers.the_geom,26986)) as llp,
					RANK() OVER (PARTITION BY net ORDER BY ST_Transform(ST_GeomFromText(ST_AsText(ST_GeomFromGeoJSON('$encoded_string')), 4326),26986)
				 <-> ST_Transform(towers.the_geom,26986)) AS top
					FROM towers 
					WHERE range > 0 AND net IN ($netList) AND ST_DWithin(ST_Transform(towers.the_geom,26986),
						ST_Transform((SELECT ST_MakeLine(ST_GeomFromText(ST_AsText(ST_GeomFromGeoJSON('$encoded_string')), 4326))), 26986),
						towers.range)
				), NearestOperatorCoveronRoute AS (
					SELECT *, RANK() OVER (PARTITION BY llp ORDER BY distance) as toptop
					FROM operatorCoverOnRoute
				)
				SELECT * 
				FROM NearestOperatorCoveronRoute
				where toptop=1;"); 								

	$num_rows = pg_num_rows($query);

	if ($num_rows == 0) { 
		echo $num_rows;
	   exit(0);
	};

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