<?php

CroogoNav::add('sidebar', 'passager', array(
    'icon' => array('briefcase', 'large'),
    'title' => 'Passager',
    'url' => array(
                'admin' => true,
                'plugin' => 'passager',
                'controller' => 'reserves',
                'action' => 'index',
            ),
    'weight' => 40,
    'children' => array(
        'other0' => array(
            'title' => 'Mes réservations',
            'url' => array(
                'admin' => true,
                'plugin' => 'passager',
                'controller' => 'reserves',
                'action' => 'index',
                1
                
            ),
        ),
	'other1' => array(
            'title' => 'Crédit de réservation',
            'url' => array(
                'admin' => true,
                'plugin' => 'passager',
                'controller' => 'credits',
                'action' => 'index',
        
            ),
        ),
    ),
));
