<!DOCTYPE html>
<?php 
	session_start();
	$name = "";
	$userid = "";
	if(array_key_exists('name', $_SESSION) && array_key_exists('userid', $_SESSION)){
		$name = $_SESSION['name'];
		$userid = $_SESSION['userid'];
	}
		
?>

<html lang="en">
<head>  
	<?php $page_title = "Add Restaurant" ?>
	<?php include("includes/external.php");?>
</head>

<body style="background:linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('img/background01.jpg');">
<?php include("includes/navigation.php");?>
<div class="spacer"></div>
<div class="container">
	<div class="row">
		<div class="spacer"></div>
		<h2 style="color:white;">Add New Restaurant</h2>
			
		<div class="col-md-12 column">
			<form id="newRestoForm" name="formID" method="post" action="" role="form">
				<!-- Restaurant Name -->
				<div class="row">
					<div class="form-group-xs">
						<label for="input-name" style="color:white;">Restaurant Name</label>
						<input name ="input-name" type="name" class="form-control" id="input-name" style="color:white;" required autofocus/>
					</div>
				</div>
				<!-- Cuisine Type -->
				<div class="row">
					<div class="form-group-xs">
						<label for="input-cuisine" style="color:white;">Type of Cuisine</label>
						<select name = "input-cuisine" id = "input-type" method= "post" class="form-control">
						<!-- FETCH ALL POSSIBLE CUISINE TYPES IN HERE -->
							<option>Other</option>
							<option>Breakfast</option>
							<option>Middle Eastern</option>
							<option>Sandwiches</option>
							<option>Mexican</option>
							<option>Indian</option>
							<option>Korean</option>
							<option>Chinese</option>
							<option>Italian</option>
							<option>Fine Dining</option>
						</select>
					</div>
				</div>
				<!-- URL -->
				<div class="row">
					<div class="form-group-xs">
						 <label for="input-url" style="color:white;">Website URL</label>
						 <input name ="input-url" type="text" class="form-control" id="input-url" style="color:white;"/>
					</div>
				</div>
				<!-- Open Date -->
				<div class="row">
					<div class="form-group-xs">
						 <label for="input-open-date" style="color:white;">Opening Date (YYYY-MM-DD)</label>
						 <input name ="input-open-date" type="text" class="form-control" id="input-open-date" style="color:white;"required/>
					</div>
				</div>
				<!-- Manager Name -->
				<div class="row">
					<div class="form-group-xs">
						 <label for="input-mng" style="color:white;">Manager Name</label>
						 <input name ="input-mng" type="text" class="form-control" id="input-mng-name" style="color:white;"/>
					</div>
				</div>
				<!-- Phone Number -->
				<div class="row">
					<div class="form-group-xs">
						 <label for="input-phone" style="color:white;">Phone Number (e.g. 16135550123)</label>
						 <input name ="input-phone" type="text" class="form-control" id="input-phone" style="color:white;"/>
					</div>
				</div>
				<!-- Street Address -->
				<div class="row">
					<div class="form-group-xs">
						 <label for="input-address" style="color:white;">Street Address</label>
						 <input name ="input-address" type="text" class="form-control" id="input-address" style="color:white;"/>
					</div>
				</div>
				<!-- Hours Open -->
				<div class="row">
					<div class="form-group-xs" style="color:white;">
						 <label for="input-open">Opening Hour (e.g. 0600)</label>
						 <input name ="input-open" type="text" class="form-control" id="input-hours-open" style="color:white;"/>
					</div>
				</div>
				<!-- Hours Closed -->
				<div class="row">
					<div class="form-group-xs">
						 <label for="input-close" style="color:white;">Closing Hour (e.g. 2100)</label>
						 <input name ="input-close" type="text" class="form-control" id="input-hours-closed" style="color:white;"/>
					</div>
				</div>
				<br>
				<div class="text-center">
					<button name="register" id="register" type="submit" class="button solid burgundy"><strong>Add Restaurant</strong></button>
				</div>
			</form>
			<?php
				if(array_key_exists('input-name', $_POST) && array_key_exists('input-cuisine', $_POST) && array_key_exists('input-url', $_POST) &&
				array_key_exists('input-open-date', $_POST) && array_key_exists('input-mng', $_POST) && array_key_exists('input-phone', $_POST) &&
				array_key_exists('input-address', $_POST) && array_key_exists('input-open', $_POST) && array_key_exists('input-close', $_POST) ){
					require('connect.php');
					$name = $_POST['input-name'];
					$url = $_POST['input-url'];
					$cuisine = $_POST['input-cuisine'];
					if($cuisine == "Other")
						$cuisine = 0;
					else if($cuisine == "Mexican")
						$cuisine = 1;
					else if($cuisine == "Indian")
						$cuisine = 2;
					else if($cuisine == "Korean")
						$cuisine = 3;
					else if($cuisine == "Chinese")
						$cuisine = 4;
					else if($cuisine == "Italian")
						$cuisine = 5;
					else if($cuisine == "Fine Dining")
						$cuisine = 6;
					else if($cuisine == "Breakfast")
						$cuisine = 7;
					else if($cuisine == "Middle Eastern")
						$cuisine = 8;
					else if ($cuisine == "Sandwiches")
						$cuisine = 9;
					$r1 = pg_query("SELECT * FROM Restaurant R WHERE R.name = '$name'");
					$num = pg_num_rows($r1);
					$r1 = pg_fetch_assoc($r1);
					$rId = $r1['restaurant_id']; 
					if($num == 0){
						pg_query("INSERT INTO Restaurant(name, cuisine, url)
							VALUES('$name', $cuisine, '$url')
						");
						$r1 = pg_query("SELECT * FROM Restaurant R WHERE R.name = '$name'");
						$r1 = pg_fetch_assoc($r1);
						$rId = $r1['restaurant_id']; 
					}
					$first_open = $_POST['input-open-date'];
					$mng = $_POST['input-mng'];
					$phone = $_POST['input-phone'];
					$address = $_POST['input-address'];
					$r1 = pg_query("SELECT * FROM Location WHERE street_address = '$address'");
					$num = pg_num_rows($r1);
					if($num == 0){
						$open = $_POST['input-open'];
						$close = $_POST['input-close']; 
						pg_query("INSERT INTO Location(first_open_date, manager_name, phone_number, street_address, hour_open, hour_close, restaurant_id)
							VALUES('$first_open', '$mng', '$phone', '$address', $open, $close, $rId);
							");
						$result = pg_query("SELECT * FROM Location L WHERE L.street_address = '$address'");
						$result = pg_fetch_assoc($result);
						$location_id = $result['location_id'];
						echo "<p align='center' style='color:white;'>You have successfully added the restaurant.<a href= 'restaurant.php?id=$location_id'> Continue </a></p>";
					}
					else {
						$result = pg_query("SELECT * FROM Location WHERE Location.street_address = '$address'");
						$location_id = $result['location_id'];
						echo "LOCATION ID: $location_id";
						echo "<p align='center' style='color:white;'>That <a href='restaurant.php?id=$location_id'>location</a> is already in our database!</p>";
					}
				}

			?>
		</div>
	</div>
</div>
<div class="spacer"></div>
<?php include("includes/footer.php");?>
</body>
</html>