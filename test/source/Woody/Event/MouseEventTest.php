<?php

namespace ws\loewe\Woody\Event;

use \ws\loewe\Woody\Components\Windows\MainWindow;
use \ws\loewe\Woody\Components\Controls\EditBox;
use \ws\loewe\Utils\Geom\Point;
use \ws\loewe\Utils\Geom\Dimension;

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
   * @covers \ws\loewe\Woody\Event\MouseEvent::__construct
   * @covers \ws\loewe\Woody\Event\Event::__construct
   */
  public function testConstruct() {
    // some magic to enforce reinitialisation of the event buffer 
    $property = new \ReflectionProperty('\ws\loewe\Woody\Event\MouseEvent', 'eventBuffer');
    $property->setAccessible(TRUE);
    $property->setValue(null);
    
    $this->event = new MouseEvent($this->getEventInfoMock());
    $this->assertInstanceOf('\ws\loewe\Woody\Event\MouseEvent', $this->event);
  }
  
  /**
   * This method tests dispatching the event.
   *
   * @covers \ws\loewe\Woody\Event\MouseEvent::dispatch
   * @covers \ws\loewe\Woody\Event\MouseEvent::isMouseDownEvent
   * @covers \ws\loewe\Woody\Event\MouseEvent::isMouseUpEvent
   */
  public function testDispatch() {
    $window   = new MainWindow('MainWindow', Point::createInstance(50, 50), Dimension::createInstance(300, 200));
    $editbox  = new EditBox('', Point::createInstance(20, 20), Dimension::createInstance(100, 18));
    $window->create()->getRootPane()->add($editbox);

    $mouseListener = $this->getMockBuilder('\ws\loewe\Woody\Event\MouseAdapter')
      ->disableOriginalConstructor()
      ->getMock();

    $mouseListener->expects($this->once())->method('mousePressed');
    $mouseListener->expects($this->once())->method('mouseReleased');
    $editbox->addMouseListener($mouseListener);

    $event = new MouseEvent(new EventInfo(0, $editbox->getID(), $editbox, WBC_MOUSEDOWN, 0));
    $event->dispatch();

    $event = new MouseEvent(new EventInfo(0, $editbox->getID(), $editbox, WBC_MOUSEUP, 0));
    $event->dispatch();

    $window->close();
  }

  /**
   * This methos tests getting the position of the mouse event.
   *
   * @covers \ws\loewe\Woody\Event\MouseEvent::getPosition
   */
  public function testGetPosition() {
    $this->event = new MouseEvent($this->getEventInfoMock());
    $position = $this->event->getPosition();

    $this->assertEquals(107, $position->x);
    $this->assertEquals(156, $position->y);
  }

  /**
   * This method tests getting if the right button was pressed.
   *
   * @covers \ws\loewe\Woody\Event\MouseEvent::getPressedButton
   */
  public function testGetPressedButton1() {
    $this->event = new MouseEvent($this->getEventInfoMock());
    $this->assertEquals(MouseEvent::BUTTON1, $this->event->getPressedButton());
  }

  /**
   * This method tests getting if the left button was pressed.
   *
   * @covers \ws\loewe\Woody\Event\MouseEvent::getPressedButton
   */
  public function testGetPressedButton2() {
    $eventInfo = $this->getMockBuilder('\ws\loewe\Woody\Event\EventInfo')
      ->disableOriginalConstructor()
      ->getMock();

    // configure the mock to return the proper values for its members
    $eventInfo->expects($this->at(3))
      ->method('__get')
      ->with($this->equalTo('type'))
      ->will($this->returnValue(WBC_MOUSEDOWN | WBC_RBUTTON));

    $this->event = new MouseEvent($eventInfo);
    $this->assertEquals(MouseEvent::BUTTON2, $this->event->getPressedButton());
  }

  /**
   * This method tests getting if the middle button was pressed.
   *
   * @covers \ws\loewe\Woody\Event\MouseEvent::getPressedButton
   */
  public function testGetPressedButton3() {
    $eventInfo = $this->getMockBuilder('\ws\loewe\Woody\Event\EventInfo')
      ->disableOriginalConstructor()
      ->getMock();

    // configure the mock to return the proper values for its members
    $eventInfo->expects($this->at(3))
      ->method('__get')
      ->with($this->equalTo('type'))
      ->will($this->returnValue(WBC_MOUSEDOWN | WBC_MBUTTON));

    $this->event = new MouseEvent($eventInfo);
    $this->assertEquals(MouseEvent::BUTTON3, $this->event->getPressedButton());
  }

  /**
   * This method tests getting the click count of the event.
   *
   * @covers \ws\loewe\Woody\Event\MouseEvent::getClickCount
   */
  public function testGetClickCount() {
    $window = new MainWindow('MainWindow', Point::createInstance(50, 50), Dimension::createInstance(300, 200));
    $control1 = new EditBox('', Point::createInstance(20, 20), Dimension::createInstance(100, 18));
    $window->create()->getRootPane()->add($control1);

    // create a one-second delay to have a single-click only again
    sleep(1);

    $events = new \ArrayObject();
    $eventInfo = new EventInfo(0, $control1->getID(), $control1, WBC_MOUSEDOWN | WBC_LBUTTON, 0);

    // first click ...
    $events[] = new MouseEvent($eventInfo);
    // ... 2nd ...
    $events[] = new MouseEvent($eventInfo);
    // ... and 3rd
    $events[] = new MouseEvent($eventInfo);

    $this->assertEquals(1, $events[0]->getClickCount());
    $this->assertEquals(2, $events[1]->getClickCount());
    $this->assertEquals(3, $events[2]->getClickCount());

    // create a one-second delay to have a single-click only again
    sleep(1);

    $leftClickEvent   = EventFactory::createEvent($eventInfo)[0];

    $eventInfo = new EventInfo(0, $control1->getID(), $control1, WBC_MOUSEDOWN | WBC_RBUTTON, 0);
    $rightClickEvent  = EventFactory::createEvent($eventInfo)[0];

    $this->assertEquals(1, $leftClickEvent->getClickCount());
    $this->assertEquals(1, $rightClickEvent->getClickCount());

    $eventInfo    = new EventInfo(0, $control1->getID(), $control1, WBC_MOUSEUP, 0);
    $mouseUpEvent = EventFactory::createEvent($eventInfo)[0];
    $this->assertEquals(0, $mouseUpEvent->getClickCount());

    $window->close();
  }

  /**
   * This method tests getting the string representation of the event.
   *
   * @covers \ws\loewe\Woody\Event\MouseEvent::__toString
   * @covers \ws\loewe\Woody\Event\Event::__toString
   */
  public function test__toString() {
    $this->event = new MouseEvent($this->getEventInfoMock());
    $this->assertTrue(strpos($this->event->__toString(), 'button = ') !== FALSE);
    $this->assertTrue(strpos($this->event->__toString(), 'position = ') !== FALSE);
  }
  
  private function getEventInfoMock() {
    
    $eventInfo = $this->getMockBuilder('\ws\loewe\Woody\Event\EventInfo')
      ->disableOriginalConstructor()
      ->getMock();

    // configure the mock to return the proper values for its members
    $eventInfo->expects($this->at(3))
      ->method('__get')
      ->with($this->equalTo('type'))
      ->will($this->returnValue(WBC_MOUSEDOWN | WBC_LBUTTON));
    $eventInfo->expects($this->at(4))
      ->method('__get')
      ->with($this->equalTo('property'))
      ->will($this->returnValue(10223723));
    
    return $eventInfo;
  }
}