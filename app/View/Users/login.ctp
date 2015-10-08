<?php echo $this->Html->css(array('css/signin.css')); ?>
<div class="row forms">
<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
    <?php echo $this->Session->flash('auth'); ?>
    <?php echo $this->Form->create('User',array('class'=>'form-signin','role'=>'form')); ?>
             
                
                    <h2 class="form-signin-heading">Login to your account</h2>                   
                    <input type="text" name="data[User][username]" class="form-control" placeholder="Email address" required autofocus>
                    <input name="data[User][password]" maxlength="255" type="password" class="form-control" placeholder="Password" required>
                    <label class="checkbox">
                      <input type="checkbox" value="remember-me">  Stay signed in
                    </label>
                    <?php echo $this->Form->input('Login',array('type'=>'submit','class'=>'btn btn-lg btn-primary btn-block')); ?>
                    <hr>
                    <p><strong>Forget your Password ?</strong><br> no worries,<a href="forget.html" class="color-green"><strong> click here</strong></a> to reset your password.</p>
    

            </div>
         </div>

<?php echo $this->Form->end(); ?>
