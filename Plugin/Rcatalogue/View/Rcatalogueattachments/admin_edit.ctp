<?php

$this->extend('/Common/admin_edit');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Rcatalogueattachments'), array('plugin' => 'file_manager', 'controller' => 'rcatalogueattachments', 'action' => 'index'))
	->addCrumb($this->data['Rcatalogueattachment']['title'], '/' . $this->request->url);

echo $this->Form->create('Rcatalogueattachment', array('url' => array('controller' => 'rcatalogueattachments', 'action' => 'edit')));

?>
<div class="row-fluid">
	<div class="span8">

		<ul class="nav nav-tabs">
		<?php
			echo $this->Croogo->adminTab(__d('croogo', 'Rcatalogueattachment'), '#attachment-main');
		?>
		</ul>

		<div class="tab-content">

			<div id="attachment-main" class="tab-pane">
			<?php
				echo $this->Form->input('id');

				$fileType = explode('/', $this->data['Rcatalogueattachment']['mime_type']);
				$fileType = $fileType['0'];
				if ($fileType == 'image') {
					$imgUrl = $this->Image->resize('/uploads/' . $this->data['Rcatalogueattachment']['slug'], 200, 300, true, array('class' => 'img-polaroid'));
				} else {
					$imgUrl = $this->Html->image('/croogo/img/icons/' . $this->Filemanager->mimeTypeToImage($this->data['Rcatalogueattachment']['mime_type'])) . ' ' . $this->data['Rcatalogueattachment']['mime_type'];
				}
				echo $this->Html->link($imgUrl, $this->data['Rcatalogueattachment']['path'], array(
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
					'value' => Router::url($this->data['Rcatalogueattachment']['path'], true),
					'readonly' => 'readonly')
				);

				echo $this->Form->input('file_type', array(
					'label' => __d('croogo', 'Mime Type'),
					'value' => $this->data['Rcatalogueattachment']['mime_type'],
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
		echo $this->Html->beginBox('') .
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