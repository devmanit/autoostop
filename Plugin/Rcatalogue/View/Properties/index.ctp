<div class="properties index">
	<h2><?php echo __('Properties'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('reference'); ?></th>
			<th><?php echo $this->Paginator->sort('property_category_id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('pstatus'); ?></th>
			<th><?php echo $this->Paginator->sort('size'); ?></th>
			<th><?php echo $this->Paginator->sort('rooms'); ?></th>
			<th><?php echo $this->Paginator->sort('pricedt'); ?></th>
			<th><?php echo $this->Paginator->sort('priceeuro'); ?></th>
			<th><?php echo $this->Paginator->sort('description'); ?></th>
			<th><?php echo $this->Paginator->sort('status'); ?></th>
			<th><?php echo $this->Paginator->sort('updated'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($properties as $property): ?>
	<tr>
		<td><?php echo h($property['Property']['id']); ?>&nbsp;</td>
		<td><?php echo h($property['Property']['reference']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($property['PropertyCategory']['name'], array('controller' => 'property_categories', 'action' => 'view', $property['PropertyCategory']['id'])); ?>
		</td>
		<td><?php echo h($property['Property']['name']); ?>&nbsp;</td>
		<td><?php echo h($property['Property']['pstatus']); ?>&nbsp;</td>
		<td><?php echo h($property['Property']['size']); ?>&nbsp;</td>
		<td><?php echo h($property['Property']['rooms']); ?>&nbsp;</td>
		<td><?php echo h($property['Property']['pricedt']); ?>&nbsp;</td>
		<td><?php echo h($property['Property']['priceeuro']); ?>&nbsp;</td>
		<td><?php echo h($property['Property']['description']); ?>&nbsp;</td>
		<td><?php echo h($property['Property']['status']); ?>&nbsp;</td>
		<td><?php echo h($property['Property']['updated']); ?>&nbsp;</td>
		<td><?php echo h($property['Property']['created']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $property['Property']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $property['Property']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $property['Property']['id']), array(), __('Are you sure you want to delete # %s?', $property['Property']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Property'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Property Categories'), array('controller' => 'property_categories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Property Category'), array('controller' => 'property_categories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Property Addresses'), array('controller' => 'property_addresses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Property Address'), array('controller' => 'property_addresses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Property Images'), array('controller' => 'property_images', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Property Image'), array('controller' => 'property_images', 'action' => 'add')); ?> </li>
	</ul>
</div>
