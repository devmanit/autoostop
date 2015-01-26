<div class="attachments index">

	<h2><?php echo $title_for_layout; ?></h2>

	<div class="row-fluid">
		<div class="span12 actions">
			<ul class="nav-buttons">
			<?php
				echo $this->Croogo->adminAction(
					__d('croogo', 'New Rcatalogueattachment'),
					array('action' => 'add', 'editor' => 1)
				);
			?>
			</ul>
		</div>
	</div>

	<table class="table table-striped">
	<?php
		$tableHeaders = $this->Html->tableHeaders(array(
			$this->Paginator->sort('id', __d('croogo', 'Id')),
			'&nbsp;',
			$this->Paginator->sort('title', __d('croogo', 'Title')),
			'&nbsp;',
			__d('croogo', 'URL'),
			__d('croogo', 'Actions'),
		));
		echo $tableHeaders;

		$rows = array();
		foreach ($attachments as $attachment):
			$actions = array();
			$actions[] = $this->Croogo->adminRowAction('',
				array('controller' => 'rcatalogueattachments', 'action' => 'edit', $attachment['Rcatalogueattachment']['id'], 'editor' => 1),
				array('icon' => 'pencil', 'tooltip' => __d('croogo', 'Edit'))
			);
			$actions[] = $this->Croogo->adminRowAction('', array(
				'controller' => 'rcatalogueattachments',
				'action' => 'delete',
				$attachment['Rcatalogueattachment']['id'],
				'editor' => 1,
			), array('icon' => 'trash', 'tooltip' => __d('croogo', 'Delete')), __d('croogo', 'Are you sure?'));

			$mimeType = explode('/', $attachment['Rcatalogueattachment']['mime_type']);
			$mimeType = $mimeType['0'];
			$imageType = $mimeType[1];
			$imagecreatefrom = array('gif', 'jpeg', 'png', 'string', 'wbmp', 'webp', 'xbm', 'xpm');
			if ($mimeType == 'image' && in_array($imageType, $imagecreatefrom)) {
				$thumbnail = $this->Html->link($this->Image->resize($attachment['Rcatalogueattachment']['path'], 100, 200), $attachment['Rcatalogueattachment']['path'], array(
					'class' => 'thickbox',
					'escape' => false,
					'title' => $attachment['Rcatalogueattachment']['title'],
				));
			} else {
				$thumbnail = $this->Html->image('/croogo/img/icons/page_white.png') . ' ' . $attachment['Rcatalogueattachment']['mime_type'] . ' (' . $this->Filemanager->filename2ext($attachment['Rcatalogueattachment']['slug']) . ')';
				$thumbnail = $this->Html->link($thumbnail, '#', array(
					'escape' => false,
				));
			}

			$actions = $this->Html->div('item-actions', implode(' ', $actions));

			$insertCode = $this->Html->link('', '#', array(
				'onclick' => "Croogo.Wysiwyg.choose('" . $attachment['Rcatalogueattachment']['slug'] . "');",
				'escapeTitle' => false,
				'icon' => 'paper-clip',
				'tooltip' => __d('croogo', 'Insert')
			));

			$rows[] = array(
				$attachment['Rcatalogueattachment']['id'],
				$thumbnail,
				$attachment['Rcatalogueattachment']['title'],
				$insertCode,
				$this->Html->link(Router::url($attachment['Rcatalogueattachment']['path']),
					$attachment['Rcatalogueattachment']['path'],
					array('onclick' => "Croogo.Wysiwyg.choose('" . $attachment['Rcatalogueattachment']['slug'] . "');")
				),
				$actions,
			);
		endforeach;

		echo $this->Html->tableCells($rows);
		echo $tableHeaders;
	?>
	</table>
</div>

<div class="row-fluid">
	<div class="span12">
		<div class="pagination">
		<ul>
			<?php echo $this->Paginator->first('< ' . __d('croogo', 'first')); ?>
			<?php echo $this->Paginator->prev('< ' . __d('croogo', 'prev')); ?>
			<?php echo $this->Paginator->numbers(); ?>
			<?php echo $this->Paginator->next(__d('croogo', 'next') . ' >'); ?>
			<?php echo $this->Paginator->last(__d('croogo', 'last') . ' >'); ?>
		</ul>
		</div>
		<div class="counter"><?php echo $this->Paginator->counter(array('format' => __d('croogo', 'Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%'))); ?></div>
	</div>
</div>
