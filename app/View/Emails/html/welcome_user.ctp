<html>
    <head>
        <title>Welcome user</title>
    </head>
    <body>
        <h3>Welcome <?php echo $user['User']['first_name'] . ' '. $user['User']['last_name']; ?>,</h3>
        <p>Welcome and thank you for registering at Logstaff!</p>
        <br/>
        <p>Your account has been created, <a href="<?php echo Configure::read('config.home'); ?>signup/verify/<?php echo $user['User']['code']; ?>">Click here</a> lo verify your email address and login to your account</p>
        <br/>
        
        <p>Thanks & Regard<br/>
        Logstaff | Hansoftz<br/>
        Connect: 9958596623,9873468701<br/>
        Email: logstaff@hansoftz.com
        </p>
    </body>
</html>
