<?php
  include 'processor.php';

  //Array of JSON passed
  $parameters = array();
  $body = file_get_contents("php://input");
  $parameters = json_decode($body, $assoc=true);
  if($parameters) {
       // Make sure JSON passed conforms with the structure needed to be saved in the database
    if(isset($parameters['userId'],$parameters['currencyFrom'],$parameters['currencyTo'], $parameters['amountSell'],$parameters['amountBuy'], $parameters['rate'], $parameters['timePlaced'], $parameters['originatingCountry']))    {
      
      // Validate and insert data using processor.php If the data was successfully stored in the database after     //validation, respond with HTTP code 200: OK
      if(insert_data($parameters)){
        http_response_code(200);
      } else {
        // If there was some issue inserting the data, respond with HTTP code 500: Internal Server Error
        http_response_code(500);
      }

    } else {
      // If the JSON passed doesn't have the required structure, respond with HTTP code 422: Unprocessable Entity 
      http_response_code(422);
    }

  } else {
    // If an empty JSON was passed, respond with HTTP code 400: Bad Request Error
    http_response_code(400);
  }

?>