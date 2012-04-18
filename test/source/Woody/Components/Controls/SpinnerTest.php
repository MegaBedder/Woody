<?php

namespace Woody\Components\Controls;

use \Woody\App\TestApplication;
use \Woody\Components\Timer\Timer;
use \Utils\Geom\Point;
use \Utils\Geom\Dimension;

/**
 * Test class for Spinner.
 * Generated by PHPUnit on 2011-12-18 at 19:31:01.
 */
class SpinnerTest extends \PHPUnit_Framework_TestCase {

  /**
   * the progress bar to test
   *
   * @var \Woody\Components\Controls\Spinner
   */
  private $spinner = null;

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

    $this->spinner = new Spinner(new Point(105, 20), new Dimension(80, 20));

    $this->application->getWindow()->add($this->spinner);
  }

  /**
   * Tears down the fixture, for example, closes a network connection.
   * This method is called after a test is executed.
   */
  protected function tearDown() {

  }

  /**
   * @covers \Woody\Components\Controls\Spinner::getValue
   * @covers \Woody\Components\Controls\Spinner::setValue
   */
  public function testGetSetValue() {
    $this->timer = new Timer(function() {
                              $this->assertEquals(0, $this->spinner->getValue());

                              $this->spinner->setValue(100);
                              $this->assertEquals(100, $this->spinner->getValue());

                              $this->timer->destroy();
                              $this->application->stop();
                            }, $this->application->getWindow(), Timer::TEST_TIMEOUT);

    $this->timer->start($this->application->getWindow());

    $this->application->start();
  }

  /**
   * @covers \Woody\Components\Controls\Spinner::setRange
   */
  public function testSetRange() {
    $this->timer = new Timer(function() {
                              $this->assertEquals(0, $this->spinner->getValue());

                              $this->spinner->setRange(0, Timer::TEST_TIMEOUT);
                              $this->spinner->setValue(100);
                              $this->assertEquals(100, $this->spinner->getValue());

                              $this->timer->destroy();
                              $this->application->stop();
                            }, $this->application->getWindow(), Timer::TEST_TIMEOUT);

    $this->timer->start($this->application->getWindow());

    $this->application->start();
  }
}