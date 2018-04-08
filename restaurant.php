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
			echo "<a href = 'http://$rUrl'>$rName</a>";
		?></strong></h2>
		
	</div>
	<div class="row clearfix">
		<div class="col-md-4 column text-center" id="review">	
		<button style="margin-bottom:10px" id="rateLink" name = "write-review" method="post"  type="write-review" class="button burgundy solid">
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
						review.innerHTML = \"<a style='margin-bottom:10px' class='button burgundy solid' href ='tel:" . $number . "'><span class='fa fa-phone' style='margin-right:10px; font-size:15px;'></span>Call</a>'<br>\" +  review.innerHTML;
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
				\"<br><a class='button burgundy solid' href ='results.php?query=" .$cuisine . "&cui=" . $cuisine . "'>$cuisine cuisine</a>'\"
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
	<br>
	<div class="row clearfix">
			<h2 class="white">Reviews</h2>
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
					<p style='color:white;'>
						$comment
					</p>
					<h4 style='color:white;'> 
						by <a style='color:white;' href='profile.php?name=$author'>$author</a> | $type
					</h4>
					<strong>Food: </strong> $food | <strong>Mood: </strong> $mood | <strong>Price: </strong> $price | <strong>Staff: </strong> $staff
					<hr>
					";
				}
			?>
			<h4 class="white"><a class="button burgundy solid" onClick="popularQueryM(); return false;" href="#">Find the most frequent raters</a></h4><br>
		</div>
		<div class="row clearfix">
		<!-- Menu Table -->
			<h2 class="white" style="margin-bottom:-5px">
			Menu
			</h2>
				<table class="table white" style="margin-top:20px"> <!-- match margin of H2 next to it -->
					<!-- Header -->
					<thead>
						<tr>
							<?php
								$id = $_GET['id'];
								echo "<th style='color:white;'><a href='restaurant.php?id=$id&sort=item'>Item</a></th>";
								echo "<th style='color:white;'><a href='restaurant.php?id=$id&sort=price'>Price</a></th>";
								echo "<th style='color:white;'><a href='restaurant.php?id=$id&sort=type'>Type</a></th>";
								echo "<th style='color:white;'><a href='restaurant.php?id=$id&sort=rating'>Rating</a></th>";
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
									<td style='color:white;'>$iName</td>
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
				<button  onclick = "redirect('add-item.php')" name = "add-item" method  = "post"  type="add-item" class="button burgundy solid">
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
          <h4 class="modal-title">Rate it</h4>
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
<script>
$("#rateLink").on('click', function(event){
$("#ratingModal").modal({backdrop: 'static'}, "show");
});
</script>
<div class="spacer"></div>
<?php include("includes/footer.php");?>
</body>
</html>