<?php
App::uses('RcatalogueAppModel', 'Rcatalogue.Model');
/**
 * Property Model
 *
 * @property PropertyCategory $PropertyCategory
 * @property PropertyAddress $PropertyAddress
 * @property PropertyImage $PropertyImage
 */
class Property extends RcatalogueAppModel {

    public $actsAs = array('Containable','Meta.Meta');
  
    /**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
                'datedepart' => array(
                        'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Veuillez remplir tous les champs obligatoires SVP !',
				'allowEmpty' => false,
			),
                        'date'
		),
		'pricedt' => array(
                        'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Veuillez remplir tous les champs obligatoires SVP !',
				'allowEmpty' => false,
				//'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
                'rooms' => array(
                        'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Veuillez remplir tous les champs obligatoires SVP !',
				'allowEmpty' => false,
				//'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
        
            
                
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
                'Car' => array(
			'className' => 'Car',
			'foreignKey' => 'car_id'
		),
                'User' => array(
			'className' => 'Users.User',
			'foreignKey' => 'user_id',
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
	public $hasMany = array(
		'PropertyAddress' => array(
			'className' => 'PropertyAddress',
			'foreignKey' => 'property_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Node' => array(
			'className' => 'Nodes.Node',
			'foreignKey' => 'property_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => array('id','title','path'),
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
        /*
         * Before save add category name
         */
        
        
        public function lastProperties($limit = null) {
            
           $this->contain(array('Car','PropertyAddress','User'=>array('Userinfo')));
           
            if($limit != null)
            {   return $this->find('all', array(
                                        'joins' => array(
                                            array(
                                                'table' => 'property_addresses',
                                                'alias' => 'PropertyAddress',
                                                'conditions' => array(
                                                    'PropertyAddress.property_id = Property.id',
                                                )
                                            )
                                        ),
                                        'group' => 'Property.id',
                                        'limit' => $limit,
                                        'order' => array('Property.datedepart DESC')));
            }
            else {
                 return $this->find('all', array(
                                        'joins' => array(
                                            array(
                                                'table' => 'property_addresses',
                                                'alias' => 'PropertyAddress',
                                                'conditions' => array(
                                                    'PropertyAddress.property_id = Property.id',
                                                )
                                            )
                                        ),
                                        'group' => 'Property.id',
                                        'order' => array('Property.datedepart DESC')));           
            }
        }
        
        public function featuedProperty() {
            
            $this->contain(array(
                'Node' => array('imgdefault = 1','limit' => 1)
                ));
            
            return $this->find('first', array(
                                        'conditions' => array('featured' => 1)));
        }
        
        public function relatedByLocation($location = null, $property_id)
        {
            if($location !=null && $property_id != null)
            {
                return $this->find('all',
                            array(
                                'contain' => array('Node' => array('imgdefault = 1','limit' => 1)),
                                'joins' => array(
                                array(
                                    'table' => 'property_addresses',
                                    'alias' => 'PropertyAddress',
                                    'conditions'=> array(
                                        'PropertyAddress.property_id = Property.id', 
                                    )
                                )),
                                'conditions' => array(
                                    'PropertyAddress.city' => $location,
                                    'Property.id <>' => $property_id)
                            )
                        );
            }
        }
}
