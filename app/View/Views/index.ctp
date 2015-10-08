<div class="views index">
	<h2><?php echo __('Views'); ?></h2>
	<table  class="table-striped noborder" cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($views as $view): ?>
	<tr>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $view['View'][''])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $view['View'][''])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $view['View']['']), array(), __('Are you sure you want to delete # %s?', $view['View'][''])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New View'), array('action' => 'add')); ?></li>
	</ul>
</div>
