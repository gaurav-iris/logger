<div class="timesheets index">
        <div class="headline"><h2><?php echo __('Timesheets'); ?> - <?php echo date('D-d M, Y') ?></h2></div>
        <div class="table-responsive">
	<table  class="table table-striped" cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('project_id'); ?></th>
			<th><?php echo $this->Paginator->sort('start'); ?></th>
			<th><?php echo $this->Paginator->sort('end'); ?></th>
			<th><?php echo $this->Paginator->sort('duration'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($timesheets as $timesheet): ?>
	<tr>
		<td><?php echo h($timesheet['Timesheet']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($timesheet['Project']['title'], array('controller' => 'projects', 'action' => 'view', $timesheet['Project']['id'])); ?>
		</td>
		
		
		<td><?php echo h($timesheet['Timesheet']['start']); ?>&nbsp;</td>
		<td><?php echo h($timesheet['Timesheet']['end']); ?>&nbsp;</td>
		<td><?php echo h(gmdate("H:i:s", $timesheet['Timesheet']['duration'])); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $timesheet['Timesheet']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $timesheet['Timesheet']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $timesheet['Timesheet']['id']), array(), __('Are you sure you want to delete # %s?', $timesheet['Timesheet']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
        </div>
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
        
        <?php //echo $this->element('sql_dump'); ?>
</div>