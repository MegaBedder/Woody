<?php

namespace Woody\Model;

use \Utils\Tree\TreeNode;

/**
 * Test class for TableModelTest.
 * Generated by PHPUnit on 2011-11-30 at 22:59:58.
 */
class TableModelTest extends \PHPUnit_Framework_TestCase {

  /**
   * the table model to test
   *
   * @var TableModel
   */
  private $tableModel = null;

  /**
   * the raw data of the table model
   *
   * @var array
   */
  private $data       = null;

  /**
   * Sets up the fixture, for example, opens a network connection.
   * This method is called before a test is executed.
   */
  protected function setUp() {
    $this->data = array(array(1, 2, 3, 4), array(5, 6, 7 ,8));

    $this->tableModel = new DefaultTableModel($this->data);
  }

  /**
   * Tears down the fixture, for example, closes a network connection.
   * This method is called after a test is executed.
   */
  protected function tearDown() {
  }

  /**
   * This method tests that creating the table model succeeds.
   *
   * @covers \Woody\Model\TableModel::__construct
   */
  public function testConstruct() {
    $this->tableModel = new DefaultTableModel(array(array(1, 2, 3, 4), array(4, 3, 2, 1)));
    $this->assertEquals(1, $this->tableModel->getEntry(0, 0));
    $this->assertEquals(4, $this->tableModel->getEntry(1, 0));
    $this->assertEquals(1, $this->tableModel->getEntry(1, 3));
  }

  /**
   * This method tests retrieving the default names of the column headers.
   *
   * @covers \Woody\Model\DefaultTableModel::getColumnName
   * @covers \Woody\Model\DefaultTableModel::toBase26
   */
  public function testGetColumnName() {
    $this->assertEquals('A', $this->tableModel->getColumnName(0));
    $this->assertEquals('C', $this->tableModel->getColumnName(2));
  }

  /**
   * This method tests that, when attaching an observer and setting new data, update() has to be called once on the
   * observer.
   *
   * @covers \Woody\Model\TableModel::attach
   */
  public function testAttach() {
    $observer = $this->getObserver();

    $observer->expects($this->once())->method('update');
    $this->tableModel->attach($observer);
    $this->tableModel->setData(array(array('A1', 'B1'), array('A2', 'B2')));
  }

  /**
   * This method tests that, when attaching an observer and setting new data, update() has to be called once on the
   * observer - called within notify() of the table model.
   *
   * @covers \Woody\Model\TableModel::notify
   */
  public function testNotify() {
    $observer = $this->getObserver();

    $observer->expects($this->once())->method('update');
    $this->tableModel->attach($observer);
    $this->tableModel->setData(array(array('A1', 'B1'), array('A2', 'B2')));
  }

  /**
   * This method tests that, when attaching an observer and setting new data, update() has to be called once on the
   * observer, but when detaching it, update() is not called anymore.
   *
   * @covers \Woody\Model\TableModel::detach
   */
  public function testDetach() {
    $observer = $this->getObserver();

    $observer->expects($this->once())->method('update');
    $this->tableModel->attach($observer);
    $this->tableModel->setData(array(array('A1', 'B1'), array('A2', 'B2')));

    $observer->expects($this->never())->method('update');
    $this->tableModel->detach($observer);
    $this->tableModel->setData(array(array('C1', 'D1'), array('C2', 'D2')));
  }

  /**
   * This method returns the default mock object for the observer.
   *
   * @return SplObserver the default mock object for the observer
   */
  private function getObserver() {
    return $this->getMockBuilder('\SplObserver')
      ->disableOriginalConstructor()
      ->setMethods(array('update'))
      ->getMock();
  }
}