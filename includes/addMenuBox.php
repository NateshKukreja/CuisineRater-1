<div class="container">
      <div class="row">
         <div class="col-md-6">
         <div class="panel with-nav-tabs panel-info">
			<div class="panel-body" style="border-color:transparent">
               <div class="tab-content">
                  <div id="rate_restaurant" class="tab-pane fade in active register">
                     <div class="container-fluid">
					 <form id="addMenuBoxForm" name="formID" method="post" action="" role="form">
                        <div class="row">    
                               <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                       <div class="form-group">											 <label style="color:black; font-size:15px">Name</label>										
                                          <div class="input-group">
                                             <div class="input-group-addon iga1">
                                                <span class="glyphicon glyphicon-cutlery"></span>
                                             </div>
												<input name ="name" type="text" class="form-control"  required autofocus/>
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
											<input name="addPrice" type="text" class="form-control"  placeholder="eg:10.00" required />
											</div>
                                       </div>
                                    </div>
                                 </div>
								 
								<div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                       <div class="form-group">
									   <label style="color:black; font-size:15px">Food Type</label>
                                          <div class="input-group">
												<div class="input-group-addon iga1">
                                                <span style="font-size:18px" class="fa fa-question"></span>
												</div>
												<select name="type" method= "post" class="form-control">
												<option>Other</option>
												<option>Appetizer</option>
												<option>Entree</option>
												<option>Dessert</option>
												<option>Beverage</option>
												<option>Alcoholic</option>
											</select>	
                                          </div>
                                       </div>
                                    </div>
                                 </div>
								
								 <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                       <div class="form-group">
									   <label style="color:black; font-size:15px">Description</label>
                                          <div class="input-group">
                                             <div class="input-group-addon iga1">
                                                <span style="font-size:15px"class="fa fa-info-circle"></span>
                                             </div>
											<textarea name ="description" type="text" class="form-control"  placeholder="How would you describe it?" rows="5" required></textarea>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
								 								 
                              <div class="row">
                                 <div class="col-xs-12 col-sm-12 col-md-12">
                                    <button type="submit" style="border-radius:10px" class="btn col-sm-12 button burgundy solid"><strong>Add</strong></button>
                                 </div>
                              </div>							  			
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

   