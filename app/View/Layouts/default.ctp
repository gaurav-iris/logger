<?php 
    echo $this->element('head'); 
    echo $this->element('header');
    echo $this->Session->flash();
    echo $this->fetch('content');
    
    echo $this->element('footer'); 
    echo $this->element('foot');
?>