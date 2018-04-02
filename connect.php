<?php

	//code to conect to database
	$link = pg_connect("host=localhost port=5432 dbname=project user=postgres password=google123");

	if(!$link){
	  die('Could not connect: ' . pg_last_error());
	}
	//Select the database to run the queries on
	$query = "set search_path = 'project'";

	//code to excecute query
	pg_query($query);

	//echo "The current date is $date";

?> 