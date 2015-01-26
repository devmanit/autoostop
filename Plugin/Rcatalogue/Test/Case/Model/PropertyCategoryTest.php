<?php
App::uses('PropertyCategory', 'Rcatalogue.Model');

/**
 * PropertyCategory Test Case
 *
 */
class PropertyCategoryTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.rcatalogue.property_category'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->PropertyCategory = ClassRegistry::init('Rcatalogue.PropertyCategory');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PropertyCategory);

		parent::tearDown();
	}

}
