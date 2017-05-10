<?php 
	function insertar($database,$collection,$datos){
	    try {
	        $connection = new MongoDB\Client;
	        $database = $connection->$database;
	        $collection = $database->$collection;
	    } catch (MongoConnectionException $e) {
	        echo "Error: " . $e->getMessage();
	    }

	    $collection->insertMany($datos, array('safe' => true));
	}

 ?>