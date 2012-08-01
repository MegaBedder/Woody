<?php

namespace Woody\Components\Controls;

use \Woody\App\TestApplication;
use \Woody\Components\Timer\Timer;
use \Utils\Geom\Point;
use \Utils\Geom\Dimension;

/**
 * Test class for ScrollBar.
 * Generated by PHPUnit on 2011-12-18 at 19:31:01.
 */
class ScrollBarTest extends \PHPUnit_Framework_TestCase {

  /**
   * the progress bar to test
   *
   * @var \Woody\Components\Controls\ScrollBar
   */
  private $scrollBar = null;

  /**
   * the test application
   *
   * @var \Woody\App\TestApplication
   */
  private $application = false;

  /**
   * the timer for the test application
   *
   * @var \Woody\Components\Timer\Timer
   */
  private $timer = null;

  /**
   * Sets up the fixture, for example, opens a network connection.
   * This method is called before a test is executed.
   */
  protected function setUp() {
    $this->application = new TestApplication();

    $this->scrollBar = new ScrollBar(new Point(20, 20), new Dimension(20, Timer::TEST_TIMEOUT));

    $this->application->getWindow()->getRootPane()->add($this->scrollBar);
  }

  /**
   * Tears down the fixture, for example, closes a network connection.
   * This method is called after a test is executed.
   */
  protected function tearDown() {
  }

  /**
   * @covers \Woody\Components\Controls\ScrollBar::getOffset
   * @covers \Woody\Components\Controls\ScrollBar::setOffset
   */
  public function testGetSetScrollOffset() {
    $this->timer = new Timer(function() {
                              $this->assertEquals(0, $this->scrollBar->getOffset());

                              $this->scrollBar->setOffset(100);
                              $this->assertEquals(100, $this->scrollBar->getOffset());

                              $this->timer->destroy();
                              $this->application->stop();
                            }, $this->application->getWindow(), Timer::TEST_TIMEOUT);

    $this->timer->start();

    $this->application->start();
  }

  /**
   * @covers \Woody\Components\Controls\ScrollBar::setRange
   */
  public function testSetRange() {
    $this->timer = new Timer(function() {
                              $this->assertEquals(0, $this->scrollBar->getOffset());

                              $this->scrollBar->setRange(0, Timer::TEST_TIMEOUT);
                              $this->scrollBar->setOffset(100);
                              $this->assertEquals(100, $this->scrollBar->getOffset());

                              $this->timer->destroy();
                              $this->application->stop();
                            }, $this->application->getWindow(), Timer::TEST_TIMEOUT);

    $this->timer->start();

    $this->application->start();
  }
}