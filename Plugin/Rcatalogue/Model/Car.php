<?php
App::uses('RcatalogueAppModel', 'Rcatalogue.Model');
/**
 * Property Model
 *
 * @property PropertyCategory $PropertyCategory
 * @property PropertyAddress $PropertyAddress
 * @property PropertyImage $PropertyImage
 */
class Car extends RcatalogueAppModel {

    public $name = 'Car';
    public $actsAs = array('Containable','Meta.Meta');
    
    /**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
//
		'type' => array(
                        'notEmpty' => array(
                                    'rule' => 'notEmpty',
                                    'message' => 'Veuillez vous sélectionner votre type de véhicule',
                                    'last' => true,
                                ),
		),
            'marque' => array(
                        'notEmpty' => array(
                                    'rule' => 'notEmpty',
                                    'message' => 'Veuillez remplir la marque et modèle de véhicule',
                                    'last' => true,
                                ),
		),
            
             'matricule' => array(
                        'notEmpty' => array(
                                    'rule' => 'notEmpty',
                                    'message' => 'Veuillez remplir la matricule de véhicule',
                                    'last' => true,
                                ),
		),
              'year' => array(
                        'notEmpty' => array(
                                    'rule' => 'notEmpty',
                                    'message' => 'Veuillez remplir l\'année de véhicule',
                                    'last' => true,
                                ),
		),
              'color' => array(
                        'notEmpty' => array(
                                    'rule' => 'notEmpty',
                                    'message' => 'Veuillez remplir la couleur de véhicule',
                                    'last' => true,
                                ),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'Users.User',
			'foreignKey' => 'user_id',
                        'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
		),
	);

/**
 * hasMany associations
 *
 * @var array
 */
//	public $hasMany = array(
//		'Property' => array(
//			'className' => 'Rcatalogue.Property',
//			'foreignKey' => 'car_id',
//			'dependent' => false,
//			'conditions' => '',
//			'fields' => '',
//			'order' => '',
//			'limit' => '',
//			'offset' => '',
//			'exclusive' => '',
//			'finderQuery' => '',
//			'counterQuery' => ''
//		),
//	);
       
}
