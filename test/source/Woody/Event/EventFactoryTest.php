<?php

namespace Woody\Event;

/**
 * Test class for EventFactory.
 * Generated by PHPUnit on 2012-09-02 at 16:20:38.
 */
class EventFactoryTest extends \PHPUnit_Framework_TestCase {
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
   * @covers Woody\Event\EventFactory::createEvent
   * @todo Implement testCreateEvent().
   */
  public function testCreateEvent() {return;
    $this->application = new TestApplication();

    $callback = function() {

      globalWinBinderEventHandler(48129752, 8, 48129752, 0, 0);

      $this->timer->destroy();
      $this->application->stop();
    };

    $this->timer = new Timer($callback, $this->application->getWindow(), Timer::TEST_TIMEOUT);

    $this->timer->start();

    $this->application->start();
  }

  /**
   * @covers Woody\Event\EventFactory::getClickCount
   * @todo Implement testGetClickCount().
   */
  public function testGetClickCount() {return;
    // Remove the following lines when you implement this test.
    $this->markTestIncomplete(
      'This test has not been implemented yet.'
    );
  }
}