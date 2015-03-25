# TradePro
TradePro is a Message Trade Processor which consists of four components:
* **RESTful web service - consumer_ws.php**
* **Message processor - processor.php**
* **Database component - database.php**
* **Frontend component - frontend.php**
 
Message data, in JSON format, is *POSTed* to the web service, which after initial controls passes the data to the message processor. The message processor validates the data and inserts it in the MySQL database using the database component. The frontend uses Google charts to give a glimpse of the data in the database. Data is passed to the frontend using the database component.

How to call the web service
-------------------

 **Use cURL**

  curl -X POST -H "application/json" -d '*JSON_DATA*' http://146.148.123.175/consumer_ws.php
  
  **JSON format:**
  
  JSON must have the following structure.
  
   {"userId": "*INTEGER*", "currencyFrom": "*CURRENCY_CODE*", "currencyTo": "*CURRENCY_CODE*", "amountSell":*INTEGER*, "amountBuy": *DECIMAL*, "rate": *INTEGER*, "timePlaced" : "*D-M-Y H:M:S*", "originatingCountry" : "*COUNTRY_CODE*"}

   **Example:**
``` curl -X POST -H "application/json" -d '{"userId": "5", "currencyFrom": "JPY", "currencyTo": "EUR", "amountSell": 1000, "amountBuy": 37.10, "rate": 14, "timePlaced" : "21-FEB-13 10:27:44", "originatingCountry" : "IE"}' http://146.148.123.175/consumer_ws.php```





