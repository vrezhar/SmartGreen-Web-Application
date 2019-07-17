<?php 

	//ini_set('display_errors', 1);
	
	header('Content-Type: application/json');
	require_once("functions.php");

	$mysqli = dbConnect();

	if(isset($_GET['username']) && isset($_GET['password'])){

		$user = dbSelect($mysqli, "SELECT * FROM `customer` WHERE `email` = '".$_GET['username']."'");
		#print_r( $user );
		#echo $user[0]['password'];
		#echo "<br>";
		#echo md5( $_GET['password'] );
		if ($user[0]['password'] == md5( $_GET['password'] )){
			$token = generateKey(16);
			#echo $token;
			if(dbInsert($mysqli,"INSERT INTO `tokens` (`token`, `customer_id`, `time`) VALUES ('".$token."','".$user[0]['customer_id']."', '".time()."')"))
				echo json_encode($token);
			else
				echo json_encode(0);
		}else{
			echo json_encode(0);
			header('Location: ../login.php');
		}
	}

	dbClose($mysqli);
 ?>