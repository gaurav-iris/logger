<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="http://bxslider.com/lib/jquery.bxslider.css" />
    <script type="text/javascript" src="http://bxslider.com/lib/jquery.bxslider.js"></script>
<div class="container min"  role="main">
        <div class="title-box-v2">
            <h2>User <span class="color-green">Activities</span></h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
        </div>
        <div class="row high-rated margin-bottom-20">
            <div class="load-more"><h2>Tue, Sep 30 2014</h2></div>
               
            
            <?php foreach($activities as $time=>$activities) : ?>
            <div style="width: 100%; float: left;" class="awrap">
            <div style="width: 100%" class="headline"><h2><?php echo ($time>12)?$time-12:$time; echo ($time>12)?' pm':' am'; ?></div>
            
                <?php if($activities): for($i=0; $i<6; $i++): ?>
                <?php //some important calcs
                if(isset($activities[$i])){ $activity = $activities[$i];
                $mouse = round($activity['mouse']/600*100);
                $keys = round($activity['keys']/600*100);
                $average = round(sqrt(pow($mouse,2)+ pow($keys,2)));
                ?>
            <div class="col-md-4">
                <div class="act-list">
                    <div class="act-green">
                        <?php echo ($time>12)?$time-12:$time; ?>:<?php echo $i; ?>0
                        <?php echo ($time>12)?' pm':' am'; ?>
                        --
                        <?php echo ($time>12)?$time-12:$time; ?>:<?php echo $i+1; ?>0
                        <?php echo ($time>12)?' pm':' am'; ?>
                    </div>                
                    <div class="slider">
                        <?php foreach ($activity['screenshot'] as $key=>$shot): ?>
                        <a data-lightbox="roadtrip" href="<?php if(isset($activity['lightbox'][$key])) echo $activity['lightbox'][$key]; ?>"><img src="<?php echo $shot; ?>" alt="project" /></a>
                        <?php  endforeach; ?>
                    </div>
                    <div class="act-h">
                        <h3><?php echo $activity['project_title']; ?></h3>
                        
                    </div>     
<!--                    <ul class="list-unstyled">
                        <li><span class="cb">Position:</span> Manager / Executive</li>
                        <li><span class="cb">Date:</span>10/05/2014</li>
                    </ul> -->
                    <hr/>
                    <div class="col-md-12 margin-bottom-10">
                        <h3 class="h-xs">Mouse - <?php echo $mouse; ?>%</h3>
                        <div class="progress progress-striped active">
                                <div style="width: <?php echo $mouse; ?>%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="<?php echo $mouse; ?>" role="progressbar" class="progress-bar progress-bar-success">
                                    <span class="sr-only"><?php echo $mouse; ?>% Complete (success)</span>
                                </div>
                        </div>
                        
                        <h3 class="h-xs">Keyboard - <?php echo $keys; ?>%</h3>
                        <div class="progress progress-striped active">
                                <div style="width: <?php echo $keys; ?>%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="<?php echo $keys; ?>" role="progressbar" class="progress-bar progress-bar-info">
                                    <span class="sr-only"><?php echo $keys; ?>% Complete (success)</span>
                                </div>
                        </div>
                        <h3 class="h-xs">overall - <?php echo $average; ?>%</h3>
                        <div class="progress progress-striped active">
                                <div style="width: <?php echo $average; ?>%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="<?php echo $average; ?>" role="progressbar" class="progress-bar progress-bar-danger">
                                    <span class="sr-only"><?php echo $average; ?>% Complete (success)</span>
                                </div>
                        </div>
                    </div>
                 </div>
            </div>
            
            <?php }else{ ?>
            <div style="height: 400px;" class="col-lg-2"> 
                 <div class="null">No Activity</div>
             </div>
            <?php } ?>
            <?php endfor; endif; ?>
            </div>
        <?php endforeach; ?>
        </div><!-- /row repeat -->            
               
</div> <!-- /container -->
    
<script type="text/javascript">
$(document).ready(function(){
    $('.slider').bxSlider({
      slideWidth: 366,
      minSlides: 1,
      maxSlides: 4,
      slideMargin: 10,controls:false,preloadImages:'all'
    });
});
</script>

<?php 
    echo $this->Html->css(array('lb/lightbox'));
    echo $this->Html->script('lightbox.min');
?>
    