<?php

namespace ws\loewe\Woody\Server;

use \ws\loewe\Woody\App\TestApplication;
use \ws\loewe\Woody\Components\Timer\Timer;
use \ws\loewe\Utils\Geom\Dimension;
use \ws\loewe\Utils\Geom\Point;
use \ws\loewe\Woody\Components\Controls\HtmlControl;
use \ws\loewe\Woody\Event\ActionAdapter;

/**
 * Test class for HtmlControlServer.
 * Generated by PHPUnit on 2012-05-30 at 22:03:19.
 */
class HtmlControlServerTest extends \PHPUnit_Framework_TestCase {
  /**
   * the server to test
   *
   * @var HtmlControlServer
   */
  private $server;

  /**
   * @var boolean simple flag to determine, if the action event of the HtmlControl was fired
   */
  private $eventFired = FALSE;

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
   * This method tests constructing a new server.
   *
   * @covers \ws\loewe\Woody\Server\HtmlControlServer::__construct
   */
  public function testConstruct() {
    $window = $this->getMockBuilder('\ws\loewe\Woody\Components\Windows\AbstractWindow')
      ->disableOriginalConstructor()
      ->getMock();

    $this->server = new HtmlControlServer($window, 9997);

    $this->assertInstanceOf('ws\loewe\Woody\Server\HtmlControlServer', $this->server);
  }

  /**
   * This method tests registering and untegistering HTML controls to and from the server.
   *
   * @covers \ws\loewe\Woody\Server\HtmlControlServer::register
   * @covers \ws\loewe\Woody\Server\HtmlControlServer::unregister
   */
  public function testRegisterUnregister() {
    $window = $this->getMockBuilder('\ws\loewe\Woody\Components\Windows\AbstractWindow')
      ->disableOriginalConstructor()
      ->getMock();

    $this->server = new HtmlControlServer($window, 9998);

    $htmlControl = $this->getMockBuilder('\ws\loewe\Woody\Components\Controls\HtmlControl')
      ->disableOriginalConstructor()
      ->getMock();

    $this->assertInstanceOf('\ws\loewe\Woody\Server\HtmlControlServer', $this->server->register($htmlControl));
    $this->assertInstanceOf('\ws\loewe\Woody\Server\HtmlControlServer', $this->server->unregister($htmlControl));
  }

  /**
   * This method tests starting the server, as well as receiving and processing events.
   *
   * @covers \ws\loewe\Woody\Server\HtmlControlServer::start
   * @covers \ws\loewe\Woody\Server\HtmlControlServer::loopOnce
   * @covers \ws\loewe\Woody\Server\HtmlControlServer::processClient
   */
  public function testStart() {
    $this->application  = new TestApplication();

    wb_set_text($this->application->getWindow()->getControlID(), $this->getName().' in '.basename(__FILE__));

    $this->server       = new HtmlControlServer($this->application->getWindow(), 7777);
    $this->callback     = function() {
      $this->timer->destroy();
      $this->application->stop();
      // @TODO: stopping fails
      //$this->server->stop();
      $this->assertTrue($this->eventFired);
    };
    $this->timer        = new Timer($this->callback, $this->application->getWindow(), Timer::TEST_TIMEOUT);

    $htmlControl        = new HtmlControl("none", Point::createInstance(10, 20), Dimension::createInstance(200, 100));

    // the action listener of the HTML control checks if the received response equals the expected one,
    // and also sets eventFired flag to true
    $htmlControl->addActionListener(new ActionAdapter(function($event) {
            $this->assertEquals('writing stuff to server socket', $event->property->getRawRequest());
            $this->eventFired = TRUE;
          }));

    $this->application->getWindow()->getRootPane()->add($htmlControl);

    $this->server->register($htmlControl);
    // starting the server has to be done really fast, i.e., timeout of 1 millisecond
    $this->server->start(1);

    $this->timer->start();

    // send something to the socket
    $fh = fsockopen('127.0.0.1', 7777, $errnum, $errstr);
    fwrite($fh, 'writing stuff to server socket');
    fclose($fh);

    $this->application->start();
  }
}