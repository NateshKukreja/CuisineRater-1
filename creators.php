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
	<?php $page_title = "Menu Item" ?>
	<?php include("includes/external.php");?>
</head>

<body style="background:linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('img/background05.jpg'); color:white;">
<?php include("includes/navigation.php");?>
<div class="spacer"></div>
<div class="container">
	<div class="row clearfix">
		<div class="spacer"></div>
			<h2 class="white">Creators</h2>
			
			<div class="col-md-4">
				<div class="thumbnail" style="height:500px">
				<a href="">
				<div class="cropped-img" style="background-image:url('img/aury.jpg'); min-height:300px" /> </div>

				<div class="caption">
					<h2>Aury Rukazana</a></h2>
					<p>
						Aury was in charge of the front-end, interactions and event-triggering. 
					</p>
				</div>
			</div>

		
		<div class="col-md-4">
			<div class="thumbnail" style="height:500px">
			<a href="">
			<div class="cropped-img" style="background-image:url('img/daniel.jpg'); min-height:300px" /> </div>

			<div class="caption">
				<h2>Daneyal Siddiqui</a></h2>
				<p>
					Daneyal is very experienced with postgreSQL and pgadmin, was in charge to create and maintain the database.
				</p>
			</div>
		</div>
			
		<div class="col-md-4">
			<div class="thumbnail" style="height:500px">
			<a href="https://github.com/mshanti">
			<div class="cropped-img" style="background-image:url('img/natesh.png'); min-height:300px"/> </div>
				
			<div class="caption">
				<h2>Natesh Kukreja</a></h2>
				<p>
					Natesh is responsible for the connection to the Cuisine Rater database.
				</p>

			</div>
		</div>
	</div>
</div>	
<div class="spacer"></div>
<?php include("includes/footer.php");?>
</body>
</html>