<?php
App::uses('AppCakeTestCase', 'CakeTheme.Test');
App::uses('BreadCrumbBehavior', 'CakeTheme.Model/Behavior');
require_once App::pluginPath('CakeTheme') . 'Test' . DS . 'Model' . DS . 'modelsFixt.php';

/**
 * BreadCrumbBehavior Test Case
 */
class BreadCrumbBehaviorTest extends AppCakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = [
		'plugin.cake_theme.employees'
	];

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->_targetObject = new BreadCrumbTest();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->_targetObject);

		parent::tearDown();
	}

/**
 * testGetModelName method
 *
 * @return void
 */
	public function testGetModelName() {
		$result = $this->_targetObject->getModelName();
		$expected = 'BreadCrumbTest';
		$this->assertData($expected, $result);
	}

/**
 * testGetModelNameLowerCase method
 *
 * @return void
 */
	public function testGetModelNameLowerCase() {
		$result = $this->_targetObject->getModelName(true);
		$expected = 'breadcrumbtest';
		$this->assertData($expected, $result);
	}

/**
 * testGetModelNamePlural method
 *
 * @return void
 */
	public function testGetModelNamePlural() {
		$result = $this->_targetObject->getModelNamePlural();
		$expected = 'BreadCrumbTests';
		$this->assertData($expected, $result);
	}

/**
 * testGetPluginName method
 *
 * @return void
 */
	public function testGetPluginName() {
		$result = $this->_targetObject->getPluginName();
		$this->assertNull($result);
	}

/**
 * testGetControllerName method
 *
 * @return void
 */
	public function testGetControllerName() {
		$result = $this->_targetObject->getControllerName();
		$expected = 'bread_crumb_tests';
		$this->assertData($expected, $result);
	}

/**
 * testGetActionName method
 *
 * @return void
 */
	public function testGetActionName() {
		$result = $this->_targetObject->getActionName();
		$expected = 'view';
		$this->assertData($expected, $result);
	}

/**
 * testGetGroupName method
 *
 * @return void
 */
	public function testGetGroupName() {
		$result = $this->_targetObject->getGroupName();
		$expected = 'Bread crumb tests';
		$this->assertData($expected, $result);
	}

/**
 * testGetNameEmptyParam method
 *
 * @return void
 */
	public function testGetNameEmptyParam() {
		$result = $this->_targetObject->getName();
		$this->assertFalse($result);
	}

/**
 * testGetNameInvalidParamId method
 *
 * @return void
 */
	public function testGetNameInvalidParamId() {
		$result = $this->_targetObject->getName('1000');
		$this->assertFalse($result);
	}

/**
 * testGetNameInvalidParamArray method
 *
 * @return void
 */
	public function testGetNameInvalidParamArray() {
		$data = [
			'BreadCrumbTest' => []
		];
		$result = $this->_targetObject->getName($data);
		$this->assertFalse($result);
	}

/**
 * testGetNameIdSuccess method
 *
 * @return void
 */
	public function testGetNameIdSuccess() {
		$result = $this->_targetObject->getName(1);
		$expected = 'Сазонов А.П.';
		$this->assertData($expected, $result);
	}

/**
 * testGetNameArraySuccess method
 *
 * @return void
 */
	public function testGetNameArraySuccess() {
		$data = [
			'BreadCrumbTest' => [
				'full_name' => 'Герасимова Н.М.'
			]
		];
		$result = $this->_targetObject->getName($data);
		$expected = 'Герасимова Н.М.';
		$this->assertData($expected, $result);
	}

/**
 * testGetFullNameEmptyParam method
 *
 * @return void
 */
	public function testGetFullNameEmptyParam() {
		$result = $this->_targetObject->getFullName();
		$this->assertFalse($result);
	}

/**
 * testGetFullNameInvalidParam method
 *
 * @return void
 */
	public function testGetFullNameInvalidParam() {
		$result = $this->_targetObject->getFullName('1000');
		$this->assertFalse($result);
	}

/**
 * testGetFullNameSuccess method
 *
 * @return void
 */
	public function testGetFullNameSuccess() {
		$result = $this->_targetObject->getFullName(2);
		$expected = 'BreadCrumbTest \'Костин Д.И.\'';
		$this->assertData($expected, $result);
	}

/**
 * testCreateBreadcrumbEmptyParam method
 *
 * @return void
 */
	public function testCreateBreadcrumbEmptyParam() {
		$result = $this->_targetObject->createBreadcrumb();
		$expected = [
			'Bread crumb tests',
			[
				'plugin' => null,
				'controller' => 'bread_crumb_tests',
				'action' => 'index'
			]
		];
		$this->assertData($expected, $result);
	}

/**
 * testCreateBreadcrumbInvalidParam method
 *
 * @return void
 */
	public function testCreateBreadcrumbInvalidParam() {
		$result = $this->_targetObject->createBreadcrumb('1000', null);
		$expected = [];
		$this->assertData($expected, $result);
	}

/**
 * testCreateBreadcrumbSuccessDisableLink method
 *
 * @return void
 */
	public function testCreateBreadcrumbSuccessDisableLink() {
		$result = $this->_targetObject->createBreadcrumb(3, false);
		$expected = [
			'Герасимова Н.М.',
			null
		];
		$this->assertData($expected, $result);
	}

/**
 * testCreateBreadcrumbSuccessDefaultLink method
 *
 * @return void
 */
	public function testCreateBreadcrumbSuccessDefaultLink() {
		$result = $this->_targetObject->createBreadcrumb(4, null);
		$expected = [
			'Алексеев А. В.',
			[
				4,
				'plugin' => null,
				'controller' => 'bread_crumb_tests',
				'action' => 'view'
			]
		];
		$this->assertData($expected, $result);
	}

/**
 * testCreateBreadcrumbSuccessUseLink method
 *
 * @return void
 */
	public function testCreateBreadcrumbSuccessUseLink() {
		$link = ['controller' => 'some_controller', 'param'];
		$result = $this->_targetObject->createBreadcrumb(5, $link);
		$expected = [
			'Ефимов У.Ю.',
			[
				'controller' => 'some_controller',
				'param',
				'plugin' => null,
				'action' => 'view',
			]
		];
		$this->assertData($expected, $result);
	}

/**
 * testGetBreadcrumbInfoEmptyParam method
 *
 * @return void
 */
	public function testGetBreadcrumbInfoEmptyParam() {
		$result = $this->_targetObject->getBreadcrumbInfo();
		$expected = [
			[
				'Bread crumb tests',
				[
					'plugin' => null,
					'controller' => 'bread_crumb_tests',
					'action' => 'index'
				]
			]
		];
		$this->assertData($expected, $result);
	}

/**
 * testGetBreadcrumbInfoInvalidParam method
 *
 * @return void
 */
	public function testGetBreadcrumbInfoInvalidParam() {
		$result = $this->_targetObject->getBreadcrumbInfo('1000', null);
		$expected = [];
		$this->assertData($expected, $result);
	}

/**
 * testGetBreadcrumbInfoSuccessNotIncludeRoot method
 *
 * @return void
 */
	public function testGetBreadcrumbInfoSuccessNotIncludeRoot() {
		$result = $this->_targetObject->getBreadcrumbInfo(1, false);
		$expected = [
			[
				'Сазонов А.П.',
				[
					1,
					'plugin' => null,
					'controller' => 'bread_crumb_tests',
					'action' => 'view'
				]
			]
		];
		$this->assertData($expected, $result);
	}

/**
 * testGetBreadcrumbInfoSuccessDefaultIncludeRoot method
 *
 * @return void
 */
	public function testGetBreadcrumbInfoSuccessDefaultIncludeRoot() {
		$result = $this->_targetObject->getBreadcrumbInfo(2, null);
		$expected = [
			[
				'Bread crumb tests',
				[
					'plugin' => null,
					'controller' => 'bread_crumb_tests',
					'action' => 'index'
				]
			],
			[
				'Костин Д.И.',
				[
					2,
					'plugin' => null,
					'controller' => 'bread_crumb_tests',
					'action' => 'view'
				]
			]
		];
		$this->assertData($expected, $result);
	}

/**
 * testGetBreadcrumbInfoSuccessIncludeRoot method
 *
 * @return void
 */
	public function testGetBreadcrumbInfoSuccessIncludeRoot() {
		$result = $this->_targetObject->getBreadcrumbInfo(3, true);
		$expected = [
			[
				'Bread crumb tests',
				[
					'plugin' => null,
					'controller' => 'bread_crumb_tests',
					'action' => 'index'
				]
			],
			[
				'Герасимова Н.М.',
				[
					3,
					'plugin' => null,
					'controller' => 'bread_crumb_tests',
					'action' => 'view'
				]
			]
		];
		$this->assertData($expected, $result);
	}
}
