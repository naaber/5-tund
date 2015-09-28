<?php
	//functions.php
	//siia tulevad funktsioonid
	
	//loome AB ühenduse
	require_once("../config_global.php");
	$database = "if15_naaber";
	
	//paneme sessiooni serveris tööle, saame kasutada SESSION[]
	session_start();
	
	function loginUser($email, $hash){
		
		//muutuja väljaspool funktsiooni
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, email FROM user_sample WHERE email=? AND password=?");
		$stmt->bind_param("ss", $email, $hash);
		$stmt->bind_result($id_from_db, $email_from_db);
		$stmt->execute();
		if($stmt->fetch()) {
			
			//sessioon, salvestatakse serveris
			$_SESSION["logged_in_user_id"] = $id_from_db;
			$_SESSION["logged_in_user_email"] = $id_from_db;
			
			//suuname kasutaja teisele lehele
			header("Location: data.php");
			
		}else{
			echo "Wrong credentials!";
		}
		$stmt->close();
		
		$mysqli->close();
		
	}
	
	
	
	function createUser($create_email, $hash){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli ->prepare("INSERT INTO user_sample (email, password) VALUES (?,?)");
		$stmt->bind_param ("ss", $create_email, $hash);
		$stmt->execute();
		$stmt->close();
		
		$mysqli->close();

	}
	
	function createCarPlate($plate, $color){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli ->prepare("INSERT INTO car_plates (user_id, number_plate, color) VALUES (?,?,?)");
		// i - user_id INT
		$stmt->bind_param ("iss",$_SESSION["logged_in_user_id"], $plate, $color);
		
		$message ="";
		
		// kui õnnestub, siis tõene, kui viga, siis else
		if($stmt->execute()){
			//õnnestus
			$message = "Edukalt andmebaasi salvestatud!";
		}
		
		$stmt->close();
		$mysqli->close();
		
		//saadan sõnumi tagasi
		return $message;
		
	}
	
	function getAllData(){
		
		$mysqli = new mysqli($GLOBALS["servername"], $GLOBALS["server_username"], $GLOBALS["server_password"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT id, user_id, number_plate, color FROM car_plates");
		$stmt->bind_result($id_from_db, $user_id_from_db, $number_plate_from_db, $color_from_db);
		$stmt->execute();
		
		// iga rea kohta, mis on andmebaasis, teeme midagi
		while ($stmt->fetch()){
			//saime andmed kätte
			
			//SIIT JÄTKAME
		}
		
		$stmt->close();
		$mysqli->close();
	}

?>