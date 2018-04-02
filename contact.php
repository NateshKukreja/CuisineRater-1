<!DOCTYPE html> 
<?php
	session_start();     $name = "";     $userid = "";
	if(array_key_exists('name', $_SESSION) && array_key_exists('userid',$_SESSION)){
         $name = $_SESSION['name'];         $userid =
		 $_SESSION['userid']; 
	}
		
?>
<html lang="en">
<head>
	<?php $page_title = "Contact" ?>
	
	<?php include("includes/external.php");?>
</head>

<body style="background-image: url('img/background04.jpg');">
<?php include("includes/navigation.php");?>
<div class="spacer"></div>
<div class="container">
	<div class="row clearfix">	
		<div class="spacer"></div>
			<h2 style="color:white">Contact us, if you have an questions or inquiries.</h2>
			
			<div class="register-form">
				<div class="row clearfix">
					<div class="col-md-12 column">
						<form method = "post" role="form">
							<div class="row">
							<!-- Name -->
								<div class="form-group-xs">
									 <label for="input-name" style="color:white">Name</label>
									 <input name = "input-name" id = "input-name" type="text" class="form-control" id="input-name" style="color:white" autofocus/>
								</div>
							</div>
							<div class="row">
							<!-- Email -->
								<div class="form-group-xs">
									 <label for="input-email" style="color:white">Email address</label>
									 <input name = "input-email" id = "input-email" type="email" class="form-control" id="input-email" style="color:white" required/>
								</div>
							</div>
							<!-- Comments -->
							<div class="row">
								<div class="form-group-xs">
									 <label for="input-comments" style="color:white">Comments</label>
									 <textarea name = "input-comment" name = "input-comment" style="width:100%" name="comments" rows="10"  placeholder="Don't be shy, comment what's on your mind!" style="color:white" required></textarea>
								</div>
							</div>
							<br/>
							<!-- Submit button -->
							<div class="text-center">
								<button type="submit" class="button solid burgundy"><strong>Send</strong></button>
							</div>
						</form>
						<?php
							if(array_key_exists('input-name', $_POST) && array_key_exists('input-email', $_POST)
								&& array_key_exists('input-comment', $_POST)){
								require('connect.php');
								$name = $_POST['input-name'];
								$email = $_POST['input-email'];
								$comment = $_POST['input-comment'];

								$query = "
									INSERT INTO Contact(name, email, comments)
									VALUES('$name', '$email', '$comment');
								";
								pg_query($query);

								echo "Thank you for your comment, we will contact you back shortly. <a href ='index.php'>Back to home.</a>";
							}
						?>
					</div>
				</div>
			</div>
			
	</div>
</div>
<div class="spacer"></div>
<?php include('includes/footer.php')?>
</body>
</html>