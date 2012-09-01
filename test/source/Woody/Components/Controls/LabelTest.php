<?php

namespace Woody\Components\Controls;

use \Woody\App\TestApplication;
use \Woody\Components\Timer\Timer;
use \Utils\Geom\Point;
use \Utils\Geom\Dimension;

/**
 * Test class for Label.
 * Generated by PHPUnit on 2011-12-15 at 22:14:10.
 */
class LabelTest extends \PHPUnit_Framework_TestCase {

  /**
   * the push button to test
   *
   * @var \Woody\Components\Controls\Label
   */
  private $label = null;

  /**
   * the test application
   *
   * @var \Woody\App\TestApplication
   */
  private $application = null;

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

    $this->label = new Label('Label', new Point(20, 20), new Dimension(80, 20));

    $this->application->getWindow()->getRootPane()->add($this->label);
  }

  /**
   * Tears down the fixture, for example, closes a network connection.
   * This method is called after a test is executed.
   */
  protected function tearDown() {
  }

  /**
   * @covers \Woody\Components\Controls\Label::getLabel
   * @covers \Woody\Components\Controls\Label::setLabel
   */
  public function testGetSetLabel() {
    $this->timer = new Timer(function() {
                              $this->assertEquals('Label', $this->label->getLabel());

                              $this->label->setLabel('LabelNew');
                              $this->assertEquals('LabelNew', $this->label->getLabel());

                              $this->timer->destroy();
                              $this->application->stop();
                            }, $this->application->getWindow(), Timer::TEST_TIMEOUT);

    $this->timer->start();

    $this->application->start();
  }
}