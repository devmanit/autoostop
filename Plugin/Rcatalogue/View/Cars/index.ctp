<div class="propertyCategories index">
	<h2><?php echo __('Property Categories'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
		<th><?php echo $this->Paginator->sort('id'); ?></th>
		<?php if($isAdmin == 1):?>
		<th><?php echo $this->Paginator->sort('user_id'); ?></th>
                <?php endif; ?>
                <th><?php echo $this->Paginator->sort('marque'); ?></th>
                <th><?php echo $this->Paginator->sort('matricule'); ?></th>
                <th><?php echo $this->Paginator->sort('year'); ?></th>
                <th><?php echo $this->Paginator->sort('color'); ?></th>
		<th><?php echo $this->Paginator->sort('created'); ?></th>
		<th class="actions"><?php echo __d('croogo', 'Actions'); ?></th>
	</tr>
	<?php foreach ($propertyCategories as $propertyCategory): ?>
	<tr>
		<td><?php echo h($car['Car']['id']); ?>&nbsp;</td>
		<?php if($isAdmin == 1):?>
		<td><?php echo h($car['Car']['user_id']); ?>&nbsp;</td>
                <?php endif; ?>
		<td><?php echo h($car['Car']['marque']); ?>&nbsp;</td>
                <td><?php echo h($car['Car']['matricule']); ?>&nbsp;</td>
                <td><?php echo h($car['Car']['year']); ?>&nbsp;</td>
                <td><?php echo h($car['Car']['color']); ?>&nbsp;</td>
		<td><?php echo h($car['Car']['created']); ?>&nbsp;</td>
		<td class="actions">
                        <?php if($isAdmin == 1):?>
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $propertyCategory['Car']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $propertyCategory['Car']['id'])); ?>
			<?php endif; ?>
                        <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $propertyCategory['Car']['id']), array(), __('Are you sure you want to delete # %s?', $propertyCategory['Car']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
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
		<li><?php echo $this->Html->link(__('New Property Category'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Property Categories'), array('controller' => 'cars', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Parent Property Category'), array('controller' => 'cars', 'action' => 'add')); ?> </li>
	</ul>
</div>
