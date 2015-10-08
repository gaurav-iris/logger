<?php echo $this->Html->css(array('css/signin.css')); ?>
<?php if(isset($invited)): ?>
<div class="users form">
    <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
<?php echo $this->Form->create('User',array('action'=>"signup",'class'=>'form-signin')); ?>
    <h2 class="form-signin-heading">Please Register a new account</h2>
    <p>Already Signed Up? Click <a href="/auth/login" class="color-green">Sign In</a> to login your account.</p>
        <?php
        echo $this->Form->input('first_name',array('label'=>false,'placeholder'=>'First Name','required'=>'true'));
        echo $this->Form->input('last_name',array('label'=>false,'placeholder'=>'Last Name'));
        echo $this->Form->input('username',array('label'=>false,'placeholder'=>'Username','required'=>'true'));
        echo $this->Form->input('email',array('label'=>false,'placeholder'=>'Email','readonly'=>true,'value'=>$invitation['email']));
        echo $this->Form->input('password',array('label'=>false,'placeholder'=>'Password'));
        echo $this->Form->input('password_confirm',array('type'=>'password','label'=>false,'placeholder'=>'Confirm Password'));
        echo $this->Form->input('SignUp',array('label'=>false,'type'=>'submit','class'=>'btn btn-lg btn-primary btn-block'));
        echo $this->Form->input('code',array('type'=>'hidden','value'=>$invitation['code']));
        ?>
    
<?php echo $this->Form->end(); ?>
    </div>
</div>
<?php else: ?>
Error 304: Invalid Code
<?php endif; ?>