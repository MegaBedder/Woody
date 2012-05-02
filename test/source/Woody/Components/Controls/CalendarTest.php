<?php

namespace Woody\Components\Controls;

use \Woody\App\TestApplication;
use \Woody\Components\Timer\Timer;
use \Utils\Geom\Point;
use \Utils\Geom\Dimension;

/**
 * Test class for Calendar.
 * Generated by PHPUnit on 2011-11-15 at 23:23:15.
 */
class CalendarTest extends \PHPUnit_Framework_TestCase {
  /**
   * the calendar to test
   *
   * @var \Woody\Components\Controls\Calendar
   */
  private $calendar = null;

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

    $this->calendar = new Calendar(new Point(20, 20), new Dimension(197, 157));

    $this->application->getWindow()->add($this->calendar);
  }

  /**
   * Tears down the fixture, for example, closes a network connection.
   * This method is called after a test is executed.
   */
  protected function tearDown() {

  }

  /**
   * This method tests getting and setting the timestamp from the calendar.
   *
   * NOTE: coverage annotations fail here - coverage always at 0%, so skipped them
   *
   * @covers \Woody\Components\Controls\Calendar::getDate
   * @covers \Woody\Components\Controls\Calendar::setDate
   */
  public function testGetSetDate() {
    $this->timer = new Timer(function() {
                              $date = \DateTime::createFromFormat('d.m.Y H:i:s', '1.1.2011 00:00:00');
                              $correct = TRUE;
                              for($i = 0; $i <= 366 * 4; ++$i) {
                                $date = $date->add(new \DateInterval('P1D'));
                                $this->calendar->setDate($date);
                                $correct = $correct && ($date->format('d.m.Y') === $this->calendar->getDate()->format('d.m.Y'));
                              }
                              $this->assertTrue($correct);

                              $this->timer->destroy();
                              $this->application->stop();
                            }, $this->application->getWindow(), Timer::TEST_TIMEOUT);

    $this->timer->start();
    $this->application->start();
  }
}