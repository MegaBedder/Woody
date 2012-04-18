<?php

namespace Woody\Components\Controls;

use \Woody\App\TestApplication;
use \Woody\Components\Timer\Timer;
use \Utils\Geom\Point;
use \Utils\Geom\Dimension;
use \Woody\Model\TableModel;
use \Woody\Model\DefaultTableModel;

/**
 * Test class for Table.
 * Generated by PHPUnit on 2011-12-10 at 13:25:21.
 */
class TableTest extends \PHPUnit_Framework_TestCase {

  /**
   * the table to test
   *
   * @var \Woody\Components\Controls\Table
   */
  private $table = null;

  /**
   * the test application
   *
   * @var \Woody\App\TestApplication
   */
  private $application = false;

  /**
   * Sets up the fixture, for example, opens a network connection.
   * This method is called before a test is executed.
   */
  protected function setUp() {
    $this->application = new TestApplication();

    $this->table = new Table(new Point(20, 20), new Dimension(260, 160));

    $this->application->getWindow()->add($this->table);
  }

  /**
   * Tears down the fixture, for example, closes a network connection.
   * This method is called after a test is executed.
   */
  protected function tearDown() {

  }

  /**
   * @covers Woody\Components\Controls\Table::getModel
   * @covers Woody\Components\Controls\Table::setModel
   */
  public function testGetSetModel() {
    $this->timer = new Timer(function() {
                              $this->assertNull($this->table->getModel());

                              $model = $this->getMockBuilder('\Woody\Model\TableModel')
                                      ->disableOriginalConstructor()
                                      ->getMock();
                              $this->table->setModel($model);
                              $this->assertNotNull($this->table->getModel());

                              $this->timer->destroy();
                              $this->application->stop();
                            }, $this->application->getWindow(), Timer::TEST_TIMEOUT);

    $this->timer->start($this->application->getWindow());

    $this->application->start();
  }

  /**
   * @covers Woody\Components\Controls\Table::update
   */
  public function testUpdate() {
    $this->timer = new Timer(function() {
                              $model = $this->createModel();
                              $model->attach($this->table);
                              $this->table->setModel($model);

                              $this->timer->destroy();
                              $this->application->stop();
                            }, $this->application->getWindow(), Timer::TEST_TIMEOUT);

    $this->timer->start($this->application->getWindow());

    $this->application->start();
  }

  /**
   * @covers \Woody\Components\Controls\Table::getSelectedIndex
   * @covers \Woody\Components\Controls\Table::setSelectedIndex
   */
  public function testGetSetSelectedIndex() {
    $this->timer = new Timer(function() {
                              $this->assertEquals(new \ArrayObject(), $this->table->getSelectedIndex());

                              $this->table->setSelectedIndex(10);
                              $this->assertEquals(new \ArrayObject(), $this->table->getSelectedIndex());

                              $model = $this->createModel();
                              $model->attach($this->table);
                              $this->table->setModel($model);

                              $this->assertEquals(new \ArrayObject(), $this->table->getSelectedIndex());

                              $this->table->setSelectedIndex(0);
                              $this->assertEquals(new \ArrayObject(array(0)), $this->table->getSelectedIndex());

                              $this->table->setSelectedIndex(1);
                              $this->assertEquals(new \ArrayObject(array(0, 1)), $this->table->getSelectedIndex());

                              $this->table->setSelectedIndex(null);
                              $this->table->setSelectedIndex(1);
                              $this->assertEquals(new \ArrayObject(array(0 => 1)), $this->table->getSelectedIndex());

                              $this->timer->destroy();
                              $this->application->stop();
                            }, $this->application->getWindow(), Timer::TEST_TIMEOUT);

    $this->timer->start($this->application->getWindow());

    $this->application->start();
  }

  /**
   * This method returns a mocked model object.
   *
   * @return \Woody\Model\TableModel the mocked model object
   */
  private function createModel() {
    $model = $this->getMockBuilder('\Woody\Model\TableModel')
            ->disableOriginalConstructor()
            ->getMock();

    $model->expects($this->any())
            ->method('getColumnCount')
            ->will($this->returnValue($columns = 5));
    $model->expects($this->any())
            ->method('getRowCount')
            ->will($this->returnValue($rows = 2));
    $model->expects($this->exactly($columns * $rows))
            ->method('getEntry')
            ->will($this->onConsecutiveCalls(1, 2, 3, 4, 5, 6, 7, 8, 9, 10));
    $model->expects($this->exactly($columns))
            ->method('getColumnName')
            ->will($this->onConsecutiveCalls('A', 'B', 'C', 'D', 'E'));

    return $model;
  }
}