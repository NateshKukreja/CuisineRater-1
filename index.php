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
		<?php $page_title = "Home" ?>
		<?php include("includes/external.php");?>
	</head>
	<body>
		<?php include("includes/navigation.php");?>
		
		<div id="welcome-slider" class="welcome-slider flex-slider">
			<div class="slides clearfix">
				<?php include("includes/slides.php");?>
			</div> <!-- end .slides -->
		</div> <!-- end .welcome-slider -->

		<div class="section white border-top">
			<div class="inner">
				<div class="container">
					<div class="row">
						<div class="col-sm-3">
							<h2>Menu Items</h2>
							<p>Find menus that are served from any restaurant.</p>
							<p>You will always enjoy new menus that you never though of.</p>
						</div> <!-- end .col-sm-3 -->
						<div class="column-spacer"></div>
						<div class="col-sm-9">
							<div class="row">
								<div class="col-sm-4">
									<div class="menu clearfix">
										<span class="price">$54</span>
										<h5>Roasted Turbot</h5>
										<p>Speck Ham, Savoy Cabbage, Fall Vegetables Caramelized Salsify, Ommegang Beer Jus.</p>
									</div> <!-- end .menu -->
								</div> <!-- end .col-sm-4 -->
								<div class="col-sm-4">
									<div class="menu clearfix">
										<span class="price">$12</span>
										<h5>Ice Cream</h5>
										<p>Smashed honeycomb, Crushed nuts & seeds, Seasonal fruits, Butterscotch sauce.</p>
									</div> <!-- end .menu -->
								</div> <!-- end .col-sm-4 -->
								<div class="col-sm-4">
									<div class="menu clearfix">
										<span class="price">$31</span>
										<h5>Huckleberry Limenade</h5>
										<p>Satisfy your sweet and sour cravings with combination of grenadine, lime and Sierra.</p>
									</div> <!-- end .menu -->
								</div> <!-- end .col-sm-4 -->
								<div class="col-sm-4">
									<div class="menu clearfix">
										<span class="price">$38</span>
										<h5>Baked Ravioli</h5>
										<p>Jumbo cheese-stuffed ravioli tossed in a light tomato cream sauce w/ baby spinach.</p>
									</div> <!-- end .menu -->
								</div> <!-- end .col-sm-4 -->
								<div class="col-sm-4">
									<div class="menu clearfix">
										<span class="price">$56</span>
										<h5>Ruban Rouge<span class="label green">New</span></h5>
										<p>Clementine Mousseline, Gingerbread Sablé Quince-Vodka Sorbet.</p>
									</div> <!-- end .menu -->
								</div> <!-- end .col-sm-4 -->
								<div class="col-sm-4">
									<div class="menu clearfix">
										<span class="price">$73</span>
										<h5>Angry Ball</h5>
										<p>A devilish blend of Fireball Cinnamon Whisky and Angry Orchard Apple Cider.</p>
									</div> <!-- end .menu -->
								</div> <!-- end .col-sm-4 -->
								<div class="col-sm-4">
									<div class="menu clearfix">
										<span class="price">$19</span>
										<h5>Italian Lobster</h5>
										<p>Half a marinated & roasted lobster with silky Parmesan sauce & spaghetti modoro.</p>
									</div> <!-- end .menu -->
								</div> <!-- end .col-sm-4 -->
								<div class="col-sm-4">
									<div class="menu clearfix">
										<span class="price">$12</span>
										<h5>Ice Cream</h5>
										<p>Smashed honeycomb, Crushed nuts & seeds, Seasonal fruits, Butterscotch sauce.</p>
									</div> <!-- end .menu -->
								</div> <!-- end .col-sm-4 -->
								<div class="col-sm-4">
									<div class="menu clearfix">
										<span class="price">$62</span>
										<h5>Double Grape Martini</h5>
										<p>Hendrick's gin, grapes, cucumber, fresh and pressed apple & lemon juice.</p>
									</div> <!-- end .menu -->
								</div> <!-- end .col-sm-4 -->
							</div> <!-- end .row -->
						</div> <!-- end .col-sm-9 -->
					</div> <!-- end .row -->
				</div> <!-- end .container -->
			</div> <!-- end .inner -->
		</div> <!-- end .section -->

		<div class="section large dark transparent parallax" style="background-image: url('img/background03.jpg');">
			<div class="inner">
				<div class="container">
					<div class="row">
						<div class="col-sm-6">
							<h2>Have a restaurant or cuisine in mind? If you cannot find it, you can always add it to our website.</h2>
							<a href="add_resto.php" class="button solid burgundy">Add a restaurant</a>
							<a href="cuisines.php?query=" class="button solid burgundy">View all restaurants</a>
						</div> <!-- end .col-sm-6 -->
					</div> <!-- end .row -->
				</div> <!-- end .container -->
			</div> <!-- end .inner -->
		</div> <!-- end .section -->

		<div class="section white">
			<div class="inner">
				<div class="container">
					<div class="row">
						<div class="col-sm-6">
							<img src="img/phone-app.png" alt="Phone App" class="img-responsive">
						</div> <!-- end .col-sm-6 -->
						<div class="col-sm-6">
							<h3>Looking for the Food Feed? Get the app!</h3>
							<p>Follow us to view the most recent reviews and photos in your Feed, and discover great new restaurants!</p>
							<p>We'll send you a link, open it on your phone to download the app</p>
							<div class="spacer"></div>
							<form id="appForm" action="submit.php" method="post">
							  <div class="form-group">
								<label for="emailAddress">Email address</label>
								<div class="row">
									<div class="col-sm-6">
										<input type="email" class="form-control form-control-lg" id="email" aria-describedby="emailHelp" placeholder="Enter email" name="email">
									</div>
									<div class="col-sm-6">
										<button type="submit" class="btn btn-primary btn-lg">Send</button>
									</div>
								</div>
								<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
							  </div>
							</form>
							<?php 
								echo (isset($message) ? $message : ""); 
							?> 
						</div> <!-- end .col-sm-6 -->
					</div> <!-- end .row -->
				
				</div> <!-- end .container -->
			</div> <!-- end .inner -->
		</div> <!-- end .section -->

		<div class="section small text-center dark transparent parallax" style="background-image: url('img/background02.jpg');">
			<div class="inner">
				<div class="container">
					<div class="call-to-action">
						<h3>Want to check what other people search for?</h3>
						<a href="checkout.php" class="button solid burgundy">Check it out!</a>
					</div> <!-- end .call-to-action -->
				</div> <!-- end .container -->
			</div> <!-- end .inner -->
		</div> <!-- end .section -->
		


  <script>
  $('#appForm').on('submit', function(e) {
    e.preventDefault(); //Prevents default submit
    var form = $(this); 
    var post_url = form.attr('action'); 
    var post_data = form.serialize(); //Serialized the form data for process.php
    $.ajax({
        type: 'POST',
        url: 'submit.php', // Your form script
        data: post_data,
        success: function(msg) {
            $('#contact_message').toggleClass('w3-hide w3-show');
			setTimeout(function(){$('#contact_message').toggleClass('w3-show w3-hide');}, 15000);
        }
    });
  });
  </script>

		
		<?php include("includes/footer.php");?>
		
	</body>
</html>