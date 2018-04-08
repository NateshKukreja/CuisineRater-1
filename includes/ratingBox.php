<div class="container">
      <div class="row">
         <div class="col-md-6">
         <div class="panel with-nav-tabs panel-info">
            <div class="panel-heading">
               <ul class="nav nav-tabs">
			   <li class="active">
					<a href="#change_pass" data-toggle="tab">Rate</a>
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
                                       <div class="form-group">											 <label style="color:black; font-size:15px">Food</label>
										
                                          <div class="input-group">
                                             <div class="input-group-addon iga1">
                                                <span class="glyphicon glyphicon-cutlery"></span>
                                             </div>
                                             <?php 
											 $input_type = "food";
											 include("stars.php");
											 ?>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
								 
								 <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                       <div class="form-group">
									   <label style="color:black; font-size:15px">Price</label>
                                          <div class="input-group">
                                             <div class="input-group-addon iga1">
                                                <span class="fa fa-usd"></span>
                                             </div>
                                             <?php 
											 $input_type = "price";
											 include("stars.php")
											 ;?>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
								 
								 
								 <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                       <div class="form-group">
									   <label style="color:black; font-size:15px">Staff</label>
                                          <div class="input-group">
                                             <div class="input-group-addon iga1">
                                                <span class="fa fa-users"></span>
                                             </div>
                                             <?php 
											 $input_type = "staff";
											 include("stars.php");
											 ?>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
								 
								 <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                       <div class="form-group">
									   <label style="color:black; font-size:15px">Mood</label>
                                          <div class="input-group">
												<div class="input-group-addon iga1">
                                                <span style="font-size:18px" class="fa fa-smile-o"></span>
												</div>
												<?php 
												 $input_type = "mood";
												 include("stars.php");
												 ?>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
								 
								 <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                       <div class="form-group">
									   <label style="color:black; font-size:15px">Comments</label>
                                          <div class="input-group">

										  <div class="input-group-addon iga1">
                                                <span class="glyphicon glyphicon-comment"></span>
                                          </div>
											<textarea method="post" name="comments" id="comments" rows="5" placeholder="Comments" required></textarea>
                                          </div>
                                       </div>
                                    </div>
                                 </div>

                              <div class="row">
                                 <div class="col-xs-12 col-sm-12 col-md-12">
                                    <button type="submit" class="button burgundy solid text-center"> Rate </button>
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
									echo "You have successfully submited a review <a href='index.php'>Back to home.</a>";
								}
							}else {
								echo "You must have an account as a rater in order to submit a review. <a href = 'register.php'>Join Now!</a>";
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

   