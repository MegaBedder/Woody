<?php

namespace ws\loewe\Woody\Components\Windows;

use \ws\loewe\Utils\Geom\Point;
use \ws\loewe\Utils\Geom\Dimension;
use \ws\loewe\Woody\Event\EventInfo;
use \ws\loewe\Woody\Event\WindowCloseEvent;
use \ws\loewe\Woody\WinBinderErrorException;

/**
 * Test class for AbstractWindow.
 * Generated by PHPUnit on 2010-11-25 at 20:49:16.
 */
class AbstractWindowTest extends \PHPUnit_Framework_TestCase {
  /**
   * @var AbstractWindow
   */
  protected $window;

  /**
   * Sets up the fixture, for example, opens a network connection.
   * This method is called before a test is executed.
   */
  protected function setUp() {
    $this->window = new MainWindow($this->getName().' - '.basename(__FILE__), Point::createInstance(50, 50), Dimension::createInstance(300, 200));

    $this->window->create(null);
  }

  /**
   * Tears down the fixture, for example, closes a network connection.
   * This method is called after a test is executed.
   */
  protected function tearDown() {
    $this->window->close();
  }

  /**
   * This method tests getting and setting the title of the window.
   *
   * @covers \ws\loewe\Woody\Components\Windows\AbstractWindow::getTitle
   * @covers \ws\loewe\Woody\Components\Windows\AbstractWindow::setTitle
   */
  public function testGetSetTitle() {
    $this->assertEquals($this->window->getTitle(), 'testGetSetTitle - AbstractWindowTest.php');

    $this->assertInstanceOf('\ws\loewe\Woody\Components\Windows\AbstractWindow', $this->window->setTitle('newWindowTitle'));

    $this->assertEquals($this->window->getTitle(), 'newWindowTitle');
  }

  /**
   * This method tests constructing the window.
   *
   * @covers \ws\loewe\Woody\Components\Windows\AbstractWindow::__construct
   * @covers \ws\loewe\Woody\Components\Component::__construct
   */
  public function testConstruct() {
    $this->window2 = new MainWindow('AbstractWindow', Point::createInstance(12, 34), Dimension::createInstance(456, 789));

    $this->assertEquals($this->window2->getPosition()->x, 12);
    $this->assertEquals($this->window2->getPosition()->y, 34);

    $this->assertEquals($this->window2->getDimension()->width, 456);
    $this->assertEquals($this->window2->getDimension()->height, 789);

    $this->assertNull($this->window2->getControlID());
    $this->assertNotNull($this->window2->getID());
  }

  /**
   * This method tests adding, getting and removing resize listeners.
   *
   * @covers \ws\loewe\Woody\Components\Windows\AbstractWindow::addWindowResizeListener
   * @covers \ws\loewe\Woody\Components\Windows\AbstractWindow::getWindowResizeListeners
   * @covers \ws\loewe\Woody\Components\Windows\AbstractWindow::removeWindowResizeListener
   */
  public function testWindowResizeListeners() {return;
    $resizeListener = $this->getMockBuilder('\ws\loewe\Woody\Event\WindowResizeAdapter')
      ->disableOriginalConstructor()
      ->getMock();

    $this->assertEquals($this->window, $this->window->addWindowResizeListener($resizeListener));
    $this->assertTrue($this->window->getWindowResizeListeners()->contains($resizeListener));

    $this->assertEquals($this->window, $this->window->removeWindowResizeListener($resizeListener));
    $this->assertFalse($this->window->getWindowResizeListeners()->contains($resizeListener));
  }

  /**
   * This method tests creating the window.
   *
   * @covers \ws\loewe\Woody\Components\Windows\AbstractWindow::create
   * @covers \ws\loewe\Woody\Components\Windows\AbstractWindow::createRootPane
   * @covers \ws\loewe\Woody\Components\Windows\AbstractWindow::getParameters
   */
  public function testCreate() {
    $this->window3 = new MainWindow('AbstractWindow', Point::createInstance(34, 12), Dimension::createInstance(789, 456));

    $this->window3->create();

    $this->assertNotNull($this->window3->getControlID());
    $this->assertNotNull($this->window3->getID());

    $this->window3->close();
  }

  /**
   * This method tests closing the window.
   *
   * @covers \ws\loewe\Woody\Components\Windows\AbstractWindow::close
   * @covers \ws\loewe\Woody\Components\Windows\AbstractWindow::destroy
   */
  public function testClose() {
    $this->window4 = new MainWindow('AbstractWindow', Point::createInstance(11, 22), Dimension::createInstance(555, 333));

    $this->window4->create();
    $this->window4->close();

    $this->assertEquals($this->window4->getPosition()->x, 11);
    $this->assertEquals($this->window4->getPosition()->y, 22);

    $this->assertEquals($this->window4->getDimension()->width, 555);
    $this->assertEquals($this->window4->getDimension()->height, 333);

    try {
      wb_get_id($this->window4->getControlID());
    }
    catch(WinBinderErrorException $e) {
      return;
    }

    $this->fail('The expected WinBinderErrorException has not been raised.');
  }

  /**
   * This method tests getting the root pane of the window.
   *
   * @covers \ws\loewe\Woody\Components\Windows\AbstractWindow::getRootPane
   */
  public function testGetRootPane() {
    $this->assertInstanceOf('\ws\loewe\Woody\Components\Controls\Frame', $this->window->getRootPane());
  }

  /**
   * This method tests moving the window by an offset.
   *
   * @covers \ws\loewe\Woody\Components\Component::moveBy
   * @covers \ws\loewe\Woody\Components\Component::move
   */
  public function testMoveBy() {
    $this->window->moveBy(Dimension::createInstance(10, 10));
    $this->assertEquals(60, $this->window->getPosition()->x);
    $this->assertEquals(60, $this->window->getPosition()->y);

    $this->window->moveBy(Dimension::createInstance(100, 300));
    $this->assertEquals(160, $this->window->getPosition()->x);
    $this->assertEquals(360, $this->window->getPosition()->y);

    $this->window->moveBy(Dimension::createInstance(-150, -340));
    $this->assertEquals(10, $this->window->getPosition()->x);
    $this->assertEquals(20, $this->window->getPosition()->y);

    $this->window->moveBy(Dimension::createInstance(-10, -20));
    $this->assertEquals(0, $this->window->getPosition()->x);
    $this->assertEquals(0, $this->window->getPosition()->y);
  }

  /**
   * This method tests moving the window to a location.
   *
   * @covers \ws\loewe\Woody\Components\Component::moveTo
   * @covers \ws\loewe\Woody\Components\Component::move
   */
  public function testMoveTo() {
    $this->window->moveTo(Point::createInstance(0, 0));
    $this->assertEquals(0, $this->window->getPosition()->x);
    $this->assertEquals(0, $this->window->getPosition()->y);

    $this->window->moveTo(Point::createInstance(400, 300));
    $this->assertEquals(400, $this->window->getPosition()->x);
    $this->assertEquals(300, $this->window->getPosition()->y);

    $this->window->moveTo(Point::createInstance(100, 200));
    $this->assertEquals(100, $this->window->getPosition()->x);
    $this->assertEquals(200, $this->window->getPosition()->y);

    $this->window->moveTo(Point::createInstance(0, 0));
    $this->assertEquals(0, $this->window->getPosition()->x);
    $this->assertEquals(0, $this->window->getPosition()->y);
  }

  /**
   * This method tests resizing the window by an offset.
   *
   * @covers \ws\loewe\Woody\Components\Windows\AbstractWindow::resize
   * @covers \ws\loewe\Woody\Components\Component::resizeBy
   * @covers \ws\loewe\Woody\Components\Component::resize
   */
  public function testResizeBy() {
    $this->window->resizeBy(Dimension::createInstance(0, 0));
    $this->assertEquals(300, $this->window->getDimension()->width);
    $this->assertEquals(200, $this->window->getDimension()->height);

    $this->window->resizeBy(Dimension::createInstance(500, 400));
    $this->assertEquals(800, $this->window->getDimension()->width);
    $this->assertEquals(600, $this->window->getDimension()->height);

    $this->window->resizeBy(Dimension::createInstance(-100, -200));
    $this->assertEquals(700, $this->window->getDimension()->width);
    $this->assertEquals(400, $this->window->getDimension()->height);
  }

  /**
   * This method tests resizing the window to a specific dimension.
   *
   * @covers \ws\loewe\Woody\Components\Windows\AbstractWindow::resize
   * @covers \ws\loewe\Woody\Components\Component::resizeTo
   * @covers \ws\loewe\Woody\Components\Component::resize
   */
  public function testResizeTo() {
    $this->window->resizeTo(Dimension::createInstance(300, 200));
    $this->assertEquals(300, $this->window->getDimension()->width);
    $this->assertEquals(200, $this->window->getDimension()->height);

    $this->window->resizeTo(Dimension::createInstance(600, 400));
    $this->assertEquals(600, $this->window->getDimension()->width);
    $this->assertEquals(400, $this->window->getDimension()->height);

    $this->window->resizeTo(Dimension::createInstance(300, 200));
    $this->assertEquals(300, $this->window->getDimension()->width);
    $this->assertEquals(200, $this->window->getDimension()->height);
  }

  /**
   * This method tests adding, getting and removing close listeners.
   *
   * @covers \ws\loewe\Woody\Components\Windows\AbstractWindow::setWindowCloseListener
   * @covers \ws\loewe\Woody\Components\Windows\AbstractWindow::getWindowCloseListener
   * @covers \ws\loewe\Woody\Components\Windows\AbstractWindow::removeWindowCloseListener
   * @covers \ws\loewe\Woody\Components\Windows\AbstractWindow::close
   */
  public function testWindowCloseListeners() {
    $window = new MainWindow($this->getName().'-'.basename(__FILE__), Point::createInstance(12, 34), Dimension::createInstance(456, 789));
    $window->create();

    $closeListener = $this->getMockBuilder('\ws\loewe\Woody\Event\WindowCloseAdapter')
      ->disableOriginalConstructor()
      ->getMock();
    $closeListener->expects($this->once())
        ->method('windowClosed');

    $this->assertEquals($window, $window->setWindowCloseListener($closeListener));
    $this->assertEquals($window->getWindowCloseListener(), $closeListener);

    $eventInfo = new EventInfo($window->getControlID(), IDCLOSE, $window, 0, 0);
    $windowCloseEvent = new WindowCloseEvent($eventInfo);
    $windowCloseEvent->dispatch();

    $this->assertEquals($this->window, $this->window->removeWindowCloseListener($closeListener));
    $this->assertNull($this->window->getWindowCloseListener());

    $window->close();
  }

  /**
   * This method tests adding, getting, and removing a resize listener from the window.
   *
   * @covers \ws\loewe\Woody\Components\Windows\AbstractWindow::getWindowResizeListeners
   * @covers \ws\loewe\Woody\Components\Windows\AbstractWindow::addWindowResizeListener
   * @covers \ws\loewe\Woody\Components\Windows\AbstractWindow::removeWindowResizeListener
   */
  public function testResizeListeners() {
    $this->assertEquals(0, $this->window->getWindowResizeListeners()->count());

    $resizeListener = $this->getMockBuilder('\ws\loewe\Woody\Event\WindowResizeAdapter')
                                      ->disableOriginalConstructor()
                                      ->getMock();

    $this->window->addWindowResizeListener($resizeListener);
    $this->assertEquals(1, $this->window->getWindowResizeListeners()->count());

    $this->window->removeWindowResizeListener($resizeListener);
    $this->assertEquals(0, $this->window->getWindowResizeListeners()->count());
  }
}