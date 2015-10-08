<div class="views view">
<h2><?php echo __('View'); ?></h2>
	<dl>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit View'), array('action' => 'edit', $view['View'][''])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete View'), array('action' => 'delete', $view['View']['']), array(), __('Are you sure you want to delete # %s?', $view['View'][''])); ?> </li>
		<li><?php echo $this->Html->link(__('List Views'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New View'), array('action' => 'add')); ?> </li>
	</ul>
</div>
