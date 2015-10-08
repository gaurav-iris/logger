<div class="row"> 
                 
             <!-- Start Tabs -->
                <div class="tabs margin-bottom-20">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#active" data-toggle="tab">Active</a></li>
                        <li class=""><a href="#archived" data-toggle="tab">Archived</a></li>
                    </ul>                
                    <div class="tab-content org">
                        <div class="tab-pane fade active in" id="active">
                            <div id="org" class="f-org">
                                    <div class="u-cnt lt">
                                        <div class="title">Create new Organization <span class="text">—for all your Companies to work on.</span><a class="help-block">Learn more</a></div>
                                        <a class="create-new" href="<?php echo $this->Html->url(array("controller" => "organizations","action" => "create")); ?>" title="Create a new"><i class="fa fa-plus-circle"></i><span>Create a New</span></a>
                                        
                                    
                                    </div>
                            </div><!-- End org -->
                            <?php foreach ($orgs as $org): ?>
                            <div id="org">
                                <div class="u-info">
                                    <div class="u-img">
                <?php if($org['Organization']['logo']): ?>
                      <img src="<?php echo $this->Image->resize($org['Organization']['logo'],150); ?>" />
                <?php endif; ?>
                                    </div>
                                    <div class="u-name"><?php echo $org['Organization']['title']; ?></div>
                                    <?php if($user_id == $org['Organization']['user_id']) : ?>
                                    <div class="pull-right">
                                        <a data-placement="bottom" data-toggle="tooltip" data-original-title="Choose a Plan for this organization" href="#" class="btn btn-success a-tooltip"><i class="fa fa-chain"></i> Choose a plan</a>
                                        <a data-placement="bottom" data-toggle="tooltip" data-original-title="Manage the billing for this organization" href="#" class="btn btn-danger a-tooltip"><i class="fa fa-credit-card"></i> Manage billing</a>
                                    </div>
                                    <?php endif; ?>
                                     <div class="u-cnt pull-right">
                                            <div class="title"><i class="fa fa-plus-square"></i> Create new Organization <span class="text">—for all your Companies to work on.</span></div>

                                     </div>
                                     <hr>
                                    <a class="o-name" href="<?php echo $this->Html->url(array("controller" => "organizations","action" => $org['Organization']['slug'])); ?>"><?php echo $org['User']['username']; ?> / <?php echo $org['Organization']['slug']; ?></a>
                                 
                                  </div><!-- End u-info --> 
                                
                                  <div class="info-bar">
                                    <ul>
                                        <li><a href="#"><span class="value"><?php echo count($org['OrganizationUser']); ?></span><span class="labl">Users</span></a></li>
                                        <li><a href="#" class="active"><span class="value"><?php echo count($org['Project']); ?></span><span class="labl">Projects</span></a></li>
                                        <li><a href="#"><span class="value">Last active</span><span class="labl">4:23 pm</span></a></li>
                                        <li><a href="#"><span class="value">Created on</span><span class="labl">10/08/14</span></a></li>
                                        <li><a href="#"><span class="value">Plan</span><span class="labl">Solo Lite plan</span></a></li>
                                    </ul>
                                  </div>
                                
                            </div> <!-- End Org --> 
                           
                            <?php endforeach; ?>
                                                   
                        </div>
                        <div class="tab-pane fade" id="archived">
                            
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                                        <div id="org">
                                <div class="u-info">
                                    <div class="u-img">
                                        <img src="images/user.jpg" alt="user"/>
                                    </div>
                                    <div class="u-name">Sandeep Kaur</div>
                                   
                                    <div class="pull-right">
                                        <a data-placement="bottom" data-toggle="tooltip" data-original-title="Choose a Plan for this organization" href="#" class="btn btn-success a-tooltip"><i class="fa fa-chain"></i> Choose a plan</a>
                                        <a data-placement="bottom" data-toggle="tooltip" data-original-title="Manage the billing for this organization" href="#" class="btn btn-danger a-tooltip"><i class="fa fa-credit-card"></i> Manage billing</a>
                                       
                                    </div>

                                     <hr>
                                    <a class="o-name" href="#">wwwalls</a>
                                       <div class="mem-org no-bg">
                                                 <h3>Members</h3>
                                              <ul>
                                                  <li>
                                                      <a title="Added by" href="#">  
                                                        <div class="t-img">
                                                            <img title="image" alt="grv" src="images/grv1.jpg"/>
                                                        </div>
                                                       
                                                    </a>                                              
                                                  </li>
                                                 <li>
                                                      <a title="Added by" href="#">  
                                                        <div class="t-img">
                                                            <img title="image" alt="grv" src="images/user.jpg"/>
                                                        </div>
                                                  
                                                    </a>                                              
                                                  </li>
                                                         <li>
                                                      <a title="Added by" href="#">  
                                                        <div class="t-img">
                                                            <img title="image" alt="grv" src="images/1.jpg"/>
                                                        </div>
                                                   
                                                    </a>                                              
                                                  </li>
                                                 <li>
                                                      <a title="Added by" href="#">  
                                                        <div class="t-img">
                                                            <img title="image" alt="grv" src="images/3.jpg"/>
                                                        </div>
                                                        
                                                    </a>                                              
                                                  </li>
                                                     <li>
                                                      <a title="Added by" href="#">  
                                                        <div class="t-img">
                                                            <img title="image" alt="grv" src="images/3.jpg"/>
                                                        </div>
                                                       
                                                    </a>                                              
                                                  </li>
                                            
                                              </ul>
                                          </div><!-- End members -->                                  

                                  </div><!-- End u-info --> 
                                  <div class="members">
                                      <ul>
                                          <li>
                                              
                                          </li>
                                          
                                          
                                  
                                      </ul>
                                  </div><!-- End members --> 
                                  <div class="info-bar">
                                      <ul>
                                          <li><a href="#"><span class="value">3</span><span class="labl">Organizations</span></a></li>
                                         <li><a href="#" class="active"><span class="value">2</span><span class="labl">Projects</span></a></li>
                                           <li><a href="#"><span class="value">Last active</span><span class="labl">4:23 pm</span></a></li>
                                             <li><a href="#"><span class="value">Created on</span><span class="labl">10/08/14</span></a></li>
<!--                                               <li><a href="#"><span class="value">Plan</span><span class="labl">Solo Lite plan</span></a></li>-->
                                      </ul>
                                  </div>
                                
                            </div> <!-- End Org --> 
                        </div>

                      
                    </div>
                </div>
                <!-- End Tabs -->   

</div><!-- /row -->