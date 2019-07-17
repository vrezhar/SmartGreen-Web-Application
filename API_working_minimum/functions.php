<?php 
	session_start();
	function dbConnect(){
		$mysqli = new mysqli('localhost', 'webinar1_greenhouse', 'smartgreen2018', 'webinar1_smartgreen_demo');

		if ($mysqli->connect_errno) {
		    return 0;
		}
		return $mysqli;
	}
	function dbInsert($mysqli, $sql){
		if (!$mysqli->real_query($sql)) {
			return 0;
		}
		return 1;
	}
	function dbSelect($mysqli, $sql){
		if (!$result = $mysqli->query($sql)) {
		    return 0;
		}
		$ret = [];
		while ($actor = $result->fetch_assoc()) {
			array_push($ret,$actor);
		}
		$result->free();
		return $ret;
	}
	function dbClose($mysqli){
		$mysqli->close();
		return 1;
	}
	function isLogin(){	
		if(isset($_SESSION['user']) && isset($_SESSION['pass']) && strlen($_SESSION['user']) > 1 && strlen($_SESSION['pass']) == 32 && isset($_SESSION['isUser']))
			return 1;
		else
			return 0;	
	}
	function logout(){
		session_unset(); 
		session_destroy(); 
	}
	function make_seed()
	{
	    list($usec, $sec) = explode(' ', microtime());
	    return $sec + $usec * 1000000;
	}
	function generateKey ($length) {
	    $possible = "0123456789ABCDEFGHIJKLMNOPQRESTUVWXYZ"; // allowed chars in the password
	     if ($length == "" OR !is_numeric($length)){
	      $length = 8; 
	     }
	     srand(make_seed());

	     $i = 0; 
	     $key = "";    
	     while ($i < $length) { 
	      $char = substr($possible, rand(0, strlen($possible)-1), 1);
	      if (!strstr($key, $char)) { 
	       $key .= $char;
	       $i++;
	       }
	      }
	     return $key;

	}


	function selectSensorData($mysqli, $sensor_id, $limit = 15, $from = 0, $to = 99999999999999999999){
		//return "SELECT * FROM `sensor_data` WHERE `sensor_id` = $sensor_id AND `date` >= $from AND `date` <= $to LIMIT $limit";
		return dbSelect($mysqli, "SELECT * FROM `sensor_data` WHERE `sensor_id` = $sensor_id AND `date` >= $from AND `date` <= $to ORDER BY `sensor_data_id` DESC LIMIT $limit");
	}

	function is_valid_token($mysqli, $token){
		if(!empty(dbSelect($mysqli, "SELECT * FROM `tokens` WHERE `token` = '$token'")))
			return 1;
		else
			return 0;
	}