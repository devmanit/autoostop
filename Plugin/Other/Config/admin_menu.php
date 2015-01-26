<?php

CroogoNav::add('sidebar', 'other', array(
    'icon' => array('exclamation-sign', 'large'),
    'title' => __d('croogo', 'Autres options'),
    'weight' => 50,
    'children' => array(
        'other0' => array(
            'title' => 'Avantage Éco-points',
            'url' => array(
                'admin' => true,
                'plugin' => 'other',
                'controller' => 'ecopoints',
                'action' => 'index',
                
            ),
        ),
	'other1' => array(
            'title' => 'Evaluation des membres',
            'url' => array(
                'admin' => true,
                'plugin' => 'other',
                'controller' => 'evals',
                'action' => 'index',
                1
                
            ),
            
        ),
        'other2' => array(
            'title' => 'Parrainer un ami',
             'url' => array(
                'admin' => true,
                'plugin' => 'users',
                'controller' => 'users',
                'action' => 'seninvit',
            ),
        ),
     
    ),
));
