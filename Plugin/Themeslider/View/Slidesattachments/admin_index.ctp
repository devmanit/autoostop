<?php

$this->name_button = 'Nouveau slide';
$this->extend('/Common/admin_index');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Slidesattachments'), '/' . $this->request->url);

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
		$actions[] = $this->Croogo->adminRowActions($attachment['Slidesattachment']['id']);
		$actions[] = $this->Croogo->adminRowAction('',
			array('controller' => 'slidesattachments', 'action' => 'edit', $attachment['Slidesattachment']['id']),
			array('icon' => 'pencil', 'tooltip' => __d('croogo', 'Edit this item'))
		);
		$actions[] = $this->Croogo->adminRowAction('',
			array('controller' => 'slidesattachments', 'action' => 'delete', $attachment['Slidesattachment']['id']),
			array('icon' => 'trash', 'tooltip' => __d('croogo', 'Remove this item')),
			__d('croogo', 'Are you sure?'));

		$mimeType = explode('/', $attachment['Slidesattachment']['mime_type']);
		$imageType = $mimeType['1'];
		$mimeType = $mimeType['0'];
		$imagecreatefrom = array('gif', 'jpeg', 'png', 'string', 'wbmp', 'webp', 'xbm', 'xpm');
		if ($mimeType == 'image' && in_array($imageType, $imagecreatefrom)) {
			$imgUrl = $this->Image->resize('/uploads/' . $attachment['Slidesattachment']['slug'], 100, 200, true, array('class' => 'img-polaroid', 'alt' => $attachment['Slidesattachment']['title']));
			$thumbnail = $this->Html->link($imgUrl, $attachment['Slidesattachment']['path'],
			array('escape' => false, 'class' => 'thickbox', 'title' => $attachment['Slidesattachment']['title']));
		} else {
			$thumbnail = $this->Html->image('/croogo/img/icons/page_white.png', array('alt' => $attachment['Slidesattachment']['mime_type'])) . ' ' . $attachment['Slidesattachment']['mime_type'] . ' (' . $this->Filemanager->filename2ext($attachment['Slidesattachment']['slug']) . ')';
		}

		$actions = $this->Html->div('item-actions', implode(' ', $actions));

		$rows[] = array(
			$attachment['Slidesattachment']['id'],
			$thumbnail,
			$this->Html->tag('div', $attachment['Slidesattachment']['title'], array('class' => 'ellipsis')),
			$this->Html->tag('div',
				$this->Html->link(
					$this->Html->url($attachment['Slidesattachment']['path'], true),
					$attachment['Slidesattachment']['path'],
					array('target' => '_blank')
				), array('class' => 'ellipsis')
			),
			$actions,
		);
	}

	echo $this->Html->tableCells($rows);

?>
</table>
