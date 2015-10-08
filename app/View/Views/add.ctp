<div class="views form">
<?php echo $this->Form->create('View'); ?>
	<fieldset>
		<legend><?php echo __('Add View'); ?></legend>
	<?php
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Views'), array('action' => 'index')); ?></li>
	</ul>
</div>
