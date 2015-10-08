<pre>
<?php if(isset($verified)): ?>
    <p>Welcome <strong> <?php echo $user['first_name'] . ' ' . $user['last_name'] ; ?></strong>,

Thanks for verifying your email address with Logstaff. <br/>
You are now ready to use our services.
Lets get started.. <a href="<?php echo Configure::read('config.home'); ?>auth/login">click here</a> to login and start new journey with us :)
</p>
<?php else: ?>
    Invalid Verification Code, Please contact administrator.
<?php endif; ?>
</pre>