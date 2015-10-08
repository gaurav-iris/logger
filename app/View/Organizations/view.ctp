<div class="row">
        <div class="col-lg-12">
            <!-- col-lg-12 start here -->
            <div class="panel panel-default">

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
        </div>
</div>
    
    <button class="btn btn-primary" data-toggle="modal" data-target=".invite">+ Invite User</button>

    <div class="modal fade invite" tabindex="-1" role="dialog" aria-labelledby="Invite New Members" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            <h2 id="myModalLabel" class="modal-title">Add Note</h2>
          </div>
          <div class="modal-body">
             <h4>Invite New Users</h4>
               <form role="form" class="form-horizontal group-border stripped">
                   <div>
                   <input type="text" name="email" placeholder="eg. steve@logstaff.com" />
                   </div>
                   
                   <div>
                       <select name="role_id"><option value="1">Organization Owner</option><option value="2">Moderator</option></select>
                   </div>
              </form>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officiis modi</p>


          </div>

          <div class="modal-footer">
            <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
            <button class="btn btn-primary" type="button">Save changes</button>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-lg-12">
        <h2>Users</h2>
        <div class="table-responsive">
                <table  class="table table-striped" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>Name</th>
                        <th>Total Hours</th>
                        <th>Last Activity</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($org['OrganizationUser'] as $key=>$item) : ?>
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php if($item['image']): ?><img src="<?php echo $this->Image->resize($item['image'],50); ?>" /><?php endif; ?></td>
                        <td><?php echo $item['first_name'] . ' ' . $item['last_name']; ?></td>
                        <td><?php echo $item['email']; ?></td>
                        <td><?php echo $item['role_id']; ?></td>
                        <td><a href="#">Manage</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                </table>
            </div>
    </div>
</div>