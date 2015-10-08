<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="assets/ico/favicon.ico">

    <title>Logstaff</title>

    <?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('bs/bootstrap.min');
                echo $this->Html->css('bs/bootstrap-theme.min');
                echo $this->Html->css('styles');
                echo $this->Html->css('bs/carousel');
                echo $this->Html->css('carousel');
                echo $this->Html->css('font/css/font-awesome.min');
                
                
                echo $this->Html->css('chosen');
                echo $this->Html->css('fstyle/default/css/min');
                echo $this->Html->css('chosen');
                echo $this->Html->script('jquery',array('inline'=>false));
               
                echo $this->Html->script('jquery.uniform.min',array('inline'=>false));
                echo $this->Html->script('chosen.jquery',array('inline'=>false));
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>


    <!-- Bootstrap core CSS -->
    
  
    <link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type='text/css' />

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
   
  </head>

  <body role="document">
     <div id="wrapper">       
     
    <!-- Fixed navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.html"><span>L</span>ogstaff</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="index.html">Home<span class="caret"></span></a></li>            
            <li><a href="why-us.html">Why us?</a></li>
            <li><a href="our-prices.html">Our Prices</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="blog.html">Blog</a></li>
            <li><a href="contact.html">Contact</a></li>           
          </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="login.html"><i class="fa fa-lock"></i> Sign in</a></li>
                <li><a href="registration.html"><i class="fa fa-user"></i> Sign up</a></li>
            </ul>
          
        </div><!--/.nav-collapse -->

      </div>
    </div>
    <?php echo $this->element('banner'); ?>      
    
    <div class="container theme-showcase" role="main">
        <?php echo $this->fetch('content'); ?>
    </div> <!-- /container -->
    
    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-md-7">                     
                    <p>
                        &copy;  2014 <a href="index.html">Logstaff.com</a>, ALL Rights Reserved. 
                        <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a> | <a href="contact.html">Contact us</a>
                    </p>
                </div>
                <div class="col-md-5">  
                    <a href="index.html" class="pull-right"><span>L</span>ogstaff</a>
                </div>
            </div>
        </div>
    </div>
    
    
 </div><!-- /wrapper -->
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

    <?php echo $this->Html->script('back-to-top',array('inline'=>false)); ?>
   
   <div id="topcontrol" title="Scroll Back to Top">
       <button class="btn btn-default" type="button"><i class="fa fa-angle-up"></i></button>

     </div>
     
  </body>
</html>
