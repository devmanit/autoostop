<?php
App::uses('Property', 'Rcatalogue.Model');

/**
 * Property Test Case
 *
 */
class PropertyTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.rcatalogue.property',
		'plugin.rcatalogue.property_category',
		'plugin.rcatalogue.property_address',
		'plugin.rcatalogue.property_image'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Property = ClassRegistry::init('Rcatalogue.Property');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Property);

		parent::tearDown();
	}

}
