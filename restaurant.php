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
	<?php $page_title = "Restaurant" ?>
	<?php include("includes/external.php");?>

	<script type="text/javascript">
		function popularQueryM() {
			var id = getParameterByName("id");
			document.location.href="popular.php?query=m&extrao=" + id;
		}
	</script>
</head>

<body style="background:linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('img/background01.jpg');color:white;">
<?php include("includes/navigation.php");?>
<div class="spacer"></div>
<div class="container">
	<div class="spacer"></div>
	<div class="row clearfix">
	<h2 class="text-primary text-center" style='color:white;'><strong>
		<?php
			require('connect.php');
			$id = $_GET['id'];
			$delete="-1";
			if(array_key_exists('delete', $_GET))
				$delete = $_GET['delete'];
			if($delete != -1){
				$deletQuery = pg_query("DELETE FROM MenuItem MI WHERE item_id = $delete");
			}
			$result = pg_query("
				SELECT * 
				FROM restaurant R, location L
				WHERE L.location_id = $id AND L.restaurant_id = R.restaurant_id; 
			");
			
			$row = pg_fetch_assoc($result);
			$rName = $row['name'];
			$rUrl = $row['url'];
			echo "<a style='color:white;' href = 'http://$rUrl'>$rName</a>";
		?></strong></h2>
		
	</div>
	<div class="row clearfix">
		<div class="col-md-4 column text-center" id="review">	
		<button style="margin-bottom:10px" id="rateLink" type="write-review" class="button burgundy solid">
			<strong><span class="glyphicon glyphicon-star-empty" style="margin-right:10px; font-size:15px;"></span>Rate it</strong>
		</button>
		</div>
		<div class="col-md-8 column">
		<div class="row">
		<div class="col-md-6 column text-center">
		<?php
					require('connect.php');
					$id = $_GET['id'];
					
					$result = pg_query("
						SELECT * FROM location WHERE location_id = $id;
					");
					
					$row = pg_fetch_assoc($result);

					$number = $row['phone_number'];
					 $numbers_only = preg_replace("/[^\d]/", "", $number);

  					$number = preg_replace("/^1?(\d{3})(\d{3})(\d{4})$/", "$1-$2-$3", $numbers_only);
					
					echo "
					<script>
						review = document.getElementById('review');
						review.innerHTML = \"<a style='margin-bottom:10px' class='button burgundy solid' href ='tel:" . $number . "'><span class='fa fa-phone' style='margin-right:10px; font-size:15px;'></span>Call</a><br>\" +  review.innerHTML;
					</script>
					";
				?>
			<p style="font-size:20px">
			<?php 
				$open = $row['hour_open'];
				while (strlen($open) < 4) {
					$open = "0".$open;
				}
				$open = substr_replace($open, ":", strlen($open)-2, 0);
				$close = $row['hour_close'];
				while (strlen($close) < 4) {
					$close = "0".$close;
				}
				$close = substr_replace($close, ":", strlen($close)-2, 0);
				$first = $row['first_open_date'];
				$first = substr($first, 0, -8);
				$manager = $row['manager_name'];
				
				$result = pg_query("
					SELECT * 
					FROM cuisinetype C, restaurant R, location L
					WHERE L.location_id = $id AND L.restaurant_id = R.restaurant_id AND R.cuisine = C.cuisine_id; 
				");
				
				$row = pg_fetch_assoc($result);
				
				$cuisine = $row['description'];

				$location = $row['street_address'];
				
				
			echo"
				$location
				<br><br>
				Started: $first
				<br><br>
				" . ($manager != '' ? "Managed by: <i>$manager</i><br><br>" : "") . "
				<strong>
				Open: $open - $close
				</strong>
				<br><br>
				<script>
				review = document.getElementById('review');
				review.innerHTML = review.innerHTML + 
				\"<br><a class='button burgundy solid' href ='results.php?query=" .$cuisine . "&cui=" . $cuisine . "'><span class='fa fa-cutlery' style='margin-right:10px; font-size:15px;'></span>$cuisine cuisine</a>\"
				</script>
				";
			?>
			</p>
			</form>
			
		</div>
		<div class="col-md-6 column text-center">
				<h2 style="color:white">Rated as:</h2>
				<strong><p style="font-size:60px">
				<?php
				require('connect.php');
					$avgRating = 0;
					$query = "
						SELECT price, food, mood, staff
						FROM Rating RA, Location L
						WHERE L.location_id = $id AND RA.location_id = L.location_id
						";
					$result = pg_query($query);
					
					$total = 0;
					while($row = pg_fetch_assoc($result)){
						$total = (int) $total + 1;
						$price = (int) $row['price'];
						$food = (int) $row['food'];
						$mood = (int) $row['mood'];
						$staff = (int) $row['staff'];
						$avg = (int) ($price + $food + $mood + $staff)/4;
						$avgRating = $avgRating + $avg;
					}
					if($total!= 0)
						$avgRating = $avgRating/$total;
				$avgRating = round($avgRating, 1); 
				if($avgRating != 0)
					echo "$avgRating";
				else echo "N/A";
				?></font></strong>
		</div>
		</div>
		</div>
	</div>
	<div class="row clearfix hidden" id="messageBox"></div>
	<br>
	<div class="row clearfix">
			<h2 class="white">Ratings</h2>
			<?php
				require('connect.php');
				$result = pg_query("
					SELECT * FROM Rating R WHERE R.location_id = $id; 
				");
				
				while($row = pg_fetch_assoc($result)){
					$comment = $row['comments'];
					$price = $row['price'];
					$food = $row['food'];
					$mood = $row['mood'];
					$staff = $row['staff'];
					$author = $row['user_id'];
					$res1 = pg_query("SELECT type_id, name FROM Rater WHERE Rater.user_id = $author");
					$res1 = pg_fetch_assoc($res1);
					$author = $res1['name'];
					$type = $res1['type_id'];
					$res1 = pg_query("SELECT description FROM RaterType WHERE RaterType.type_id = $type");
					$res1 = pg_fetch_assoc($res1);
					$type = $res1['description'];

					echo "	
					<p style='color:white;'>" . ($comment == '' ? "No comment!" : $comment) . "</p>
					<h4 style='color:white;'> 
						by <a style='color:#c63939;' href='profile.php?name=$author'>$author</a> | $type
					</h4>
					<strong>Food: </strong> $food | <strong>Mood: </strong> $mood | <strong>Price: </strong> $price | <strong>Staff: </strong> $staff
					<hr>
					";
				}
			?>
			<h4 class="white"><a class="button burgundy solid" onClick="popularQueryM(); return false;" href="#"><span class='fa fa-search' style='margin-right:10px; font-size:15px;'></span>Find the most frequent raters</a></h4><br>
		</div>
		<div class="row clearfix">
		<!-- Menu Table -->
			<h2 class="white" style="margin-bottom:-5px">
			Menu
			</h2>
				<table class="table white" style="margin-top:20px"> <!-- match margin of H2 next to it -->
					<!-- Header -->
					<thead>
						<tr style='background-color:white;padding:5px;'>
							<?php
								$id = $_GET['id'];
								echo "<th style='color:#c63939;'><a style='margin-left:5px;' href='restaurant.php?id=$id&sort=item'>Item</a></th>";
								echo "<th style='color:#c63939;'><a href='restaurant.php?id=$id&sort=price'>Price</a></th>";
								echo "<th style='color:#c63939;'><a href='restaurant.php?id=$id&sort=type'>Type</a></th>";
								echo "<th style='color:#c63939;'><a href='restaurant.php?id=$id&sort=rating'>Rating</a></th>";
							?>
							<th />
							<th />
						</tr>
					</thead>
					<!-- All menu items -->
					<tbody>
					<?php
						$rId = pg_query("SELECT restaurant_id FROM Location WHERE Location.location_id = $id");
						$rId = pg_fetch_assoc($rId);
						$rId = $rId['restaurant_id'];

						$orderBy = "";

						$menuQuery = "SELECT item.name,item.item_id, item.price, iType.description, COALESCE(AVG(itemRate.rating), 0) AS avgRating, item.type_id
							FROM MenuItem item
							LEFT JOIN RatingItem itemRate
								ON item.item_id=itemRate.item_id
							LEFT JOIN ItemType iType
								ON item.type_id=iType.type_id
							WHERE item.restaurant_id=$rId
							GROUP BY item.item_id, item.name, item.price, iType.description, item.type_id
							ORDER BY ";

						if (isset($_GET['sort'])) {
							$orderBy = $_GET['sort'];
						} else {
							$orderBy = "type";
						}

						switch($orderBy) {
							case 'type': default: $menuQuery .= "item.type_id"; break;
							case 'item': $menuQuery .="item.name"; break;
							case 'price': $menuQuery.="item.price DESC"; break;
							case 'rating': $menuQuery.="avgRating DESC"; break;
						}
						
						$result = pg_query($menuQuery);
						while($res = pg_fetch_assoc($result)){
							$iName = $res['name'];
							$price = $res['price'];
							$itemid = $res['item_id'];
							$description = $res['description'];
							$itemAvgRating = $res['avgrating'];
							if($itemAvgRating > 0){
								$itemAvgRating = round($itemAvgRating, 1);
							}
							else{
								$itemAvgRating = "N/A";
							}
							echo "
								<tr style='color:white;'>
									<td style='color:white;'><a href='menuItem.php?id=" . $itemid . "'>$iName</a></td>
									<td style='color:white;'>\$$price</td>
									<td style='color:white;'>$description</td>
									<td style='color:white;'>$itemAvgRating</td>
									<td style='color:white;'>";
									echo "</td>";
						}

					?>
						
					</tbody>
				</table>
				
				<!-- BUTTON FOR ADDING NEW MENU ITEM -->
				<button  id="addMenuLink" class="button burgundy solid">
					<strong><span class=" glyphicon glyphicon-plus" style="margin-right:10px"></span>Add a Menu Item</strong>
				</button>
			</div>
</div>
<div class="container">
  <!-- Modal -->
  <div class="modal fade" id="ratingModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Rate - <?php echo $rName ?></h4>
        </div>
        <div class="modal-body">
			<?php include("includes/ratingBox.php")?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>      
    </div>
  </div> 
</div>

<?php
	if($userid != "" && $name != ""){
		$userid = $_SESSION['userid'];
		$id = $_GET['id'];
		if(array_key_exists('food', $_POST) && array_key_exists('price', $_POST) && array_key_exists('mood', $_POST)
			&& array_key_exists('staff', $_POST) && array_key_exists('comments', $_POST)){
			require('connect.php');

			$food = $_POST['food'];
			$price = $_POST['price'];
			$mood = $_POST['mood'];
			$staff = $_POST['staff'];
			$comments = $_POST['comments'];
			$location_id = $id;

			//Current date in YYYY-MM-DD format
			$currentDate = date('m-d-Y H:i:s', time());

			$query = "
				INSERT INTO Rating(user_id, post_date, price, food, mood, staff, comments, location_id)
				VALUES($userid, '$currentDate', $price, $food, $mood, $staff, '$comments', $location_id);
			";

			$result = pg_query($query); 

			$row = pg_fetch_assoc($result);
			$name = $row['name'];
			echo '
				<script>
					var messageBox = document.getElementById("messageBox");
					messageBox.innerHTML =
					"<p style=\'font-size:20px\' class=\'alert alert-success\'> <span class=\'glyphicon glyphicon-ok-circle\'></span> Thank you for rating this restaurant! Your rating has been saved.</p>";							messageBox.classList.remove("hidden");			setTimeout(function(){messageBox.classList.toggle("hidden");}, 7000);
				</script>
			';
		}
	}
	
	else {
		echo '
		<script>
			var messageBox = document.getElementById("messageBox");
			messageBox.innerHTML =
			"<p style=\'font-size:20px\' class=\'alert alert-info\'><i class=\'fa fa-info-circle\' style=\'font-size:24px\'></i> You need an account to rate this restaurant. You can sign in or register at the top of the page.</p>";								messageBox.classList.remove("hidden");			setTimeout(function(){messageBox.classList.toggle("hidden");}, 7000);
		</script>
		';
	}
	
	if(array_key_exists('name', $_POST) && array_key_exists('type', $_POST) 
		&& array_key_exists('addPrice', $_POST) && array_key_exists('description', $_POST)){
		$iName = $_POST['name'];
		$type = $_POST['type'];
		if($type == "Other")
			$type = 0;
		else if($type == "Appetizer")
			$type = 1;
		else if($type == "Entree")
			$type = 2;
		else if($type == "Dessert")
			$type = 3;
		else if($type == "Beverage")
			$type = 4;
		else if($type == "Alcoholic")
			$type = 5;
		$description = $_POST['description'];
		$price = $_POST['addPrice'];
		$location_id = $_GET['id'];
		require('connect.php');
		$result = pg_query("SELECT * FROM Location L WHERE L.location_id = $location_id;");
		$result = pg_fetch_assoc($result);
		$rId = $result['restaurant_id'];

		$result = pg_query("SELECT * FROM MenuItem MI WHERE MI.restaurant_id = $rId AND 
			MI.name = '$iName'");
		$num = pg_num_rows($result);

		if($num == 0){
			$result = pg_query("INSERT INTO MenuItem(name, type_id, description, price, restaurant_id)
				VALUES('$iName', $type, '$description', $price, $rId);");
			echo '
				<script>
					var messageBox = document.getElementById("messageBox");
					messageBox.innerHTML =
					"<p style=\'font-size:20px\' class=\'alert alert-success\'> <span class=\'glyphicon glyphicon-ok-circle\'></span> Thank you for adding this menu item! Your menu has been saved.</p><br><br>";
					messageBox.classList.remove("hidden");
					setTimeout(function(){messageBox.classList.toggle("hidden");}, 7000);
				</script>
			';
		}
		
		else {
			echo '
				<script>
					var messageBox = document.getElementById("messageBox");
					messageBox.innerHTML =
					"<p style=\'font-size:20px\' class=\'alert alert-info\'><i class=\'fa fa-info-circle\' style=\'font-size:24px\'></i> Sorry but this specific menu exists already!</p><br><br>";								messageBox.classList.remove("hidden");
					setTimeout(function(){messageBox.classList.toggle("hidden");}, 7000);
				</script>
			';
		}
	}
?>

<div class="container">
  <!-- Modal -->
  <div class="modal fade" id="addMenuModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add a menu for <?php echo $rName ?></h4>
        </div>
        <div class="modal-body">
			<?php include("includes/addMenuBox.php")?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>      
    </div>
  </div> 
</div>

<script>
$("#rateLink").on('click', function(event){
$("#ratingModal").modal({backdrop: 'static'}, "show");
});

$("#addMenuLink").on('click', function(event){
$("#addMenuModal").modal({backdrop: 'static'}, "show");
});
</script>
<div class="spacer"></div>
<?php include("includes/footer.php");?>
</body>
</html>