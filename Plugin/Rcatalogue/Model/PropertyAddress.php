<?php
App::uses('RcatalogueAppModel', 'Rcatalogue.Model');
/**
 * PropertyAddress Model
 *
 * @property Property $Property
 */
class PropertyAddress extends RcatalogueAppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'line_address' => array(
                        'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Veuillez remplir la ville de départ SVP !',
				'allowEmpty' => false,
				//'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
                'province' => array(
                        'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Veuillez remplir la ville de départ SVP !',
				'allowEmpty' => false,
				//'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
                'city' => array(
                        'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Veuillez remplir la ville de départ SVP !',
				'allowEmpty' => false,
				//'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
            'line_address_des' => array(
                        'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Veuillez remplir la ville d\'arrivé SVP !',
				'allowEmpty' => false,
				//'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
                'province_des' => array(
                        'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Veuillez remplir la ville d\'arrivé SVP !',
				'allowEmpty' => false,
				//'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
                'city_des' => array(
                        'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Veuillez remplir la ville d\'arrivé  SVP !',
				'allowEmpty' => false,
				//'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
                'latitude' => array(
                            'notEmpty' => array(
                                    'rule' => array('notEmpty'),
                                    'message' => 'Veuillez remplir le point de rendez vous SVP !',
                                    'allowEmpty' => false,
                                    'required' => true,
                                    //'last' => false, // Stop validation after this rule
                                    //'on' => 'create', // Limit validation to 'create' or 'update' operations
                            ),
                    ),
                'latitude_des' => array(
                            'notEmpty' => array(
                                    'rule' => array('notEmpty'),
                                    'message' => 'Veuillez remplir le point de chute SVP !',
                                    'allowEmpty' => false,
                                    'required' => true,
                                    //'last' => false, // Stop validation after this rule
                                    //'on' => 'create', // Limit validation to 'create' or 'update' operations
                            ),
                    ),
                'longitude' => array(
                                'notEmpty' => array(
                                        'rule' => array('notEmpty'),
                                        'message' => 'Veuillez remplir le point de rendez SVP !',
                                        'allowEmpty' => false,
                                        'required' => true,
                                        //'last' => false, // Stop validation after this rule
                                        //'on' => 'create', // Limit validation to 'create' or 'update' operations
                                ),
                        ),
                'longitude_des' => array(
                                'notEmpty' => array(
                                        'rule' => array('notEmpty'),
                                        'message' => 'Veuillez remplir le point de chute SVP !',
                                        'allowEmpty' => false,
                                        'required' => true,
                                        //'last' => false, // Stop validation after this rule
                                        //'on' => 'create', // Limit validation to 'create' or 'update' operations
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
		'Property' => array(
			'className' => 'Property',
			'foreignKey' => 'property_id',
                        'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
        
}
