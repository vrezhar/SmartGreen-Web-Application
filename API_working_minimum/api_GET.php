<?php 
	//ini_set('display_errors', 1);
	header('Content-Type: application/json');
	header("Access-Control-Allow-Origin: *");
	require_once("functions.php");

	$mysqli = dbConnect();

	if(isset($_GET['getSensorData']) && isset($_GET['sensor_id'])){
		$limit = (isset($_GET['limit'])) ? $_GET['limit'] : 15;
		$from = (isset($_GET['from'])) ? $_GET['from'] : 0;
		$to = (isset($_GET['to'])) ? $_GET['to'] : 99999999999999999999;
		//echo "string";
		echo json_encode(selectSensorData($mysqli,$_GET['sensor_id'], $limit, $from, $to));
	}
	else if(isset($_GET['getSensorInfo'])){
		$sql = "SELECT * FROM `sensor_list` WHERE 1";
		if(isset($_GET['sensor_id'])) $sql .= " && sensor_id = ".$_GET['sensor_id'];
		if(isset($_GET['greenhouse_id'])) $sql .= " && greenhouse_id = ".$_GET['greenhouse_id'];
		if(isset($_GET['sens_type'])) $sql .= " && sens_type = ".$_GET['sens_type'];
		
		echo json_encode(dbSelect($mysqli,$sql));
	}
	else if(isset($_GET['getGreenhouseInfo'])){
		$sql = "SELECT * FROM `greenhouse` WHERE 1";
		if(isset($_GET['greenhouse_id'])) $sql .= " && greenhouse_id = ".$_GET['greenhouse_id'];
		
		echo json_encode(dbSelect($mysqli,$sql));
	}
	else if(isset($_GET['getAccessInfo'])){
		$sql = "SELECT * FROM `access` WHERE 1";
		if(isset($_GET['greenhouse_id'])) $sql .= " && greenhouse_id = ".$_GET['greenhouse_id'];
		if(isset($_GET['customer_id'])) $sql .= " && customer_id = ".$_GET['customer_id'];
		
		echo json_encode(dbSelect($mysqli,$sql));
	}
	else if(isset($_GET['getCustomerInfo'])){
		$sql = "SELECT * FROM `customer` WHERE 1";
		if(isset($_GET['email'])) $sql .= " && email = ".$_GET['email'];
		if(isset($_GET['phone_number'])) $sql .= " && phone_number = ".$_GET['phone_number'];
		
		echo json_encode(dbSelect($mysqli,$sql));
	}
	else if(isset($_GET['getSystemLog'])){
		$sql = "SELECT * FROM `system_log` WHERE 1";
		if(isset($_GET['greenhouse_id'])) $sql .= " && greenhouse_id = ".$_GET['greenhouse_id'];
		if(isset($_GET['customer_id'])) $sql .= " && customer_id = ".$_GET['customer_id'];
		if(isset($_GET['limit'])) $sql .= " && LIMIT = ".$_GET['limit'];
		
		echo json_encode(dbSelect($mysqli,$sql));
	}
	else if(isset($_GET['getSettings'])){
		$sql = "SELECT * FROM `settings` WHERE 1";
		if(isset($_GET['greenhouse_id'])) $sql .= " && greenhouse_id = ".$_GET['greenhouse_id'];
		if(isset($_GET['changed'])) $sql .= " && changed = ".$_GET['customer_id'];
		
		echo json_encode(dbSelect($mysqli,$sql));
	}
	else if(isset($_GET['getControl'])){
		$sql = "SELECT * FROM `control` WHERE 1";
		if(isset($_GET['greenhouse_id'])) $sql .= " && greenhouse_id = ".$_GET['greenhouse_id'];
		if(isset($_GET['customer_id'])) $sql .= " && customer_id = ".$_GET['customer_id'];
		if(isset($_GET['changed'])) $sql .= " && changed = ".$_GET['customer_id'];
		
		echo json_encode(dbSelect($mysqli,$sql));
	}
	else if(isset($_GET['getErrorCodes'])){
		$sql = "SELECT * FROM `error_codes` WHERE 1";
		if(isset($_GET['code'])) $sql .= " && code = ".$_GET['code'];
		
		echo json_encode(dbSelect($mysqli,$sql));
	}
	dbClose($mysqli);

 ?>	
