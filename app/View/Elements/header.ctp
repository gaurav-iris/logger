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
          <a class="navbar-brand" href="index.html"><span>l</span>ogstaff</a>
        </div>
        <div class="navbar-collapse collapse">
          <?php echo $menu; ?>
            
            <?php if($loggedIn): ?>
            <ul class="nav navbar-nav navbar-right">  
                <li class="divider-vertical"></li>
                <li><a href="#"><i class="fa fa-comments"></i><span class="label label-important">2</span></a></li>
                <li class="divider-vertical"></li>
                <li><a href="#"><i class="fa fa-envelope-o"></i><span class="label label-important">2 New</span></a></li>
                <li class="divider-vertical"></li>
                <li><a href="#"><i class="fa fa-refresh"></i><span class="label label-info">1 update</span></a></li>
                <li class="divider-vertical"></li>
                <li><a href="login.html"><i class="fa fa-lock"></i> Sign in</a></li>
                <li class="divider-vertical"></li>
                <li class="dropdown open tooltip-demo"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> Username <span class="caret"></span></a>
                </li>
            </ul>
          <?php endif; ?>
        </div><!--/.nav-collapse -->

      </div>
    </div>
    
    <!-- start breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <h1 class="pull-left"><i class="fa fa-home"></i>Dashboard</h1>
            <ul class="pull-right breadcrumb">
                <li><a href="index.html"><i class="fa fa-home"></i> Home</a></li>
                <li class="active">Dashboard</li>
            </ul>
        </div><!--/container-->
    </div>
    <!-- end breadcrumbs -->           
    <div style="min-height: 500px;" class="container theme-showcase" role="main">