<?php

namespace Woody\Event;

use \Woody\Components\Windows\MainWindow;
use \Woody\Components\Controls\EditBox;
use \Utils\Geom\Point;
use \Utils\Geom\Dimension;

/**
 * Test class for FocusEvent.
 * Generated by PHPUnit on 2012-06-26 at 21:13:09.
 */
class FocusEventTest extends \PHPUnit_Framework_TestCase {
  /**
   * @var FocusEvent the event to be tested
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
   * @covers \Woody\Event\FocusEvent::__construct
   * @covers \Woody\Event\Event::__construct
   */
  public function testConstruct() {
    $this->event = new FocusEvent(new EventInfo(0, 0, 0, 0, 0));

    $this->assertInstanceOf('\Woody\Event\FocusEvent', $this->event);
  }
  
 /**
   * This method tests dispatching the event.
   *
   * @covers \Woody\Event\FocusEvent::dispatch
   */
  public function testDispatch() {
    $window   = new MainWindow('MainWindow', new Point(50, 50), new Dimension(300, 200));
    $editbox  = new EditBox('', new Point(20, 20), new Dimension(100, 18));
    $window->create()->getRootPane()->add($editbox);
    
    $focusListener = $this->getMockBuilder('\Woody\Event\FocusAdapter')
      ->disableOriginalConstructor()
      ->getMock();
    
    $focusListener->expects($this->once())->method('focusGained');
    $editbox->addFocusListener($focusListener);

    $event = new FocusEvent(new EventInfo(0, $editbox->getID(), $editbox->getControlID(), WBC_GETFOCUS, 0));
    $event->dispatch();

    $event = new KeyEvent(new EventInfo(0, $editbox->getID(), $editbox->getControlID(), WBC_KEYUP, 65));
    $event->dispatch();
    
    $window->close();
  }

  /**
   * This method tests retrieving the component that gained the focus.
   *
   * @covers \Woody\Event\FocusEvent::getFocusGainedComponent
   * @covers \Woody\Event\FocusEvent::getFocusLostComponent
   * @covers \Woody\Event\FocusEvent::__toString
   * @covers \Woody\Event\Event::__toString
   */
  public function testGetFocusGainedComponent() {
    $window       = new MainWindow('FocusEventTest', new Point(20, 20), new Dimension(300, 200));
    $control1     = new EditBox('123', new Point(20, 20), new Dimension(100, 18));
    $control2     = new EditBox('456', new Point(20, 45), new Dimension(100, 18));

    $window->create();
    $window->getRootPane()->add($control1);
    $window->getRootPane()->add($control2);

    $this->event = new FocusEvent(new EventInfo(0, $control1->getID(), $control1->getControlID(), 0, 0, null));
    $this->assertEquals($control1, $this->event->getFocusGainedComponent());
    $this->assertNull($this->event->getFocusLostComponent());

    $this->event = new FocusEvent(new EventInfo(0, $control2->getID(), $control2->getControlID(), 0, 0), $control1);
    $this->assertEquals($control1, $this->event->getFocusLostComponent());
    $this->assertEquals($control2, $this->event->getFocusGainedComponent());

    $this->assertTrue(strpos($this->event->__toString(), 'gained = ') !== FALSE);

    $window->close();
  }
}