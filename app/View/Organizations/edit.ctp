<?php //echo $this->Upload->view('Organization', $company['Organization']['id']); ?>
<?php echo $this->Html->script(array('upload')); ?>
<div class="row">
        <div class="col-lg-9">
            <!-- col-lg-12 start here -->
            <div class="panel panel-default">
                <!-- Start .panel -->
                <div class="panel-heading">
                    <h4 class="panel-title">Create New Organization</h4>
                <div class="panel-controls"><a href="#" class="panel-refresh"><i class="im-spinner12"></i></a><a href="#" class="toggle panel-minimize"><i class="im-minus"></i></a><a href="#" class="panel-close"><i class="im-close"></i></a></div>
                </div>
                <div class="panel-body pb0">
                   <?php echo $this->Form->create('Organization',array('class'=>'form-horizontal group-border stripped','role'=>'form','enctype'=>'multipart/form-data')); 
                    echo $this->Form->input('id');
                   ?>
                        <div class="form-group">
                            <label for="textfield" class="col-sm-2 control-label">Title</label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('title',array('div'=>false,'label'=>false,'class'=>'form-control')); ?>
                                <span class="help-block"><em>Define the title of the organization/company here.</em></span>
                            </div>
                        </div>
                        <!-- End .form-group  -->
                        <div class="form-group">
                            <label for="emailfield" class="col-sm-2 control-label">Some words about the Organization:</label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('description',array('div'=>false,'label'=>false,'class'=>'form-control')); ?>
                            </div>
                        </div>
                        <!-- End .form-group  -->
                        <div class="form-group">
                            <label for="emailfield" class="col-sm-2 control-label">Timezone:</label>
                            <div class="col-sm-10">
                                <?php echo $this->Form->input('timezone_id',array('div'=>false,'label'=>false,'class'=>'form-control')); ?>
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <label class="col-lg-2 col-md-2 col-sm-12 control-label">Logo</label>
                            <div class="col-lg-10 col-md-10">
                                <?php echo $this->Form->input('logo',array('div'=>false,'label'=>false,'class'=>'fileInput','type'=>'hidden')); ?>
                                <?php echo $this->Form->input('user_id',array('type'=>'hidden','value'=>$user_id)); ?>
                                <input class="uploadme" type="file" multiple="false" name="files" />
                                        <div class="fileList"><ul>
                                    <?php if($this->data['Organization']['logo']): ?>
                                        <img src="<?php echo $this->Image->resize($this->data['Organization']['logo'],100); ?>" />
                                   <?php endif; ?>
                                    </ul></div>
                            </div>
                        </div>
                    <?php echo $this->Form->end(_('Create')); ?>
                </div>
            </div>
            <!-- End .panel -->
        </div>
        <!-- col-lg-12 end here -->
    </div>

<script type="text/javascript">
    $('.uploadme').upload({'post':'<?php echo $this->Html->url(array("controller" => "tools","action" => "upload")); ?>','input':'.fileInput'});
</script>