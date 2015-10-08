<div class="row">
<!--                 <div class="alert alert-danger">
                     Your free trial for <strong>abc</strong> expires in 4 days. <a href="#">Choose a plan</a>
                    
                  </div>
                  <div class="alert alert-info">
                    <i class="fa fa-globe"></i> Time totals on this screen will not match reports if you are in a different timezone than the organization. <a href="#">View reports</a> for this day.
                  </div>
                 <div class="alert alert-success">
                    <strong>Well done!</strong> You successfully read this important alert message.
                  </div>-->
                 
            <!-- End Alerts -->
            <!-- col-lg-6 start here -->
            <div class="col-lg-6 col-md-6 pdr">
                  <a href="#" class="prev btn btn-default"><i class="fa fa-arrow-left"></i></a>    
                  <a  href="#" class="next btn btn-default"><i class="fa fa-arrow-right"></i></a>
                  <span class="dte">Tue, Sep 30 2014</span>
                  <span class="tz">IST</span>
                  <a href="#" id="datepicker" class="btn btn-default">Change <i class="fa fa-calendar"></i></a>
                  <a id="today" href="#" class="btn btn-default">Today</a>
                  <a class="btn btn-default a-tooltip" href="#" data-original-title="View all notes" data-toggle="tooltip" data-placement="bottom">All notes</a>
                    
            </div><!-- col-lg-6 end here -->
            <!-- col-lg-6 start here -->
            <div class="col-lg-6 col-md-6 pdl">
                <!-- start filters-->
                <div class="filters">
                    <form id="filters" method=" " action=" ">
                        <i class="fa fa-folder"></i>
                        <select id="projects" data-placeholder="All Projects" class="select2 select2-offscreen" tabindex="-1">
                            <option value="">All Projects</option>
                            <option value="">wwwalls</option>
                            <option value="">Zippy</option>
                            <option value="">Hansoftz</option>
                            <option value="">Story</option>                
                        </select>
                        <i class="fa fa-user"></i>
                        <select name="" id="user" data-placeholder="All Users" class="select2 select2-offscreen" tabindex="-1">
                            <option value="All Users">All Users</option>
                            <option value="gaurav">Gaurav</option>
                            <option value="Sandeep">Sandeep</option>
                            <option value="gaurav">Gaurav</option>
                        </select>
                        <span class="label">Time Zone</span>
                        <select name="time_zone" id="time_zone" tabindex="1" class="chosen-select" data-placeholder="Choose a Country...">
                        <option value=""></option>
                        <option value="United States">United States</option>
                        <option value="United Kingdom">United Kingdom</option>
                        <option value="Afghanistan">Afghanistan</option>
                        <option value="Aland Islands">Aland Islands</option>
                        <option value="Albania">Albania</option>
                        <option value="Algeria">Algeria</option>
                        <option value="American Samoa">American Samoa</option>
                        <option value="Andorra">Andorra</option>
                        <option value="Angola">Angola</option>
                        <option value="Anguilla">Anguilla</option>
                        <option value="Antarctica">Antarctica</option>
                        <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                        <option value="India">India</option>
                      </select>
                 
                      
                     </form>   
                </div>
                <!-- end filters-->
            </div><!-- col-lg-6 end here -->
            <div id="thours" class="thours btn alert alert-info" tabindex="0" data-placement="bottom" data-toggle="popover" data-trigger="focus" title="Total Hours" data-content="Well done! You successfully completeing tasks.. It's very engaging"><i class="fa fa-clock-o"></i></div>
           
            <div class="activity-col">
                <?php //print_r($activities);
                foreach($activities as $time=>$activities) : ?>
                <div class="row">
                    <div class="headline"><h2><?php echo ($time>12)?$time-12:$time; echo ($time>12)?' pm':' am'; ?></h2></div>
                       <ul>
                           <?php if($activities): for($i=0; $i<6; $i++): ?>
                           <?php //some important calcs
                           if(isset($activities[$i])){ $activity = $activities[$i];
                           $mouse = round($activity['mouse']/600*100);
                           $keys = round($activity['keys']/600*100);
                           $average = round(sqrt(pow($mouse,2)+ pow($keys,2)));
                           ?>
                            <li class="col-lg-2"> 
                                 <a data-lightbox="roadtrip" href="<?php if(isset($activity['lightbox'][0])) echo $activity['lightbox'][0]; ?>"><img height="143" src="<?php if(isset($activity['screenshot'][0])) echo $activity['screenshot'][0]; ?>" alt="project" class="img-thumbnail"/></a>
                                 <div class="pn"><?php echo $activity['project_title']; ?></div>
                                <span class="time"> 
                                    <?php echo ($time>12)?$time-12:$time; ?>:<?php echo $i; ?>0
                                    <?php echo ($time>12)?' pm':' am'; ?>
                                    --
                                    <?php echo ($time>12)?$time-12:$time; ?>:<?php echo $i+1; ?>0
                                    <?php echo ($time>12)?' pm':' am'; ?></span>
                                </span>
                                
                                <div class="info">
                                    <code>Mouse:<strong><?php echo $mouse; ?>%</strong></code>
                                    <code>Keyboard:<strong><?php echo $keys; ?>%</strong></code>
                                    <code>Overall:<strong><?php echo $average; ?>%</strong></code>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-success a-tooltip" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $average; ?>%" data-toggle="tooltip" data-placement="bottom" data-original-title="Overall: 50% <br /> Mouse: 82% Keyboard: 53%"><span class="sr-only"><?php echo $average; ?>% Complete (success)</span></div>
                                    
                                </div>
                                <div class="controls">
                                    <a data-placement="bottom" data-toggle="tooltip" data-original-title="Filter by project to delete activity" href="#" class="btn alert-danger a-tooltip"><i class="fa fa-clock-o"></i></a>
                                    <a data-placement="bottom" data-toggle="tooltip" data-original-title="Add Note" href="#" class="btn alert-info a-tooltip"><i class="fa fa-pencil"></i></a>
                                    <a data-toggle="modal" data-target="#myModal" title="Notes" href="#" class="btn btn-default"><i class="fa fa-edit"></i></a>
                             
                                </div>
                                    
                            </li>
                           <?php }else{ ?>
                           <li class="col-lg-2"> 
                                <div class="null">No Activity</div>
                            </li>
                           <?php } ?>
                            <?php endfor; endif; ?>
                       </ul>
                </div>
                <?php endforeach; ?>
            </div>
               
            <!-- Start Modal -->
                                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h2 class="modal-title" id="myModalLabel">Add Note</h2>
                                          </div>
                                          <div class="modal-body">
                                             <h4>Project: Logstaff</h4>
                                               <form class="form-horizontal group-border stripped" role="form">
                                                  <div class="form-group">
                                                    <label class="col-lg-2 col-md-2 col-sm-12 control-label">Description</label>
                                                    <div class="col-lg-10 col-md-10">
                                                        <textarea class="form-control" rows="3"></textarea>
                                                    </div>
                                                  </div>   
                                              </form>
                                              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officiis modi</p>
                                              

                                          </div>

                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Save changes</button>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <!-- end Modal -->
        </div><!-- /row -->
        
<?php 
    echo $this->Html->css(array('lb/lightbox'));
    echo $this->Html->script('lightbox.min');
?>