<div class="container">
      <div class="row">
         <div class="col-md-6">
         <div class="panel with-nav-tabs panel-info">
			<div class="panel-body" style="border-color:transparent">
               <div class="tab-content">
                  <div id="rate_restaurant" class="tab-pane fade in active register">
                     <div class="container-fluid">
					 <form id="rateBoxForm" name="formID" method="post" action="" role="form">
                        <div class="row">    
                               <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                       <div class="form-group">											 <label style="color:black; font-size:15px">Rating</label>										
                                          <div class="input-group">
                                             <div class="input-group-addon iga1">
                                                <span class="glyphicon glyphicon-star"></span>
                                             </div>
												<input style="margin-left:10px" id="rate" name="rate" method = "post" type="number" class="rating" data-min="0" data-max="5" data-step="1" data-size="xs" data-show-clear="false" data-show-caption="false" required/>
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
											<textarea method="post" name="comments" id="comments" rows="5" placeholder="Comments"></textarea>
                                          </div>
                                       </div>
                                    </div>
                                 </div>

                              <div class="row">
                                 <div class="col-xs-12 col-sm-12 col-md-12">
                                    <button type="submit" style="border-radius:10px" class="btn col-sm-12 button burgundy solid"><strong>Rate Menu</strong></button>
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

   