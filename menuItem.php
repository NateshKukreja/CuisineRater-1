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

<body style="background:linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('img/background04.jpg'); color:white;">
<?php include("includes/navigation.php");?>
<div class="spacer"></div>
<div class="container">
	<div class="row clearfix">
		<div class="spacer"></div>
		<div class="col-md-12 column">
			<!-- ALL REVIEWS PREVIOUSLY WRITTEN -->
			
			<?php
				require('connect.php');
				$id = $_GET['id'];
				$query = "
				SELECT R.name AS rname, M.description AS idesc, M.name AS iname
				FROM Restaurant R, MenuItem M
				WHERE M.restaurant_id = R.restaurant_id AND M.item_id = $id
				";
				$result = pg_query($query);
				$row = pg_fetch_assoc($result);
				$rName = $row['rname'];
				$iName = $row['iname'];
				$idesc = $row['idesc']; 
				echo "<h2 class='white'><strong>$iName</strong> from <strong>$rName</strong></h2>";
				echo "<h4 class='text-muted white' style='margin-bottom:40px;'><i>$idesc</i></h4>";
				echo "<div class='row clearfix hidden' id='messageBox'></div>";
				echo "<h3 class='white'>Ratings</h3>";
			?>
						
			<table class="table"> <!-- match margin of H2 next to it -->
				<!-- Header -->
				<thead style='background-color:white;padding:5px;'>
					<tr>
						<th style='color:#c63939'><span style='margin-left:5px;'></span>Username</th>
						<th style='color:#c63939'>Posting Date</th>
						<th style='color:#c63939'>Rating</th>
						<th style='color:#c63939'>Comment</th>
					</tr>
				</thead>
				<tbody>
				<?php
					require('connect.php');
					$id = $_GET['id'];
					$query = "
						SELECT R.name, RI.Post_Date, RI.rating, RI.comments 
						FROM RatingItem RI, Rater R
						WHERE item_id = $id AND R.user_id = RI.user_id
					";
					$result = pg_query($query);
					while($row = pg_fetch_assoc($result)){
						$name = $row['name'];
						$date = $row['post_date'];
						$rating = $row['rating'];
						$comment = $row['comments'];
						$date = substr($date, 0, -8);
						if($comment == "")
							$comment = "N/A";
						echo "
							<tr>
								<td style='color:white'><a href='profile.php?name=$name'>$name</a></td>
								<td style='color:white'>$date</td>
								<td style='color:white'>$rating</td>
								<td style='color:white'>$comment</td>
							</tr>";
					}
				?>
					
				</tbody>
			</table>
			
			<!-- WRITE A NEW REVIEW -->
			<hr>
			<?php
				require('connect.php');
				$id = $_GET['id'];
				$query = "
				SELECT R.name AS rname, M.name AS iname
				FROM Restaurant R, MenuItem M
				WHERE M.restaurant_id = R.restaurant_id AND M.item_id = $id
				";
				$result = pg_query($query);
				$row = pg_fetch_assoc($result);
				$rName = $row['rname'];
				$iName = $row['iname'];
				echo "
				<button style=\"margin-bottom:10px\" id=\"rateLink\" type=\"write-review\" class=\"button burgundy solid\"><strong><span class=\"glyphicon glyphicon-star-empty\" style=\"margin-right:10px; font-size:15px;\"></span>Rate it</strong>
				</button>
				";
			?>
		</div>
	</div>

		<?php
		if($userid != "" && $name != ""){
			$userid = $_SESSION['userid'];
			$id = $_GET['id'];
			if(array_key_exists('rate', $_POST)){
				require('connect.php');

				$food = $_POST['rate'];
				$comments = $_POST['comments'];

				$item_id = $_GET['id'];

				//Current date in YYYY-MM-DD format
				$currentDate = date('m-d-Y H:i:s', time());

				$query = "
					INSERT INTO RatingItem(user_id, post_date, item_id, rating, comments)
					VALUES($userid, '$currentDate', $item_id, $food, '$comments');
				";

				$result = pg_query($query); 

				$row = pg_fetch_assoc($result);
				$name = $row['name'];
				echo '
					<script>
						var messageBox = document.getElementById("messageBox");
						messageBox.innerHTML =
						"<p style=\'font-size:20px\' class=\'alert alert-success\'> <span class=\'glyphicon glyphicon-ok-circle\'></span> Thank you for rating this menu item! Your rating has been saved.</p><br><br>";							messageBox.classList.remove("hidden");			setTimeout(function(){messageBox.classList.toggle("hidden");}, 7000);
					</script>
				';
			}
		}else {
			echo '
				<script>
					var messageBox = document.getElementById("messageBox");
					messageBox.innerHTML =
					"<p style=\'font-size:20px\' class=\'alert alert-info\'><i class=\'fa fa-info-circle\' style=\'font-size:24px\'></i> You need an account to rate this menu item. You can sign in or register at the top of the page.</p><br><br>";								messageBox.classList.remove("hidden");			setTimeout(function(){messageBox.classList.toggle("hidden");}, 7000);
				</script>
			';
		}
		?>
	</div>


<div class="container">
  <!-- Modal -->
  <div class="modal fade" id="ratingModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Rate - <?php echo $iName ?></h4>
        </div>
        <div class="modal-body">
			<?php include("includes/rateMenuBox.php")?>
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