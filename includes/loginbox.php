
<div class="container">
      <div class="row">
         <div class="col-md-6">
         <div class="panel with-nav-tabs panel-info">
            <div class="panel-heading">
               <ul class="nav nav-tabs">
                  <li class="active"><a href="#login" data-toggle="tab"> Login </a></li>
                  <li><a href="#signup" data-toggle="tab"> Signup </a></li>
               </ul>
            </div>

            <div class="panel-body">
               <div class="tab-content">
                  <div id="login" class="tab-pane fade in active register">
                     <div class="container-fluid">
					 <form id="loginForm" name="formID" method="post" action="" role="form">
                        <div class="row">
                              <div class="row">
                                 <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                       <div class="input-group">
                                          <div class="input-group-addon">
                                             <span class="glyphicon glyphicon-envelope"></span>
                                          </div>
                                          <input type="text" placeholder="Email" name="email" class="form-control">
                                       </div>
                                    </div>
                                 </div>
                              </div>

                              <div class="row">
                                 <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                       <div class="input-group">
                                          <div class="input-group-addon">
                                             <span class="glyphicon glyphicon-lock"></span>
                                          </div>

                                          <input type="password" placeholder="Password" name="pass" class="form-control">
                                       </div>
                                    </div>
                                 </div>
                              </div>

                              <div class="col-xs-12 col-sm-12 col-md-12">
                                 <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                       <input type="checkbox" name="check" checked> Remember Me
                                    </div>
                                 </div>

                                  <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                       <a href="#forgot" data-toggle="modal"> Forgot Password? </a>
                                    </div>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-xs-12 col-sm-12 col-md-12">
                                    <button type="submit" class="btn btn-success btn-block btn-lg"> Login </button>
                                 </div>
                              </div>

                        </div>
						</form>
                     </div> 
                  </div>

                  <div id="signup" class="tab-pane fade">
                     <div class="container-fluid">
					 <form id="signupForm" name="formID" method="post" action="" role="form">
                        <div class="row">
                                 <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                       <div class="form-group">
                                          <div class="input-group">
                                             <div class="input-group-addon iga1">
                                                <span class="glyphicon glyphicon-user"></span>
                                             </div>
                                             <input type="text" class="form-control" placeholder="Enter User Name" name="name">
                                          </div>
                                       </div>
                                    </div>
                                 </div>

                                 <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                       <div class="form-group">
                                          <div class="input-group">
                                             <div class="input-group-addon iga1">
                                                <span class="glyphicon glyphicon-envelope"></span>
                                             </div>
                                             <input type="email" class="form-control" placeholder="Enter E-Mail" name="email">
                                          </div>
                                       </div>
                                    </div>
                                 </div>

                                 <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                       <div class="form-group">
                                          <div class="input-group">
                                             <div class="input-group-addon iga1">
                                                <span class="glyphicon glyphicon-lock"></span>
                                             </div>
                                             <input type="password" class="form-control" placeholder="Enter Password" name="pass">
                                          </div>
                                       </div>
                                    </div>
                                 </div>
								 
								 <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                       <div class="form-group">
                                          <div class="input-group">
                                             <div class="input-group-addon iga1">
                                                <span class="glyphicon glyphicon-lock"></span>
                                             </div>
                                             <input type="password" class="form-control" placeholder="Confirm Password" name="conf_pass">
                                          </div>
                                       </div>
                                    </div>
                                 </div>
								 
								 <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                       <div class="form-group">
											<label id = "input-rater" name = "input-type" method="post" for="form-control">Rater Type</label>
                                             <select name = "rater_type" id = "input-select" method= "post" class="form-control">
												<option>Casual</option>
												<option>Blogger</option>
												<option>Verified Critic</option>
												<option>Other</option>
											</select>
                                       </div>
                                    </div>
                                 </div>
								 
                                 <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                       <div class="form-group">
                                          <button type="submit" class="btn btn-warning btn-lg btn-block"> Register</button>
                                       </div>
                                    </div>
                                 </div>
								 
								<?php
									if (array_key_exists('email', $_POST) && array_key_exists('pass', $_POST) && array_key_exists('name', $_POST)
									 && array_key_exists('conf_pass', $_POST) && array_key_exists('rater_type', $_POST)){
							
										//get form variables
										$name = $_POST['name'];
										$email = $_POST['email'];
										$pass = $_POST['pass'];
										$conf = $_POST['conf_pass'];
										$rater_type = $_POST['rater_type'];

										if($rater_type == "Casual")
											$rater_type = 1;
										else if($rater_type == "Blogger")
											$rater_type = 2;
										else if($rater_type == "Verified Critic")
											$rater_type = 3;
										else if($rater_type == "Other")
											$rater_type = 0;


										require("connect.php");
										
										$query = "SELECT * FROM Rater WHERE Rater.name='$name'";
										$result = pg_query($query) or die('Query failed: ' . pg_last_error());
										
										$numRows = pg_num_rows($result);
										
										if(strpos($name,'@')){
											echo "Your name cannot contain the @ symbol";
										}
										else if($numRows == 0){
											
											$query = "SELECT * FROM Rater WHERE Rater.email='$email'";
											$result = pg_query($query) or die('Query failed: ' . pg_last_error());
										
											$numRows = pg_num_rows($result);
											
											if($numRows == 0){
												if($pass == $conf){
													//connect to DB
													require("connect.php");
													//Current date in YYYY-MM-DD format
													$currentDate = date('Y-m-d');
													pg_query("
														INSERT INTO Rater(email, name, join_date, type_id, reputation, password)
														VALUES('$email', '$name', '$currentDate', $rater_type, 1, '$pass');
													");
													
													echo '
													<div class="row">
														<div class="col-xs-12 col-sm-12 col-md-12">
														   <p class="success">Hi ' . $name . ', congratulations, you can now start <a href="index.php" style="text-decoration:underline;color:#af3333">rating</a> restaurants</p>
														</div>
													</div>
													';
												}
												else{
													echo '
													<div class="row">
														<div class="col-xs-12 col-sm-12 col-md-12">
														   <p class="error">Your password does not match the confirmation password.</p>
														</div>
													</div>
													';
												}
											}
											else{
												echo '
												<div class="row">
													<div class="col-xs-12 col-sm-12 col-md-12">
													   <p class="error">Sorry but the email you provided is already registered</p>
													</div>
												</div>
												';
											}
										}
										else {
											echo '
											<div class="row">
													<div class="col-xs-12 col-sm-12 col-md-12">
													   <p class="error">Sorry but the username you provided is already registered</p>
													</div>
												</div>
											';
										}
									}
									
									else if (array_key_exists('email', $_POST) && array_key_exists('pass', $_POST)){
										
										$user_email = $_POST['email'];
										$user_pass = $_POST['pass'];
										
										require('connect.php');
										
										$result = pg_query("SELECT * FROM Rater WHERE Rater.email = '$user_email';") or die('Query failed: ' . pg_last_error());
										
										$numRows = pg_num_rows($result);
										
										if($numRows != 0){
											$res = pg_query("SELECT * FROM Rater WHERE Rater.email = '$user_email';") or die('Query failed: ' . pg_last_error());
											$row = pg_fetch_assoc($res);
											
											$dbPass = $row['password'];
											$dbName = $row['name'];
											$dbUserid = $row['user_id'];
											
											if($dbPass == $user_pass){
												$_SESSION['name'] = $dbName;
												$_SESSION['userid'] = $dbUserid;
												?>
												<script>
													redirectMenu("index.php");
												</script>
									<?php
								}
								else{
									echo '
									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-12">
										   <p class="error">The password you provided does not match with the email.</p>
										</div>
									</div>
									';
								}
							}
							else{
								echo '
								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-12">
									   <p class "error">The email you have entered does not exist in our records. Please register!</p>
									</div>
								</div>
								';
							}
							
						}
						else{
						echo '';
						}
						?>
                        </div>
						</form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>


<div class="modal fade" id="forgot">
  <div class="modal-dialog">
	 <div class="modal-content">
		<div class="modal-header">
		   <button type="button" class="close" data-dismiss='modal' aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></button>
		   <h4 class="modal-title" style="font-size: 32px; padding: 12px;"> Recover Your Password </h4>
		</div>

		<div class="modal-body">
		   <div class="container-fluid">
			  <div class="row">
				<p>An e-mail will be sent to you with a temporary password. Thank you!</p>
				 <div class="col-xs-12 col-sm-12 col-md-12">
					<div class="form-group">
					   <div class="input-group">
						  <div class="input-group-addon iga2">
							 <span class="glyphicon glyphicon-envelope"></span>
						  </div>
						  <input type="email" class="form-control" placeholder="Enter your registered e-Mail ID" name="email">
					   </div>
					</div>
				 </div>
			  </div>
		   </div>
		</div>

		<div class="modal-footer">
		   <div class="form-group">
			  <button type="submit" class="btn btn-success btn-block btn-lg"> Send <span class="glyphicon glyphicon-send"></span></button>

		   </div>
		</div>
	 </div>
  </div>
</div>
   
   