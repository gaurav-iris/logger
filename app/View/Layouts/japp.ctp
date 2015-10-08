<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <?php if(isset($title)): ?><title><?php echo $title; ?></title><?php endif; ?>
        <link href='http://fonts.googleapis.com/css?family=Roboto|Roboto+Slab' rel='stylesheet' type='text/css'/>
        <?php echo $this->Html->css(array('jstyle','plugins','ft/font','chosen/chosen.min.css')); ?>
        <?php echo $this->element('japp/sc');  ?>
    </head> 
    <body></body>
</html>