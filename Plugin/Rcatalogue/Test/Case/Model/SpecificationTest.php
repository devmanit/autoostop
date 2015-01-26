<?php
App::uses('Specification', 'Rcatalogue.Model');

/**
 * Specification Test Case
 *
 */
class SpecificationTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.rcatalogue.specification'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Specification = ClassRegistry::init('Rcatalogue.Specification');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Specification);

		parent::tearDown();
	}

}
