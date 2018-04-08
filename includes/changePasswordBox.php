<div class="container">
      <div class="row">
         <div class="col-md-6">
         <div class="panel with-nav-tabs panel-info">
            <div class="panel-heading">
               <ul class="nav nav-tabs">
			   <li class="active">
					<a href="#change_pass" data-toggle="tab">Change Password</a>
				</li>
               </ul>
            </div>
			<div class="panel-body">
               <div class="tab-content">
                  <div id="change_pass" class="tab-pane fade in active register">
                     <div class="container-fluid">
					 <form id="changePassForm" name="formID" method="post" action="" role="form">
                        <div class="row">    
                               <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                       <div class="form-group">
                                          <div class="input-group">
                                             <div class="input-group-addon iga1">
                                                <span class="glyphicon glyphicon-lock"></span>
                                             </div>
                                             <input type="password" class="form-control" placeholder="Current Password" name="pass" required>
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
                                             <input type="password" class="form-control" placeholder="New Password" name="new_pass" required>
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
                                             <input type="password" class="form-control" placeholder="Confirm Password" name="conf_pass" required>
                                          </div>
                                       </div>
                                    </div>
                                 </div>

                              <div class="row">
                                 <div class="col-xs-12 col-sm-12 col-md-12">
                                    <button type="submit" class="btn btn-success btn-block btn-lg"> Save </button>
                                 </div>
                              </div>							  
						<?php	
						if (array_key_exists('pass', $_POST)){
							require("connect.php");
							$query = "SELECT * FROM Rater WHERE Rater.name='$name'";
							$result = pg_query($query) or die('Query failed: ' . pg_last_error());
							$result = pg_fetch_assoc($result);

							if ($result == false) {
								echo "<h3 style='color:white'>Sorry, " . $name . " does not exist in our records!</h3>";
								exit;
							}
							
							$pass = $result['password'];
							$entered_pass = $_POST['pass'];
							
							if (array_key_exists('new_pass', $_POST) && array_key_exists('conf_pass', $_POST)){
								$new_pass = $_POST['new_pass'];
								$conf_pass = $_POST['conf_pass'];
								
								if($pass == $entered_pass && $new_pass == $conf_pass){
									$query = "UPDATE rater SET password = '$new_pass' WHERE name ='$name'";
									pg_query($query) or die('Query failed: ' . pg_last_error());
									echo '
									<script>
									var messageBox = document.getElementById("messageBox");
									messageBox.innerHTML =
									"<p style=\'font-size:20px\' class=\'alert alert-success\'><span  class=\'glyphicon glyphicon-ok-circle\'></span> Your password was updated successfully</p>";							messageBox.classList.remove("hidden");			setTimeout(function(){messageBox.classList.toggle("hidden");}, 7000);
									</script>									
									';
								}
								else{
									echo '
									<script>
									var messageBox = document.getElementById("messageBox");
									messageBox.innerHTML =
									"<p style=\'font-size:20px\' class=\'alert alert-danger\'><span class=\'glyphicon glyphicon-remove-circle\'></span> Please review your information, the information is wrong.</p>";								messageBox.classList.remove("hidden");			setTimeout(function(){messageBox.classList.toggle("hidden");}, 7000);
									</script>	
									';
								}
								}
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

   