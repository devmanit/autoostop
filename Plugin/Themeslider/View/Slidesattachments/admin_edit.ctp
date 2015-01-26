<?php

$this->extend('/Common/admin_edit');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Slidesattachments'), array('plugin' => 'file_manager', 'controller' => 'slidesattachments', 'action' => 'index'))
	->addCrumb($this->data['Slidesattachment']['title'], '/' . $this->request->url);

echo $this->Form->create('Slidesattachment', array('url' => array('controller' => 'slidesattachments', 'action' => 'edit')));

?>
<div class="row-fluid">
	<div class="span8">

		<ul class="nav nav-tabs">
		<?php
			echo $this->Croogo->adminTab(__d('croogo', 'Slidesattachment'), '#attachment-main');
		?>
		</ul>

		<div class="tab-content">

			<div id="attachment-main" class="tab-pane">
			<?php
				echo $this->Form->input('id');

				$fileType = explode('/', $this->data['Slidesattachment']['mime_type']);
				$fileType = $fileType['0'];
				if ($fileType == 'image') {
					$imgUrl = $this->Image->resize('/uploads/' . $this->data['Slidesattachment']['slug'], 200, 300, true, array('class' => 'img-polaroid'));
				} else {
					$imgUrl = $this->Html->image('/croogo/img/icons/' . $this->Filemanager->mimeTypeToImage($this->data['Slidesattachment']['mime_type'])) . ' ' . $this->data['Slidesattachment']['mime_type'];
				}
				echo $this->Html->link($imgUrl, $this->data['Slidesattachment']['path'], array(
					'class' => 'thickbox pull-right',
				));
				$this->Form->inputDefaults(array(
					'class' => 'span6',
					'label' => false,
				));
				echo $this->Form->input('title', array(
					'label' => __d('croogo', 'Titre'),
				));
                                echo $this->Form->input('body', array(
					'label' => __d('croogo', 'Description'),
				));
                                echo $this->Form->input('custom_url', array(
					'label' => __d('croogo', 'Lien'),
				));
				echo $this->Form->input('excerpt', array(
					'label' => __d('croogo', 'Image Caption'),
				));
				echo $this->Form->input('file_url', array(
					'label' => __d('croogo', 'File URL'),
					'value' => Router::url($this->data['Slidesattachment']['path'], true),
					'readonly' => 'readonly')
				);

				echo $this->Form->input('file_type', array(
					'label' => __d('croogo', 'Mime Type'),
					'value' => $this->data['Slidesattachment']['mime_type'],
					'readonly' => 'readonly')
				);

			?>
			</div>

			<?php echo $this->Croogo->adminTabs(); ?>
		</div>
	</div>

	<div class="span4">
	<?php
		$redirect = array('action' => 'index');
		if ($this->Session->check('Wysiwyg.redirect')) {
			$redirect = $this->Session->read('Wysiwyg.redirect');
		}
		echo $this->Html->beginBox(__d('croogo', 'Publishing')) .
			$this->Form->button(__d('croogo', 'Apply'), array('name' => 'apply')) .
			$this->Form->button(__d('croogo', 'Save'), array('button' => 'success')) .
			$this->Html->link(
				__d('croogo', 'Cancel'),
				$redirect,
				array('class' => 'cancel', 'button' => 'danger')
			) .
			$this->Html->endBox();
	?>
	</div>
</div>
<?php echo $this->Form->end(); ?>