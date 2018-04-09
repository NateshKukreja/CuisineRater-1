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
	<?php $page_title = "Profile" ?>
	<?php include("includes/external.php");?>

	<script type="text/javascript">
		function popularQueryH() {
			var name = getParameterByName("name");
			document.location.href="popular.php?query=h&extrao=" + name;
		}

		function popularQueryN(higherOrLower) {
			var name = getParameterByName("name");
			document.location.href="popular.php?query=n&extrao=" + name + "&extrat=" + higherOrLower;
		}
	</script>
</head>

<body style="background:linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('img/background02.jpg'); color:white;">
<?php include("includes/navigation.php");?>
<div class="spacer"></div>
<div class="container">
	<div class="row clearfix">
		<div class="col-md-12 column">
			<div class="spacer"></div>
		<?php
			$name = $_GET['name'];
			echo "
			<!-- USER INFO -->
			<h2 class='text-info' style='color:white'>
					<strong>$name</strong>'s Profile
			</h2>";

			require('connect.php');
			$result = pg_query("SELECT * FROM Rater WHERE Rater.name = '$name'");
			$result = pg_fetch_assoc($result);

			if ($result == false) {
				echo "<h3 style='color:white'>Sorry, " . $name . " does not exist in our records!</h3>";
				exit;
			}

			$email = $result['email'];
			$join = $result['join_date'];
			$join = substr($join, 0, -8);
			$type = $result['type_id'];
			$result = pg_query("SELECT description FROM RaterType WHERE RaterType.type_id = $type");
			$result = pg_fetch_assoc($result);
			$type = $result['description'];

			echo "
			
			<div class='row'>
				<div class='col-sm-3'>
					<img src='img/user_Avatar.png' alt='User Avatar' class='img-responsive'><br>
				</div>
				<div class='col-sm-6' style='color:white;'>
					<br>
					<p style='font-size:20px'>Username : $name</p>
					<p style='font-size:20px'>Email: $email</p>
					<p style='font-size:20px'>Join Date: $join</p>
					<p style='font-size:20px'>Type of User: $type</p>
				</div>

			";

			require('connect.php');
			if (strlen(strval($userid)) > 0) {
				$result = pg_query("SELECT use.name FROM Rater use WHERE use.user_id=$userid");
				$result = pg_fetch_array($result);
			} else {
				$result = false;
			}
			if ($result) {
				if ($result[0] == $name) {
					echo "<script type='text/javascript'>
							function deleteUser() {
								var name = getParameterByName('name');
								var result;
								jQuery.ajax({
									type: 'POST',
									url: 'delete-user.php',
									dataType: 'json',
									data: {functionname: 'deleteUser', arguments: [name]},

									success: function(obj, textstatus) {
											if (!('error' in obj)) {
												document.location.href='logout.php';
											} else {
												console.log(obj, error);
											}
										}
								});
							}
						</script>";
					echo "
						<div class='col-sm-3 text-center' style='color:white'>
						<br>";
						if (isset($name))
							echo"
								<a style='margin-bottom:10px' href='logout.php' class='button burgundy solid'><strong>Log out!</strong></a><br>
								<a style='margin-bottom:10px' id='changePassLink' class='button burgundy solid' style='cursor:pointer'><strong>Change Password</strong></a><br>								
								<a style='margin-bottom:10px' onClick='return deleteUser();' href='#' class='button burgundy solid'><strong>Delete your account!</strong></a><br>
						</div>
					</div>
					";
				}
			}
		?>

		</div>
		<div class="col-md-12 column hidden" id="messageBox">
			
		</div>
		<div class="col-md-12 column">

		<!-- RESTAURANT REVIEWS -->
			<h2 style='color:white'>Restaurant Reviews</h2>
			<table class="table" style="margin-top:5px;"> <!-- match margin of H2 next to it -->
				<!-- Header -->
				<thead>
					<tr style='background-color:white;padding:5px;'>
						<?php 
							$name = $_GET['name'];
							$sm = "";
							if (isset($_GET['sm'])) {
								$sm = $_GET['sm'];
							}
							echo "
							<th style='color:#c63939'><a style='margin-left:5px;' href='profile.php?name=$name&sr=date&sm=$sm'>Date</a>&nbsp;&nbsp;</th>
							<th style='color:#c63939'><a href='profile.php?name=$name&sr=name&sm=$sm'>Name</a>&nbsp;&nbsp;</th>
							<th style='color:#c63939'><a href='profile.php?name=$name&sr=food&sm=$sm'>Food</a>&nbsp;&nbsp;</th>
							<th style='color:#c63939'><a href='profile.php?name=$name&sr=mood&sm=$sm'>Mood</a>&nbsp;&nbsp;</th>
							<th style='color:#c63939'><a href='profile.php?name=$name&sr=price&sm=$sm'>Price</a>&nbsp;&nbsp;</th>
							<th style='color:#c63939'><a href='profile.php?name=$name&sr=staff&sm=$sm'>Staff</a>&nbsp;&nbsp;</th>
							<th style='color:#c63939'><a href='profile.php?name=$name&sr=overall&sm=$sm'>Overall</a>&nbsp;&nbsp;</th>
							<th style='color:#c63939'>Comments</th>
							";
						?>
					</tr>
				</thead>
				<!-- All restaurant reviews -->
				<tbody style='color:white'>
				<?php
					$name = $_GET['name'];
					$query = "SELECT rest.name, loc.location_id, rate.food, rate.mood, rate.staff, rate.price, rate.comments, COALESCE((rate.food+rate.mood+rate.staff+rate.price)/4.0, 0) avgRate, rate.post_date
						FROM Rater use
						INNER JOIN Rating rate
							ON use.user_id=rate.user_id
						INNER JOIN Location loc
							ON rate.location_id=loc.location_id
						INNER JOIN Restaurant rest
							ON loc.restaurant_id=rest.restaurant_id
						WHERE use.name='$name'
						ORDER BY ";

					$sortRest = 'date';
					if (isset($_GET['sr'])) {
						$sortRest = $_GET['sr'];
					}
					switch($sortRest) {
						case 'date': default: $query.="rate.post_date DESC"; break;
						case 'name': $query.="rest.name, rate.post_date DESC"; break;
						case 'food': $query.="rate.food DESC, rate.post_date DESC"; break;
						case 'mood': $query.="rate.mood DESC, rate.post_date DESC"; break;
						case 'price': $query.="rate.price DESC, rate.post_date DESC"; break;
						case 'staff': $query.="rate.staff DESC, rate.post_date DESC"; break;
						case 'overall': $query.="avgRate DESC, rate.post_date DESC"; break;
					}

					$result = pg_query($query);
					while($res = pg_fetch_array($result)){
						$restName = $res[0];
						$locationId = $res[1];
						$food = $res[2];
						$mood = $res[3];
						$staff = $res[4];
						$price = $res[5];
						$comment = $res[6];
						$overall = round($res[7], 1);
						$postDate = substr($res[8], 0, -8);

						echo "
								<tr>
									<td width='100px' style='color:white'>$postDate</td>
									<td width='150px' style='color:white'><a href='restaurant.php?id=$locationId'>$restName</a></td>
									<td style='color:white'>$food</td>
									<td style='color:white'>$mood</td>
									<td style='color:white'>$price</td>
									<td style='color:white'>$staff</td>
									<td style='color:white'>$overall</td>
									<td style='color:white'>$comment</td>
								</tr>
								";
					}
				?>
				</tbody>
			</table>
			<div class='spacer'></div>
			<div class="row">
				<div class="col-sm-4">
					<p style='color:white'><a class="button solid burgundy" onClick="popularQueryN('higher'); return false;" href="#">Overall higher ratings to restaurants</a></p>
				</div>
				<div class="col-sm-4">
					<p style='color:white'><a onClick="popularQueryH(); return false;" href="#" class='button burgundy solid'>Other restaurants this user might like</a></p>
				</div>
				<div class="col-sm-4">
					<p style='color:white'><a class="button solid burgundy" onClick="popularQueryN('lower'); return false;" href="#">Overall lower ratings to restaurants</a></p>
				</div>
			</div>

		<hr>
			<!-- MENU ITEM REVIEWS -->
			<h2 style='color:white'>Menu Item Reviews</h2>
			
			<table class="table" style="margin-top:5px;color:white"> <!-- match margin of H2 next to it -->
				<!-- Header -->
				<thead>
					<tr style='background-color:white;padding:5px;'>
						<?php 
							$name = $_GET['name'];
							$sr = "";
							if (isset($_GET['sr'])) {
								$sr = $_GET['sr'];
							}
							echo "
							<th style='color:#c63939'><a style='margin-left:5px;' href='profile.php?name=$name&sr=$sr&sm=date'>Date</a></th>
							<th style='color:#c63939'><a href='profile.php?name=$name&sr=$sr&sm=name'>Item</a></th>
							<th style='color:#c63939'><a href='profile.php?name=$name&sr=$sr&sm=price'>Price</a></th>
							<th style='color:#c63939'><a href='profile.php?name=$name&sr=$sr&sm=type'>Type</a></th>
							<th style='color:#c63939'><a href='profile.php?name=$name&sr=$sr&sm=rating'>Rating</a></th>
							<th style='color:#c63939'>Comments</th>
							";
						?>
					</tr>
				</thead>
				<!-- All MENU ITEMS -->
				<tbody style='color:white'>
				<?php
					$name = $_GET['name'];
					$sortMenu = 'date';
					if (isset($_GET['sm'])) {
						$sortMenu = $_GET['sm'];
					}

					$query = "SELECT iRate.post_date, item.name, item.price, ct.description, iRate.rating, iRate.comments
						FROM Rater use
						INNER JOIN RatingItem iRate
							ON use.user_id=iRate.user_id
						INNER JOIN MenuItem item
							ON iRate.item_id=item.item_id
						INNER JOIN ItemType iType
							ON item.type_id=iType.type_id
						INNER JOIN Restaurant rest
							ON item.restaurant_id=rest.restaurant_id
						INNER JOIN CuisineType ct
							ON rest.cuisine=ct.cuisine_id
						WHERE use.name='$name'
						ORDER BY ";
					switch($sortMenu) {
						case 'date': default: $query.="iRate.post_date DESC"; break;
						case 'name': $query.="item.name, iRate.post_date DESC"; break;
						case 'price': $query.="item.price DESC, iRate.post_date DESC"; break;
						case 'type': $query.="ct.description, iRate.post_date DESC"; break;
						case 'rating': $query.="iRate.rating DESC, iRate.post_date DESC"; break;
					}
					
					$result = pg_query($query);
					while($res = pg_fetch_array($result)){
						$postDate = substr($res[0], 0, -8);
						$itemName = $res[1];
						$itemPrice = $res[2];
						$cuisineType = $res[3];
						$rating = $res[4];
						$comments = $res[5];

						echo "
								<tr>
									<td width='100px' style='color:white'>$postDate</td>
									<td width='150px' style='color:white'>$itemName</td>
									<td style='color:white'>\$$itemPrice</td>
									<td style='color:white'>$cuisineType</td>
									<td style='color:white'>$rating</td>
									<td style='color:white'>$comments</td>
								</tr>
								";
					}
				?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="container">
  <!-- Modal -->
  <div class="modal fade" id="changePassModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Change/Forgot Password</h4>
        </div>
        <div class="modal-body">
			<?php include("includes/changePasswordBox.php")?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>      
    </div>
  </div> 
</div>

<script>
$("#changePassLink").on('click', function(event){
$("#changePassModal").modal({backdrop: 'static'}, "show");
});
</script>
<div class="spacer"></div>
<?php include("includes/footer.php");?>
</body>
</html>