<style type="text/css">
    .fileList{background-color: #f5f5f5; border-radius: 10px 10px; padding: 30px; float: left; width: 100%}
    .fileList img{float: left}
    .fileList .progress{float: left; width: 250px; height: 6px}
</style>
<div class="col-lg-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><a href="#"><img width="25" height="25" src="images/grv.jpg" alt="Gaurav Mehra"/> gauravmehra1987</a></h3>
            </div>
            <div class="panel-body p0">
             <ul class="list-group">
                <li class="list-group-item"><a href="#">Account settings </a></li>
                <li class="list-group-item"><a class="active" href="#">Profile</a></li>
                <li class="list-group-item"><a href="#">Emails </a></li>
                <li class="list-group-item"><a href="#">Billing</a></li>
                <li class="list-group-item"><a href="#">Organizations </a></li>
                <li class="list-group-item"><a href="#">Security</a></li>
             </ul>
            </div>
          </div>
    </div>
<?php echo $this->Html->script(array('upload')); ?>
      <div class="col-lg-9">
          <div class="panel panel-default">
                <div class="panel-heading">

                  <h3 class="panel-title"><i class="fa fa-user"></i> <?php echo __('Update Profile'); ?></h3>
                </div>
                <div class="panel-body">
<div class="users form">
<?php echo $this->Form->create('User',array('class'=>'form-horizontal group-border stripped','role'=>'form','enctype'=>'multipart/form-data')); ?>
	<fieldset>
 <div class="input text"><label for="profilepicture">Profile picture</label>
                    <img width="80" height="80" src="images/grv.jpg" alt="grv" class="avatar"/>
                    <div class="avatar-upload">
                      <a class="btn btn-default" href="#">
                        <label for="upload-profile-picture">
                          Upload new picture
                          <input type="file" class="manual-file-chooser js-manual-file-chooser js-avatar-field" multiple="multiple" id="upload-profile-picture">
                        </label>
                      </a>
                      <div class="upload-state default">
                        <p>You can also drag and drop a picture from your computer.</p>
                      </div>

                      <div class="upload-state loading">
                        <span class="button disabled">
                          <img width="16" height="16" src="https://assets-cdn.github.com/images/spinners/octocat-spinner-32.gif" alt=""> Uploading...
                        </span>
                      </div>

                      <div class="upload-state danger too-big">
                        Please upload a picture smaller than 1 MB.
                      </div>

                      <div class="upload-state danger bad-dimensions">
                        Please upload a picture smaller than 10,000x10,000.
                      </div>

                      <div class="upload-state danger bad-file">
                        Unfortunately, we only support PNG, GIF, or JPG pictures.
                      </div>

                      <div class="upload-state danger bad-browser">
                        This browser doesn't support uploading pictures.
                      </div>

                      <div class="upload-state danger failed-request">
                        Something went really wrong and we can't process that picture.
                      </div>
                    </div>
                 </div> 
		
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('first_name');
		echo $this->Form->input('last_name');
		echo $this->Form->input('email');
		echo $this->Form->input('image',array('type'=>'hidden','class'=>'avtar'));
                echo $this->Form->input('photo',array('class'=>'pic','type'=>'file'));
	?>
                
                    <div class="fileList">
                        <?php if($this->data['User']['image']): 
                        $image = "/".str_replace("\\","/", $this->data['User']['image']);
                        echo $this->Html->image($image, array('height'=>100,'fullBase' => true));
                        endif; ?>
                    </div>
                
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
               </div>
         </div>
      </div>

<script type="text/javascript">
    $('.pic').upload({'post':'<?php echo $this->Html->url(array("controller" => "tools","action" => "upload")); ?>','input':'.avtar'});
</script>