<?php
App::uses('PropertyAddress', 'Rcatalogue.Model');

/**
 * PropertyAddress Test Case
 *
 */
class PropertyAddressTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.rcatalogue.property_address',
		'plugin.rcatalogue.property'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->PropertyAddress = ClassRegistry::init('Rcatalogue.PropertyAddress');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PropertyAddress);

		parent::tearDown();
	}

}
