<?php echo $this->Html->script(array('bootstrap.min',
      'jquery-migrate-1.2.1.min',
      'circles',
      'circles-master','chosen/chosen.jquery.min','jquery.knob.min','app'
      )); ?>

<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('select').chosen();
        jQuery('.knob').knob();
//        App.init();
//        App.initCounter();
        CirclesMaster.initCirclesMaster1();
        CirclesMaster.initCirclesMaster2();
    });
</script>    
    <div id="topcontrol" title="Scroll Back to Top"><button class="btn btn-default" type="button"><i class="fa fa-angle-up"></i></button></div>
</body>
</html>