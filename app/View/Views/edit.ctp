<div class="views form">
<?php echo $this->Form->create('View'); ?>
	<fieldset>
		<legend><?php echo __('Edit View'); ?></legend>
	<?php
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('View.')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('View.'))); ?></li>
		<li><?php echo $this->Html->link(__('List Views'), array('action' => 'index')); ?></li>
	</ul>
</div>
