<?php 
	//ini_set('display_errors', 1);
	header('Content-Type: application/json');
	require_once("functions.php");

	$mysqli = dbConnect();
	if(isset($_GET['checkUpdate']) && isset($_GET['greenhouse_id']) && isset($_GET['last_update']) && is_valid_token($mysqli,$_GET['token']) ){
		$sql = "SELECT `updated` FROM `error_codes` ORDER BY `code` DESC LIMIT 1";

		$error_codes_update = (int)dbSelect($mysqli,$sql)[0]['updated'];
		$sql = "SELECT `date` FROM `settings` WHERE `greenhouse_id` = ".$_GET['greenhouse_id']." ORDER BY `date` DESC LIMIT 1";

		$settings_update = (int)dbSelect($mysqli,$sql)[0]['date'];

		if((int)$_GET['last_update'] > $error_codes_update || (int)$_GET['last_update'] > $settings_update)
			echo json_encode([1]);
	}
	else if(isset($_GET['getSensorData']) && isset($_GET['sensor_id']) && is_valid_token($_GET['token']) && is_valid_token($mysqli,$_GET['token']) ){
		$limit = (isset($_GET['limit'])) ? $_GET['limit'] : 15;
	#	echo $limit;
		$from = (isset($_GET['from'])) ? $_GET['from'] : 0;
		$to = (isset($_GET['to'])) ? $_GET['to'] : 99999999999999999999;
	#	echo "string";
		echo json_encode(selectSensorData($mysqli,$_GET['sensor_id'], $limit, $from, $to));
	}
	else if(isset($_GET['getSensorInfo']) && is_valid_token($mysqli,$_GET['token'])){
		$sql = "SELECT * FROM `sensor_list` WHERE 1";
		if(isset($_GET['sensor_id'])) $sql .= " && sensor_id = ".$_GET['sensor_id'];
		if(isset($_GET['greenhouse_id'])) $sql .= " && greenhouse_id = ".$_GET['greenhouse_id'];
		if(isset($_GET['sens_type'])) $sql .= " && sens_type = ".$_GET['sens_type'];
		
		echo json_encode(dbSelect($mysqli,$sql));
	}
	else if(isset($_GET['getGreenhouseInfo']) && is_valid_token($mysqli,$_GET['token'])){
		$sql = "SELECT * FROM `greenhouse` WHERE 1";
		if(isset($_GET['greenhouse_id'])) $sql .= " && greenhouse_id = ".$_GET['greenhouse_id'];
		
		echo json_encode(dbSelect($mysqli,$sql));
	}
	else if(isset($_GET['getAccessInfo']) && is_valid_token($mysqli,$_GET['token'])){
		$sql = "SELECT * FROM `access` WHERE 1";
		if(isset($_GET['greenhouse_id'])) $sql .= " && greenhouse_id = ".$_GET['greenhouse_id'];
		if(isset($_GET['customer_id'])) $sql .= " && customer_id = ".$_GET['customer_id'];
		
		echo json_encode(dbSelect($mysqli,$sql));
	}
	else if(isset($_GET['getCustomerInfo']) && is_valid_token($mysqli,$_GET['token'])){
		$sql = "SELECT * FROM `customer` WHERE 1";
		if(isset($_GET['email'])) $sql .= " && email = ".$_GET['email'];
		if(isset($_GET['phone_number'])) $sql .= " && phone_number = ".$_GET['phone_number'];
		
		echo json_encode(dbSelect($mysqli,$sql));
	}
	else if(isset($_GET['getSystemLog']) && is_valid_token($mysqli,$_GET['token'])){
		$sql = "SELECT * FROM `system_log` WHERE 1";
		if(isset($_GET['greenhouse_id'])) $sql .= " && greenhouse_id = ".$_GET['greenhouse_id'];
		if(isset($_GET['customer_id'])) $sql .= " && customer_id = ".$_GET['customer_id'];
		if(isset($_GET['limit'])) $sql .= " LIMIT ".$_GET['limit'];
		
		echo json_encode(dbSelect($mysqli,$sql));
	}
	else if(isset($_GET['getNotifcation']) && is_valid_token($mysqli,$_GET['token'])){
		$sql = "SELECT * FROM `system_log` WHERE 1";
		if(isset($_GET['greenhouse_id'])) $sql .= " && greenhouse_id = ".$_GET['greenhouse_id'];
		if(isset($_GET['customer_id'])) $sql .= " && customer_id = ".$_GET['customer_id'];
		if(isset($_GET['limit'])) $sql .= " LIMIT ".$_GET['limit'];
		
		echo json_encode(dbSelect($mysqli,$sql));
	}
	else if(isset($_GET['getSettings']) && is_valid_token($mysqli,$_GET['token'])){
		$sql = "SELECT * FROM `settings` WHERE 1";
		if(isset($_GET['greenhouse_id'])) $sql .= " && greenhouse_id = ".$_GET['greenhouse_id'];
		$sql .= " ORDER BY `date` DESC LIMIT 1";
		echo json_encode(dbSelect($mysqli,$sql));
	}
	else if(isset($_GET['getControl']) && is_valid_token($mysqli,$_GET['token'])){
		$sql = "SELECT * FROM `control` WHERE 1";
		if(isset($_GET['greenhouse_id'])) $sql .= " && greenhouse_id = ".$_GET['greenhouse_id'];
		if(isset($_GET['customer_id'])) $sql .= " && customer_id = ".$_GET['customer_id'];
		if(isset($_GET['changed'])) $sql .= " && changed = ".$_GET['customer_id'];
		
		echo json_encode(dbSelect($mysqli,$sql));
	}
	else if(isset($_GET['getErrorCodes']) && is_valid_token($mysqli,$_GET['token'])){
		$sql = "SELECT * FROM `error_codes` WHERE 1";
		if(isset($_GET['code'])) $sql .= " && code = ".$_GET['code'];
		$get = dbSelect($mysqli,$sql);
		//print_r($get);
		$new_get = [];
		foreach ($get as $key => $value) {
			#print_r($value);   "[$value['type'],$value['message']]"
			$new_get[$value['code']] = array('type' => $value['type'], 'message' => $value['message']);
		}
		//print_r($new_get);
		echo json_encode($new_get);
	}
	dbClose($mysqli);

 ?>	
