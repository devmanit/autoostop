<?php
if( Configure::read('userprofile.role_id') == 4){
    CroogoNav::add('sidebar', 'change', array(
    'icon' => array('briefcase', 'large'),
    'title' => 'Passager',
   
    'weight' => 40,
    'children' => array(
        'rcatalogue0' => array(
            'title' => 'Réserver un départ',
            'url' => array(
                'admin' => true,
                'plugin' => 'other',
                'controller' => 'evals',
                'action' => 'changeaccount',
            ),
        ),
        )
    
 ));
}
CroogoNav::add('sidebar', 'rcatalogue', array(
    'icon' => array('th', 'large'),
    'title' => 'Conducteur',
    'url' => array(
                'admin' => true,
                'plugin' => 'rcatalogue',
                'controller' => 'properties',
                'action' => 'index',
            ),
    'weight' => 40,
    'children' => array(
        'rcatalogue0' => array(
            'title' => 'Mes voitures',
            'url' => array(
                'admin' => true,
                'plugin' => 'rcatalogue',
                'controller' => 'cars',
                'action' => 'index',
            ),
        ),
	'rcatalogue1' => array(
            'title' => 'Annoncer un départ',
            'url' => array(
                'admin' => true,
                'plugin' => 'rcatalogue',
                'controller' => 'properties',
                'action' => 'add',
            ),
        ),
        'rcatalogue2' => array(
            'title' => 'Mes départs',
            'url' => array(
                'admin' => true,
                'plugin' => 'rcatalogue',
                'controller' => 'properties',
                'action' => 'index',
                1
            ),
        ),
        'rcatalogue4' => array(
            'title' => 'Vider le cache',
            'url' => array(
                'admin' => true,
                'plugin' => 'rcatalogue',
                'controller' => 'cacheclears',
                'action' => 'index',
            ),
        ),
    ),
));
