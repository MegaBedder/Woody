<?php

namespace ws\loewe\Woody\Event;

use \ws\loewe\Woody\Components\Windows\MainWindow;
use \ws\loewe\Woody\Components\Controls\EditBox;
use \ws\loewe\Utils\Geom\Point;
use \ws\loewe\Utils\Geom\Dimension;

/**
 * Test class for KeyEvent.
 * Generated by PHPUnit on 2012-06-25 at 22:29:09.
 */
class KeyEventTest extends \PHPUnit_Framework_TestCase {
  /**
   * @var KeyEvent the event to be tested
   */
  private $event = null;

  /**
   * Sets up the fixture, for example, opens a network connection.
   * This method is called before a test is executed.
   */
  protected function setUp() {
    $eventInfo = $this->getMockBuilder('\ws\loewe\Woody\Event\EventInfo')
      ->disableOriginalConstructor()
      ->getMock();

    // make eventInfo::property be 65
    $eventInfo->expects($this->at(4))
      ->method('__get')
      ->with($this->equalTo('property'))
      ->will($this->returnValue('65'));

    $this->event = new KeyEvent($eventInfo);
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
   * @covers \ws\loewe\Woody\Event\KeyEvent::__construct
   * @covers \ws\loewe\Woody\Event\Event::__construct
   */
  public function testConstruct() {
    $this->assertInstanceOf('\ws\loewe\Woody\Event\KeyEvent', $this->event);
  }

  /**
   * This method tests dispatching the event.
   *
   * @covers \ws\loewe\Woody\Event\KeyEvent::dispatch
   * @covers \ws\loewe\Woody\Event\KeyEvent::isKeyUpEvent
   * @covers \ws\loewe\Woody\Event\KeyEvent::isKeyDownEvent
   */
  public function testDispatch() {
    $window   = new MainWindow('MainWindow', Point::createInstance(50, 50), Dimension::createInstance(300, 200));
    $editbox  = new EditBox('', Point::createInstance(20, 20), Dimension::createInstance(100, 18));
    $window->create()->getRootPane()->add($editbox);

    $keyListener = $this->getMockBuilder('\ws\loewe\Woody\Event\KeyAdapter')
      ->disableOriginalConstructor()
      ->getMock();

    $keyListener->expects($this->once())->method('keyPressed');
    $keyListener->expects($this->once())->method('keyReleased');
    $editbox->addKeyListener($keyListener);

    $event = new KeyEvent(new EventInfo(0, $editbox->getID(), $editbox, WBC_KEYDOWN, 65));
    $event->dispatch();

    $event = new KeyEvent(new EventInfo(0, $editbox->getID(), $editbox, WBC_KEYUP, 65));
    $event->dispatch();

    $window->close();
  }

  /**
   * This method tests returning the character associated with the respective key.
   *
   * @covers \ws\loewe\Woody\Event\KeyEvent::getPressedKey
   */
  public function testGetPressedKey() {
    $this->assertEquals('A', $this->event->getPressedKey());
  }

  /**
   * This method tests the string representation of the key event.
   *
   * @covers \ws\loewe\Woody\Event\KeyEvent::__toString
   * @covers \ws\loewe\Woody\Event\Event::__toString
   */
  public function testToString() {
    $this->assertNotNull($this->event->__toString());

    $this->assertTrue(strpos($this->event->__toString(), 'key = A') !== FALSE);
  }
}