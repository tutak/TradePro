<?php
	class dao{
		private $db = NULL;
		private $connection_string = NULL;
		private $db_type ;
		private $db_host ;
		private $db_user ;
		private $db_pass ;
		private $db_name ;
		private $conn = false;

		/**
		 *	
		 * The constructor besides the username, password and host accepts database type
		 * so that it can create a different connection string according to different DBMS's, allowing 
		 * decoupling of business layer from the data layer. 
		 * 
		 */
		public
		function __construct($db_user, $db_pass, $db_name,$db_type, $db_host){
			$this->db_host = $db_host;
			$this->db_user = $db_user;
			$this->db_pass = $db_pass;
			$this->db_name = $db_name;
			$this->db_type = $db_type;
			switch($this->db_type){
				case "mysql":
					$this->connection_string = "mysql:host=".$db_host.";dbname=".$db_name;
					break;
				case "sqlite":
					$this->connection_string = "sqlite:".$db_path;
					break;
				case "oracle":
					$this->connection_string = "OCI:dbname=".$db_name.";charset=UTF-8";
					break;
				case "dblib":
					$this->connection_string = "dblib:host=".$db_host.";dbname=".$db_name;
					break;
				case "postgresql":
					$this->connection_string = "pgsql:host=".$db_host." dbname=".$db_name;
					break;
		}

		return $this;
	}

	public
	function connect(){
		//if we don't have an active connection, create one.
		if(!$this->conn){
			try {
				$this->db = new PDO($this->connection_string,$this->db_user,$this->db_pass);
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->conn = true;
				return $this->conn;
			}
			catch (PDOException $e)    {
				return $e->getMessage();
			}

		} else {
			return true;
		}

	}

	/** 
	 *
	 * userID and country from where the message is originating is inserted into the users table.
	 * PDO is used to help against 1st order SQL injections.
	 *
	 * @param (int) userId
	 * @param (varchar) country
	 * @return (boolean)
	 */
	public
	function insertUser($userId, $country){
		$sql1 = "INSERT INTO users(user_id,country) values(:userId,:country) 
  		  ON DUPLICATE KEY UPDATE user_id = :userId";
		$q1 = $this->db->prepare($sql1);
		$q1->execute(array(':userId'=>$userId, ':country'=>$country));
		return true;
	}

	/**
	 * 
	 * The rest of the JSON data is inserted in the message table. The tables users and message have a 1 to Many        * relationship
	 * PDO is used to help against 1st order SQL injections.
	 *
	 * @param (datetime) dateTime
	 * @param (varchar) currencyFrom
	 * @param (varchar) currencyTo
	 * @param (decimal(11,2)) amountSell
	 * @param (decimal(11,2)) amountBuy
	 * @param (decimal(8,5)) rate
	 * @param (int) messageUserFK
	 * @return (boolean) 
	 */
	public
	function insertData($dateTime, $currencyFrom, $currencyTo, $amountSell, $amountBuy, $rate, $messageUserFK){
		$sql2 = "INSERT INTO message(date_time,currency_from, currency_to, amount_sell, amount_buy, rate, message_user_FK) values(:dateTime,:currencyFrom, :currencyTo, :amountSell, :amountBuy, :rate, :messageUserFK)";
		$q2 = $this->db->prepare($sql2);
		$q2->execute(array(':dateTime'=>$dateTime,':currencyFrom'=>$currencyFrom,':currencyTo'=>$currencyTo, ':amountSell'=>$amountSell, ':amountBuy'=>$amountBuy, ':rate'=>$rate,':messageUserFK'=>$messageUserFK));
		return true;
	}


	/**
	 * 
	 * mapData prepares the data needed by Map Graph which is the list of countries and total number of messages
	 * originating from them.
	 * @return (two-dimensional array)
	 */
	public
	function mapData(){
		foreach($this->db->query('SELECT users.country, COUNT(message.message_user_FK) AS messages
              FROM message JOIN users ON message.message_user_FK=users.user_id GROUP BY users.country') as $row) {
			$sup_array[] = array("'".$row['country']."'",$row['messages']);
		}

		return $sup_array;
	}

	/**
	 * 
	 * calibroData prepares the data needed by Calibro Graph which is the list of latest messages from each country,   * the names of the currencies and their exchange rate.
	 * 
	 * @return (two-dimensional array)
	 */
	public
	function calibroData(){
		foreach($this->db->query('SELECT users.country, message.currency_from, message.currency_to, message.rate, MAX(message.date_time) FROM users JOIN message 
             ON users.user_id = message.message_user_FK  GROUP BY users.country;') as $row) {
			$sup_array2[] = array($row['country'],$row['currency_from'],$row['currency_to'],$row['rate']);
		}

		return $sup_array2;
	}

}

?>