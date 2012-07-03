<?php

namespace Woody\Event;

use \Woody\Components\Windows\MainWindow;
use \Woody\Components\Controls\EditBox;
use \Utils\Geom\Point;
use \Utils\Geom\Dimension;

/**
 * Test class for MouseEvent.
 * Generated by PHPUnit on 2012-06-27 at 20:30:53.
 */
class MouseEventTest extends \PHPUnit_Framework_TestCase {
  /**
   * @var MouseEvent the event to be tested
   */
  private $event = null;

  /**
   * Sets up the fixture, for example, opens a network connection.
   * This method is called before a test is executed.
   */
  protected function setUp() {
    $this->event = new MouseEvent(0, 0, 0, 257, 10223723);
  }

  /**
   * Tears down the fixture, for example, closes a network connection.
   * This method is called after a test is executed.
   */
  protected function tearDown() {
  }

  /**
   * This method tests creating the event.
   *
   * @covers \Woody\Event\MouseEvent::__construct
   * @covers \Woody\Event\Event::__construct
   */
  public function testConstruct() {
    $this->assertInstanceOf('\Woody\Event\MouseEvent', $this->event);
  }

  /**
   * This methos tests getting the position of the mouse event.
   *
   * @covers \Woody\Event\MouseEvent::getPosition
   */
  public function testGetPosition() {
    $position = $this->event->getPosition();

    $this->assertEquals(107, $position->x);
    $this->assertEquals(156, $position->y);
  }

  /**
   * This method tests getting the pressed button of the event.
   *
   * @covers \Woody\Event\MouseEvent::getPressedButton
   */
  public function testGetPressedButton() {
    $this->assertEquals(MouseEvent::BUTTON1, $this->event->getPressedButton());
  }

  /**
   * This method tests getting the click count of the event.
   *
   * @covers \Woody\Event\MouseEvent::getClickCount
   */
  public function testGetClickCount() {
    $window = new MainWindow('MainWindow', new Point(50, 50), new Dimension(300, 200));
    $control1 = new EditBox('', new Point(20, 20), new Dimension(100, 18));
    $window->create()->add($control1);


    // first click
    EventFactory::createEvent(0, $control1->getID(), $control1->getControlID(), 257, 10223723);
    EventFactory::createEvent(0, $control1->getID(), $control1->getControlID(), 257, 10223723);
    EventFactory::createEvent(0, $control1->getID(), $control1->getControlID(), 257, 10223723);

    $events = self::readAttribute('\Woody\Event\EventFactory', 'eventBuffer')->getLifoOrder();
    
    $this->assertEquals(3, $events[0]->getClickCount());
    $this->assertEquals(2, $events[1]->getClickCount());
    $this->assertEquals(1, $events[2]->getClickCount());

    // delay ...
    sleep(1);

    EventFactory::createEvent(0, $control1->getID(), $control1->getControlID(), 257, 10223723);
    // ... to have one click only again
    $events = self::readAttribute('\Woody\Event\EventFactory', 'eventBuffer')->getLifoOrder();
    $this->assertEquals(1, $events[3]->getClickCount());

    $window->destroy();
  }

  /**
   * This method tests getting the string representation of the event.
   *
   * @covers \Woody\Event\MouseEvent::__toString
   * @covers \Woody\Event\Event::__toString
   */
  public function test__toString() {
    $this->assertTrue(strpos($this->event->__toString(), 'button = ') !== FALSE);
    $this->assertTrue(strpos($this->event->__toString(), 'position = ') !== FALSE);
  }
}