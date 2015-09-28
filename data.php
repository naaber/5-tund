<?php

	require_once("functions.php");
	
	//kui kasutaja on sisse logitud, suuna teisele lehele
	//kontrollin, kas sessiooni muutuja on olemas
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	
	//aadressireale tekkis ?logout=1
	if(isset($_GET["logout"])){
		
		//kustutame sessiooni muutujad
		session_destroy();
		header("Location: login.php");
		
	}
	
	$car_plate = $color = $m = "";
	$car_plate_error = $color_error = "";
	
	//valideerida väli
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {
	
		if(isset($_POST["add_car_plate"])){
			
			if ( empty($_POST["car_plate"]) ) {
				$car_plate_error = "Auto nr on kohustuslik";
			}else{
				$car_plate = cleanInput($_POST["car_plate"]);
			}
			
			if ( empty($_POST["color"]) ) {
				$color_error = "Auto värv on kohustuslik";
			}else{
				$color = cleanInput($_POST["color"]);
			}
		
			if($car_plate_error == "" && $color_error == ""){
				// m on message, mille saadame function.php failist
				$m = createCarPlate($car_plate, $color);
				
				if($m != ""){
					$car_plate = "";
					$color = "";
				}
			}
		}
	}
	
	function cleanInput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	
	//küsime tabeli kujul andmed
	getAllData();
	
?>

Tere, <?=$_SESSION["logged_in_user_email"];?> <a href="?logout=1">Logi välja</a>

<h2>Lisa uus</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<label for="car_plate">Autor nr </label>
	<input name="car_plate" type="text" value="<?php echo $car_plate; ?>">* <?php echo $car_plate_error; ?><br><br>
	<label for="color">Värv</label>
  	<input name="color" type="text" value="<?php echo $color; ?>">* <?php echo $color_error; ?><br><br>
  	<input type="submit" name="add_car_plate" value="Lisa">
	<p style="color:green;"><?=$m;?></p>
</form>