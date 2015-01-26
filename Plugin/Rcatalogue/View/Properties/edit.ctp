<?php
$this->viewVars['title_for_layout'] = __d('croogo', 'Properties');
$this->extend('/Common/admin_edit');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Properties'), array('action' => 'index'));

if ($this->action == 'admin_edit') {
	$this->Html->addCrumb($this->data['Property']['name'], '/' . $this->request->url);
	$this->viewVars['title_for_layout'] = 'Properties: ' . $this->data['Property']['name'];
} else {
	$this->Html->addCrumb(__d('croogo', 'Add'), '/' . $this->request->url);
}

echo $this->Form->create('Property');

?>
<div class="properties row-fluid">
	<div class="span8">
		<ul class="nav nav-tabs">
		<?php
			echo $this->Croogo->adminTab(__d('croogo', 'Property'), '#property');
			echo $this->Croogo->adminTabs();
		?>
		</ul>

		<div class="tab-content">
			<div id='property' class="tab-pane">
			<?php
				echo $this->Form->input('id');
				$this->Form->inputDefaults(array('label' => false, 'class' => 'span10'));
				echo $this->Form->input('reference', array(
					'label' => 'Reference',
				));
				echo $this->Form->input('property_category_id', array(
					'label' => 'Property Category Id',
				));
				echo $this->Form->input('name', array(
					'label' => 'Name',
				));
				echo $this->Form->input('pstatus', array(
					'label' => 'Pstatus',
				));
				echo $this->Form->input('size', array(
					'label' => 'Size',
				));
				echo $this->Form->input('rooms', array(
					'label' => 'Rooms',
				));
				echo $this->Form->input('pricedt', array(
					'label' => 'Pricedt',
				));
				echo $this->Form->input('priceeuro', array(
					'label' => 'Priceeuro',
				));
				echo $this->Form->input('description', array(
					'label' => 'Description',
				));
				echo $this->Form->input('status', array(
					'label' => 'Status',
				));
			?>
			</div>
			<?php echo $this->Croogo->adminTabs(); ?>
		</div>

	</div>

	<div class="span4">
	<?php
		echo $this->Html->beginBox(__d('croogo', 'Publishing')) .
			$this->Form->button(__d('croogo', 'Apply'), array('name' => 'apply')) .
			$this->Form->button(__d('croogo', 'Save'), array('class' => 'btn btn-primary')) .
			$this->Html->link(__d('croogo', 'Cancel'), array('action' => 'index'), array('class' => 'btn btn-danger')) .
			$this->Html->endBox();
		?>
	</div>

</div>
<?php echo $this->Form->end(); ?>
