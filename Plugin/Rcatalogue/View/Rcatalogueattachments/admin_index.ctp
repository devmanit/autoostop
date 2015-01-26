<?php

$this->extend('/Common/admin_index');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Rcatalogueattachments'), '/' . $this->request->url);

?>
<table class="table table-striped">
<?php

	$tableHeaders = $this->Html->tableHeaders(array(
		$this->Paginator->sort('id', __d('croogo', 'Id')),
		'&nbsp;',
		$this->Paginator->sort('title', __d('croogo', 'Title')),
		__d('croogo', 'URL'),
		__d('croogo', 'Actions'),
	));

?>
	<thead>
	<?php echo $tableHeaders; ?>
	</thead>
<?php

	$rows = array();
	foreach ($attachments as $attachment) {
		$actions = array();
		$actions[] = $this->Croogo->adminRowActions($attachment['Rcatalogueattachment']['id']);
		$actions[] = $this->Croogo->adminRowAction('',
			array('controller' => 'rcatalogueattachments', 'action' => 'edit', $attachment['Rcatalogueattachment']['id']),
			array('icon' => 'pencil', 'tooltip' => __d('croogo', 'Edit this item'))
		);
		$actions[] = $this->Croogo->adminRowAction('',
			array('controller' => 'rcatalogueattachments', 'action' => 'delete', $attachment['Rcatalogueattachment']['id']),
			array('icon' => 'trash', 'tooltip' => __d('croogo', 'Remove this item')),
			__d('croogo', 'Are you sure?'));

		$mimeType = explode('/', $attachment['Rcatalogueattachment']['mime_type']);
		$imageType = $mimeType['1'];
		$mimeType = $mimeType['0'];
		$imagecreatefrom = array('gif', 'jpeg', 'png', 'string', 'wbmp', 'webp', 'xbm', 'xpm');
		if ($mimeType == 'image' && in_array($imageType, $imagecreatefrom)) {
			$imgUrl = $this->Image->resize('/uploads/' . $attachment['Rcatalogueattachment']['slug'], 100, 200, true, array('class' => 'img-polaroid', 'alt' => $attachment['Rcatalogueattachment']['title']));
			$thumbnail = $this->Html->link($imgUrl, $attachment['Rcatalogueattachment']['path'],
			array('escape' => false, 'class' => 'thickbox', 'title' => $attachment['Rcatalogueattachment']['title']));
		} else {
			$thumbnail = $this->Html->image('/croogo/img/icons/page_white.png', array('alt' => $attachment['Rcatalogueattachment']['mime_type'])) . ' ' . $attachment['Rcatalogueattachment']['mime_type'] . ' (' . $this->Filemanager->filename2ext($attachment['Rcatalogueattachment']['slug']) . ')';
		}

		$actions = $this->Html->div('item-actions', implode(' ', $actions));

		$rows[] = array(
			$attachment['Rcatalogueattachment']['id'],
			$thumbnail,
			$this->Html->tag('div', $attachment['Rcatalogueattachment']['title'], array('class' => 'ellipsis')),
			$this->Html->tag('div',
				$this->Html->link(
					$this->Html->url($attachment['Rcatalogueattachment']['path'], true),
					$attachment['Rcatalogueattachment']['path'],
					array('target' => '_blank')
				), array('class' => 'ellipsis')
			),
			$actions,
		);
	}

	echo $this->Html->tableCells($rows);

?>
</table>
