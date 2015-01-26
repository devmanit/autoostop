<?php

CroogoNav::add('sidebar', 'themeslider', array(
	'icon' => array('picture', 'large'),
	'title' => __d('croogo', 'Diaporama Accueil'),
	'url' => array(
		'admin' => true,
		'plugin' => 'themeslider',
		'controller' => 'slidesattachments',
		'action' => 'index',
	),
	'weight' => 40,
	'children' => array(
		'attachments' => array(
			'title' => __d('croogo', 'Configuration'),
			'url' => array(
				'admin' => true,
				'plugin' => 'themeslider',
				'controller' => 'slidesattachments',
				'action' => 'index',
			),
		),
	),
));
