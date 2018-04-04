<?php 
	if(session_id() == '') {
	session_start();
	$name = "";
	$userid = "";
	if(array_key_exists('name', $_SESSION) && array_key_exists('userid', $_SESSION)){
		$name = $_SESSION['name'];
		$userid = $_SESSION['userid'];
	}
}
		
?>
<?php
if($name == "" || $userid == ""){
	echo'	
		<div class="responsive-menu">
			<a href="" class="responsive-menu-close"><i class="icon-close"></i></a>
			<nav class="responsive-nav"></nav> <!-- end .responsive-nav -->
		</div> <!-- end .responsive-menu -->
		<header class="header transparent">
			<div class="navigation">
				<div class="container clearfix"><br>
					<div class="logo"><a href="index.html"><img src="img/icon.png" alt="Cuisine" class="img-responsive"></a></div> <!-- end .logo -->
					<nav class="main-nav">
						<ul class="list-unstyled">
							<li><a href="index.php">Home</a></li>
							<li>
								<a>About</a>
								<ul>
									<li><a href="creators.php">Creators</a></li>
								</ul>
							</li>
							<li>
								<a href="menu.html">Cuisines</a>
								<ul>
									<li><a href="results.php?search=Breakfast&cui=Breakfast">Breakfast/Brunch</a></li>
									<li><a href="results.php?search=Grill&cui=Grill>Grill</a></li>
									<li><a href="results.php?search=Chinese&cui=Chinese">Chinese</a></li>
									<li><a href="results.php?search=Indian&cui=Indian">Indian</a></li>
									<li><a href="results.php?search=Indian&cui=Indian">Italian</a></li>
									<li><a href="results.php?search=Korean&cui=Korean">Korean</a></li>
									<li><a href="results.php?search=Mexican&cui=Mexican">Mexican</a></li>
									<li><a href="results.php?search=Sandwiches&cui=Sandwiches">Sandwiches</a></li>
									<li><a href="results.php?search=Middle&cui=Middle">Middle Eastern</a></li>
									<li><a href="results.php?search=Other&cui=Other">Other</a></li>
								</ul>
							</li>
							<li><a href="contact.php">Contact</a></li>
							<li><a id="login_link" style="cursor:pointer;color:#ef4a4a">Login/Signup</a></li>
						</ul>
					</nav> <!-- end .main-nav -->
					<a href="" class="responsive-menu-open"><i class="fa fa-bars"></i></a>
				</div> <!-- end .container -->
			</div> <!-- end .navigation -->
	';
}
else{
	echo'
		<div class="responsive-menu">
	<a href="" class="responsive-menu-close"><i class="icon-close"></i></a>
	<nav class="responsive-nav"></nav> <!-- end .responsive-nav -->
</div> <!-- end .responsive-menu -->
<header class="header transparent">
	<div class="navigation">
		<div class="container clearfix"><br>
			<div class="logo"><a href="index.html"><img src="img/icon.png" alt="Cuisine" class="img-responsive"></a></div> <!-- end .logo -->
			<nav class="main-nav">
				<ul class="list-unstyled">
					<li><a href="index.php">Home</a></li>
					<li>
						<a style="cursor:pointer">About</a>
						<ul>
							<li><a href="creators.html">Creators</a></li>
						</ul>
					</li>
					<li>
						<a style="cursor:pointer">Cuisines</a>
						<ul>
							<li><a href="results.php?search=Breakfast&cui=Breakfast">Breakfast/Brunch</a></li>
							<li><a href="results.php?search=Grill&cui=Grill">Grill</a></li>
							<li><a href="results.php?search=Chinese&cui=Chinese">Chinese</a></li>
							<li><a href="results.php?search=Indian&cui=Indian">Indian</a></li>
							<li><a href="results.php?search=Italian&cui=Italian">Italian</a></li>
							<li><a href="results.php?search=Korean&cui=Korean">Korean</a></li>
							<li><a href="results.php?search=Mexican&cui=Mexican">Mexican</a></li>
							<li><a href="results.php?search=Sandwiches&cui=Sandwiches">Sandwiches</a></li>
							<li><a href="results.php?search=Middle%20Eastern&cui=Middle%20Eastern">Middle Eastern</a></li>
							<li><a href="results.php?search=Other&cui=Other">Other</a></li>
						</ul>
					</li>
					<li><a href="contact.php">Contact</a></li>
					';
					
					$user = $_SESSION['name'];
				echo'
					<li>
						<a href="profile.php?name=' . $user . '" style="color:#ef4a4a">' . $user . '</a>
						<ul>
							<li><a href="logout.php">Logout</a></li>
						</ul>
					</li>
				</ul>
			</nav> <!-- end .main-nav -->
			<a href="" class="responsive-menu-open"><i class="fa fa-bars"></i></a>
		</div> <!-- end .container -->
	</div> <!-- end .navigation -->
	';
}
?>
</header> <!-- end .header -->

<div class="container">
  <!-- Modal -->
  <div class="modal fade" id="loginModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Login/Signup</h4>
        </div>
        <div class="modal-body">
			<?php include("includes/loginbox.php")?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div> 
</div>

<script>
$("#login_link").on('click', function(event){
$("#loginModal").modal("show");
});
</script>
