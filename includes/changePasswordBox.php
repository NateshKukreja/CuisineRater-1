
<div class="container">
      <div class="row">
         <div class="col-md-6">
         <div class="panel with-nav-tabs panel-info">
            <div class="panel-heading">
               <ul class="nav nav-tabs">
			   <li class="active">
			   <?php 
					if(isset($name))
						echo '<a href="#change_pass" data-toggle="tab"> Change Password </a>';
				?>
				</li>
               </ul>
            </div>
			<div class="panel-body">
               <div class="tab-content">
			<?php 
					if(isset($name))
						echo '
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
                                             <input type="password" class="form-control" placeholder="Current Password" name="pass">
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
                                             <input type="password" class="form-control" placeholder="New Password" name="new_pass">
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
                                    <button type="submit" class="btn btn-success btn-block btn-lg"> Save </button>
                                 </div>
                              </div>

                        </div>
						</form>
                     </div> 
                  </div>
				  
				  ';
				  ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
   
   