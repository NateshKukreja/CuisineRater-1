<?php 
	require('connect.php');

	$results = pg_query("SELECT rest.name, loc.location_id, AVG(temp.avgRating) AS avg
	FROM Restaurant rest
	INNER JOIN Location loc
		ON rest.restaurant_id=loc.restaurant_id
	INNER JOIN
		(SELECT loc2.location_id locid2, (rate2.food+rate2.staff+rate2.price+rate2.mood)/4.0 AS avgRating
			FROM Location loc2
			INNER JOIN Rating rate2
				ON loc2.location_id=rate2.location_id) temp
		ON loc.location_id=locid2
	GROUP BY rest.name, loc.location_id
	ORDER BY avg DESC;"
	);
	//Get top 3 restaurant;
	$i = 0;
	//In most popular restaurants!
	$type1 = -1;
	$type2 = -2;
	$type3 = -3;

	while($i < 3 && $tmp = pg_fetch_assoc($results)){
		$name = $tmp['name'];
		$locationId = $tmp['location_id'];
		$res = pg_query("SELECT use.name, rate.food, rate.mood, rate.price, rate.staff, rate.comments
		FROM Rating rate
		INNER JOIN Rater use
			ON rate.user_id=use.user_id
		INNER JOIN Location loc
			ON rate.location_id=loc.location_id
		WHERE loc.location_id = $locationId -- Replace with location_id of specific location
			AND (rate.food+rate.mood+rate.price+rate.staff) >= ALL
				(SELECT rate2.food+rate2.mood+rate2.price+rate2.staff
					FROM Rating rate2
					INNER JOIN Rater use2
						ON rate2.user_id=use2.user_id
					INNER JOIN Location loc2
						ON rate2.location_id=loc2.location_id
					WHERE loc2.location_id = $locationId)
		");
		$res = pg_fetch_assoc($res);

		$comment = $res['comments'];
		$raterName = $res['name'];
		$name = $GLOBALS['name'];

		//Get images for slide

		$images = array(
			"unknown.png", "unknown.png", "unknown.png",
			"mexican_1.jpg", "mexican_2.jpg", "mexican_3.jpg",
			"indian_1.jpg", "indian_2.jpg", "indian_3.jpg",
			"korean_1.jpg", "korean_2.jpg", "korean_3.jpg",
			"chinese_1.jpg", "chinese_2.jpg", "chinese_3.jpg",
			"italian_1.jpg", "italian_2.jpg", "italian_3.jpg",
			"fine_dining_1.jpg", "fine_dining_2.jpg", "fine_dining_3.jpg",
			"breakfast_1.jpg", "breakfast_2.jpg", "breakfast_3.jpg",
			"middle_eastern_1.jpg", "middle_eastern_2.jpg", "middle_eastern_3.jpg",
			"sandwiches_1.jpg", "sandwiches_2.jpg", "sandwiches_3.jpg",
			"other_1.jpg", "other_2.jpg", "other_3.jpg"
			);

		$name = $GLOBALS['name'];
		$image = "";
		$typeQuery = pg_query("SELECT cuisine, restaurant_id 
		FROM Restaurant R
		WHERE R.name = '$name'");
		$typeQuery = pg_fetch_assoc($typeQuery);
		if($i == 0){
			$type1 = $typeQuery['cuisine'];
		}else if($i == 1){
			$type2 = $typeQuery['cuisine'];
		}else{
			$type3 = $typeQuery['cuisine'];
		}
		if($i == 0){
			$image = $images[$type1*3 + 0];
		}
		if($i == 1){
			if($type1 == $type2)
				$image = $images[$type2*3 + 1];
			else $image = $images[$type2*3 + 0];
		}
		if($i == 2){
			if($type3 == $type2 && $type3 == $type1)
				$image = $images[$type3*3 + 2];
			else if($type3 == $type2 || $type3 == $type1)
				$image = $images[$type3*3 + 1];
			else $image = $images[$type3*3 + 0];
		}
		$name = $GLOBALS['name'];
		$restaurant_id = $typeQuery['restaurant_id'];
?>

<div class="slide" style="background-image: url(<?php echo 'img/' . $image ?>);">
	<div class="inner">
		<div class="container">
			<div class="row aligned-cols">
				<div class="col-sm-6 aligned-middle float-left">
					<h1><?php echo $name ?></h1>
					<p class="button-list"><a href="restaurant.php?id=<?php echo $restaurant_id ?>" class="button light">View ratings</a><a href="restaurant.php?id=<?php echo $restaurant_id ?>" class="button burgundy solid">Rate</a></p>
				</div> <!-- end .col-sm-6 -->
				<div class="col-sm-6 text-right float-right">
					<div class="comment-box">
						<div class="title">Comment</div>
						<div class="clearfix"><p><?php echo ($comment == '' ? "No comment!" : $comment) ?><br><br><span class="highest_rated"> Rated by:<br> <a style="color:#0645AD" href="profile.php?name=<?php echo $raterName ?>"><?php echo $raterName ?></a></span></p></div>
					</div> <!-- end .hours-box -->
				</div> <!-- end .col-sm-6 -->
			</div> <!-- end .row -->
		</div> <!-- end .container -->
	</div> <!-- end .inner -->
</div> <!-- end .slide -->

<?php
$i++;	
}
?>
