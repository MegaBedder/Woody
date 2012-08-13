<?php

namespace Woody\Components\Windows;

use \Utils\Geom\Point;
use \Utils\Geom\Dimension;
use \Woody\Components\Timer\Timer;

/**
 * Test class for AbstractWindow.
 * Generated by PHPUnit on 2010-11-25 at 20:49:16.
 */
class AbstractWindowEventLoopTest extends \PHPUnit_Framework_TestCase {
/**
   * @var AbstractWindow
   */
  protected $window;

  /**
   * the timer to be executed in the event loop
   *
   * @var Timer
   */
  private $timer = null;

  /**
   * the counter for testing actions in the event loop.
   *
   * @var int
   */
  private $counter = 0;

  /**
   * Sets up the fixture, for example, opens a network connection.
   * This method is called before a test is executed.
   */
  protected function setUp() {
  }

  /**
   * Tears down the fixture, for example, closes a network connection.
   * This method is called after a test is executed.
   */
  protected function tearDown() {
  }


  /**
   * This method tests starting the event loop of the window.
   *
   * As this would possibly interfer with other tests in the same test class, this is the sole test of one test class.
   *
   * @covers \Woody\Components\Windows\AbstractWindow::startEventHandler
   */
  public function testStartEventHandler() {
    $this->window = new MainWindow('MainWindow', new Point(50, 50), new Dimension(300, 200));
    $this->window->create(null);
    $this->counter = 0;

    $this->assertEquals(1, ++$this->counter);
    $this->timer = new Timer(function() {
          $this->assertEquals(4, ++$this->counter);
          $this->timer->destroy();

          $this->assertEquals(5, ++$this->counter);
          $this->window->destroy();

          $this->assertEquals(6, ++$this->counter);
        }, $this->window, Timer::TEST_TIMEOUT);

    $this->assertEquals(2, ++$this->counter);
    $this->timer->start();

    $this->assertEquals(3, ++$this->counter);
    $this->window->startEventHandler();

    $this->assertEquals(7, ++$this->counter);
  }
}