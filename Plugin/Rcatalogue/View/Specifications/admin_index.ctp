<?php
$this->viewVars['title_for_layout'] = __d('croogo', 'Specifications');
$this->extend('/Common/admin_index');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Specifications'), array('action' => 'index'));

?>

<div class="specifications index">
	<table class="table table-striped">
	<tr>
		<th><?php echo $this->Paginator->sort('id'); ?></th>
		<th><?php echo $this->Paginator->sort('nom'); ?></th>
		<th><?php echo $this->Paginator->sort('created'); ?></th>
		<th class="actions"><?php echo __d('croogo', 'Actions'); ?></th>
	</tr>
	<?php foreach ($specifications as $specification): ?>
	<tr>
		<td><?php echo h($specification['Specification']['id']); ?>&nbsp;</td>
		<td><?php echo h($specification['Specification']['nom']); ?>&nbsp;</td>
		<td><?php echo h($specification['Specification']['created']); ?>&nbsp;</td>
		<td class="item-actions">
			<?php echo $this->Croogo->adminRowAction('', array('action' => 'view', $specification['Specification']['id']), array('icon' => 'eye-open')); ?>
			<?php echo $this->Croogo->adminRowAction('', array('action' => 'edit', $specification['Specification']['id']), array('icon' => 'pencil')); ?>
			<?php echo $this->Croogo->adminRowAction('', array('action' => 'delete', $specification['Specification']['id']), array('icon' => 'trash', 'escape' => true), __d('croogo', 'Are you sure you want to delete # %s?', $specification['Specification']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
</div>
