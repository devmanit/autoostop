<?php
App::uses('PropertyImage', 'Rcatalogue.Model');

/**
 * PropertyImage Test Case
 *
 */
class PropertyImageTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.rcatalogue.property_image',
		'plugin.rcatalogue.property'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->PropertyImage = ClassRegistry::init('Rcatalogue.PropertyImage');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PropertyImage);

		parent::tearDown();
	}

}
