<?php 
	ini_set('display_errors', 1);
	header('Content-Type: application/json');
	require_once("functions.php");

	$mysqli = dbConnect();

	if(isset($_GET['setAccess']) && isset($_GET['greenhouse_id']) && isset($_GET['customer_id']) && isset($_GET['access_type']) && is_valid_token($mysqli,$_GET['token'])){
		echo json_encode(dbInsert($mysqli,"INSERT INTO `access`(`greenhouse_id`, `customer_id`, `access_type`) VALUES ('".$_GET['greenhouse_id']."','".$_GET['customer_id']."','".$_GET['access_type']."')"));
	}

	else if(isset($_GET['setControl']) && isset($_GET['greenhouse_id']) && isset($_GET['customer_id']) && is_valid_token($mysqli,$_GET['token'])){
		$sql = "INSERT INTO `control`(`greenhouse_id`, `customer_id` ";

		if(isset($_GET['moist'])) $sql .= ",`moist` ";
		if(isset($_GET['light'])) $sql .= ",`light` ";
		if(isset($_GET['hum'])) $sql .= ",`hum` ";
		if(isset($_GET['temp'])) $sql .= ",`temp` ";
		if(isset($_GET['wind'])) $sql .= ",`wind` ";
		if(isset($_GET['co2'])) $sql .= ",`co2` ";
		if(isset($_GET['ph'])) $sql .= ",`ph` ";
		if(isset($_GET['ec'])) $sql .= ",`ec` ";
		
		$sql .= ", `date`) VALUES (".$_GET['greenhouse_id'].", ".$_GET['customer_id'];

		if(isset($_GET['moist'])) $sql .= ", ".$_GET['moist'];
		if(isset($_GET['light'])) $sql .= ", ".$_GET['light'];
		if(isset($_GET['hum'])) $sql .= ", ".$_GET['hum'];
		if(isset($_GET['temp'])) $sql .= ", ".$_GET['temp'];
		if(isset($_GET['wind'])) $sql .= ", ".$_GET['wind'];
		if(isset($_GET['co2'])) $sql .= ", ".$_GET['co2'];
		if(isset($_GET['ph'])) $sql .= ", ".$_GET['ph'];
		if(isset($_GET['ec'])) $sql .= ", ".$_GET['ec'];
		if(isset($_GET['date'])) 
			$sql .= ", ".$_GET['date'];
		else
			$sql .= ", ".time();
		$sql .= ")";
		//echo($sql);
		echo json_encode(dbInsert($mysqli, $sql));
	}
	else if(isset($_GET['setCustomer']) && isset($_GET['name']) && isset($_GET['phone_number']) && isset($_GET['email']) && isset($_GET['password']) && is_valid_token($mysqli,$_GET['token'])){
		$sql = "INSERT INTO `customer`(`name`, `phone_number`, `email`, `password`) VALUES ('".$_GET['name']."','".$_GET['phone_number']."','".$_GET['email']."','".md5($_GET['password'])."')";
		echo json_encode(dbInsert($mysqli, $sql));
	}
	else if(isset($_GET['setGreenhouse']) && isset($_GET['name']) && isset($_GET['address']) && isset($_GET['area']) && isset($_GET['date']) && isset($_GET['width']) && isset($_GET['length']) && is_valid_token($mysqli,$_GET['token'])){
		$sql = "INSERT INTO `greenhouse`(`name`, `address`, `area`, `date`, `width`, `length`) VALUES ('".$_GET['name']."', '".$_GET['address']."', '".$_GET['area']."', '".$_GET['date']."', '".$_GET['width']."', '".$_GET['length']."')";
		echo json_encode(dbInsert($mysqli, $sql));
	}
	else if(isset($_GET['setNotification']) && isset($_GET['importance']) && isset($_GET['date']) && isset($_GET['notification']) && isset($_GET['greenhouse_id']) && isset($_GET['customer_id']) && is_valid_token($mysqli,$_GET['token'])){
		$sql = "INSERT INTO `notification`(`importance`, `date`, `notification`, `greenhouse_id`, `customer_id`) VALUES ('".$_GET['importance']."', '".$_GET['date']."', '".$_GET['notification']."', '".$_GET['greenhouse_id']."', '".$_GET['customer_id']."')";
		echo json_encode(dbInsert($mysqli, $sql));
	}
	else if(isset($_GET['setSensorList']) && isset($_GET['sensor_id']) && isset($_GET['greenhouse_id']) && isset($_GET['sens_type']) && isset($_GET['x']) && isset($_GET['y']) && isset($_GET['install_date']) && is_valid_token($mysqli,$_GET['token'])){
		$sql = "INSERT INTO `sensor_list`(`sensor_id`, `greenhouse_id`, `sens_type`, `x`, `y`, `install_date`) VALUES ('".$_GET['sensor_id']."', '".$_GET['greenhouse_id']."', '".$_GET['sens_type']."', '".$_GET['x']."', '".$_GET['y']."', '".$_GET['install_date']."')";
		echo json_encode(dbInsert($mysqli, $sql));
	}
	else if(isset($_GET['setSensorData']) && isset($_GET['sensor_id']) && isset($_GET['data']) && isset($_GET['date']) && is_valid_token($mysqli,$_GET['token'])){
		$sql = "INSERT INTO `sensor_data`(`sensor_id`, `data`, `date`) VALUES ('".$_GET['sensor_id']."', '".$_GET['data']."', '".$_GET['date']."')";
		echo json_encode(dbInsert($mysqli, $sql));
	}
	else if(isset($_GET['setSettings']) && isset($_GET['greenhouse_id']) && is_valid_token($mysqli,$_GET['token'])){
		$sql = "INSERT INTO `settings`(`greenhouse_id`";

		if(isset($_GET['moist_min'])) $sql .= ",`moist_min` ";
		if(isset($_GET['moist_max'])) $sql .= ",`moist_max` ";
		if(isset($_GET['light_min'])) $sql .= ",`light_min` ";
		if(isset($_GET['light_max'])) $sql .= ",`light_max` ";
		if(isset($_GET['hum_min'])) $sql .= ",`hum_min` ";
		if(isset($_GET['hum_max'])) $sql .= ",`hum_max` ";
		if(isset($_GET['temp_min'])) $sql .= ",`temp_min` ";
		if(isset($_GET['temp_max'])) $sql .= ",`temp_max` ";
		if(isset($_GET['wind_min'])) $sql .= ",`wind_min` ";
		if(isset($_GET['wind_max'])) $sql .= ",`wind_max` ";
		if(isset($_GET['co2_min'])) $sql .= ",`co2_min` ";
		if(isset($_GET['co2_max'])) $sql .= ",`co2_max` ";
		if(isset($_GET['ph_min'])) $sql .= ",`ph_min` ";
		if(isset($_GET['ph_max'])) $sql .= ",`ph_max` ";
		if(isset($_GET['ec_min'])) $sql .= ",`ec_min` ";
		if(isset($_GET['ec_max'])) $sql .= ",`ec_max` ";
		
		$sql .= ", `date`) VALUES (".$_GET['greenhouse_id'];

		if(isset($_GET['moist_min'])) $sql .= ", ".$_GET['moist_min'];
		if(isset($_GET['moist_max'])) $sql .= ", ".$_GET['moist_max'];
		if(isset($_GET['light_min'])) $sql .= ", ".$_GET['light_min'];
		if(isset($_GET['light_max'])) $sql .= ", ".$_GET['light_max'];
		if(isset($_GET['hum_min'])) $sql .= ", ".$_GET['hum_min'];
		if(isset($_GET['hum_max'])) $sql .= ", ".$_GET['hum_max'];
		if(isset($_GET['temp_min'])) $sql .= ", ".$_GET['temp_min'];
		if(isset($_GET['temp_max'])) $sql .= ", ".$_GET['temp_max'];
		if(isset($_GET['wind_min'])) $sql .= ", ".$_GET['wind_min'];
		if(isset($_GET['wind_max'])) $sql .= ", ".$_GET['wind_max'];
		if(isset($_GET['co2_min'])) $sql .= ", ".$_GET['co2_min'];
		if(isset($_GET['co2_max'])) $sql .= ", ".$_GET['co2_max'];
		if(isset($_GET['ph_min'])) $sql .= ", ".$_GET['ph_min'];
		if(isset($_GET['ph_max'])) $sql .= ", ".$_GET['ph_max'];
		if(isset($_GET['ec_min'])) $sql .= ", ".$_GET['ec_min'];
		if(isset($_GET['ec_max'])) $sql .= ", ".$_GET['ec_max'];

		if(isset($_GET['date'])) 
			$sql .= ", ".$_GET['date'];
		else
			$sql .= ", ".time();
		$sql .= ")";
		echo json_encode(dbInsert($mysqli, $sql));
	}
	else if(isset($_GET['setSystemLog']) && isset($_GET['importance']) && isset($_GET['greenhouse_id']) && isset($_GET['customer_id']) && isset($_GET['log']) && isset($_GET['code']) && is_valid_token($mysqli,$_GET['token'])){
		$sql = "INSERT INTO `system_log`(`importance`, `greenhouse_id`, `customer_id`, `log`,`code`) VALUES ('".$_GET['importance']."', '".$_GET['greenhouse_id']."', '".$_GET['customer_id']."', '".$_GET['log']."', '".$_GET['code']."')";
		echo json_encode(dbInsert($mysqli, $sql));
	}
	else if(isset($_GET['setRelayState']) && isset($_GET['relay_id']) && isset($_GET['greenhouse_id']) && isset($_GET['state']) && is_valid_token($mysqli,$_GET['token'])){
		$sql = "INSERT INTO `relay`(`relay_id`, `greenhouse_id`, `state`, `time`) VALUES ('".$_GET['relay_id']."', '".$_GET['greenhouse_id']."', '".$_GET['state']."', '".time()."')";
		echo json_encode(dbInsert($mysqli, $sql));
	}
	dbClose($mysqli);

 ?>	
