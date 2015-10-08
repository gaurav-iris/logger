<html>
    <head>
        <title>Your are Invited to Logstaff!</title>
    </head>
    <body>
        <p><b><?php echo $user; ?></b> is using Logstaff to track time and projects within <b><?php echo $org['title']; ?></b>.</p>
        <p>This email is being sent to you because <b><?php echo $user; ?></b> is using Logstaff to track time and projects. <b><?php echo $user; ?></b> has invited you to collaborate on Logstaff.</p>
        <p>Logstaff makes it easy for virtual teams to work more efficiently by tracking time and projects. Over 2,000 remote teams use it daily.</p>
        <p>Please accept the invitation by clicking on the link below.</p>
        <p><a href="<?php echo Configure::read('config.home'); ?>invitation/verify/<?php echo $data['code']; ?>">Accept the invitation</a></p>
        <p>If the link is not directly clickable, please copy and paste into your browser address bar.</p>

        <p>Thanks & Regard<br/>
        Logstaff | Hansoftz<br/>
        Connect: 9958596630,9873468701<br/>
        Email: support@logstaff.com
        </p>
    </body>
</html>
