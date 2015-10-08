<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php if(isset($title)): ?><title><?php echo $title; ?></title><?php endif; ?>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <?php 
         echo $this->Html->css(array('style','plugins','font-awesome/css/font-awesome.min','css/bootstrap.min','css/bootstrap-theme.min','css/plugins','chosen/chosen.min'));
         echo $this->Html->script('jquery.min');
    ?>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
                
</head>
    <body role="document">