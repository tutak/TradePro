<?php
	include 'database.php';
	function insert_data($parameters){

		$userId = $parameters['userId'];
		$currencyFrom = $parameters['currencyFrom'];
		$currencyTo = $parameters['currencyTo'];
		$amountSell = $parameters['amountSell'];
		$amountBuy = $parameters['amountBuy'];
		$rate = $parameters['rate'];
		$timePlaced = $parameters['timePlaced'];
		$originatingCountry = $parameters['originatingCountry'];
		// Convert the given date to MySQL's date format
		$date = date("Y-m-d H:i:s", strtotime($timePlaced));

		// Create an instance of the database object. DAO pattern used.
		$db = new dao("root", '', "mtp_db","mysql", "localhost");
		$db->connect();

		// insert the JSON data into two tables. Send back consumer_ws.php the feedback for the insertions so that //appropriate HTTP codes can be sent back to the client.
		if((($db->insertUser($userId,$originatingCountry )) === true) && ($db->insertData($date,$currencyFrom, $currencyTo, $amountSell, $amountBuy, $rate, $userId)) === true){
			return true;
		} else {
			return false;
		}

	}

?>