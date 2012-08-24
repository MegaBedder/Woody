<?php

namespace Woody\Server;

use \Woody\App\TestApplication;
use \Woody\Components\Timer\Timer;
use \Utils\Geom\Dimension;
use \Utils\Geom\Point;
use \Woody\Components\Controls\HtmlControl;
use \Woody\Event\ActionAdapter;

/**
 * Test class for BuiltInWebServer.
 * Generated by PHPUnit on 2012-06-18 at 21:13:27.
 */
class BuiltInWebServerTest extends \PHPUnit_Framework_TestCase {
  /**
   * @var BuiltInWebServer
   */
  protected $server = null;

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
   * @covers \Woody\Server\BuiltInWebServer::__construct
   */
  public function testConstruct() {
    $window = $this->getMockBuilder('\Woody\Components\Windows\AbstractWindow')
      ->disableOriginalConstructor()
      ->getMock();

    $this->server = new BuiltInWebServer(
      $window,
      9990,
      '.',
      '"C:\\Program Files\\PHP54\\php.exe"',
      'D:\\workspace\\programming\\PHP\\woody\\doc\\examples\\server.php',
      new HtmlControlServer($window, 1235));

    $this->assertInstanceOf('Woody\Server\BuiltInWebServer', $this->server);
  }

  /**
   * This method tests starting the server.
   *
   * @covers \Woody\Server\BuiltInWebServer::start
   * @covers \Woody\Server\BuiltInWebServer::stop
   */
  public function testStart() {
    $this->application  = new TestApplication();
    wb_set_text($this->application->getWindow()->getControlID(), $this->getName().' in '.basename(__FILE__));

    $this->server = new BuiltInWebServer(
      $this->application->getWindow(),
      9991,
      '.',
      '"C:\\Program Files\\PHP54\\php.exe"',
      'D:\\workspace\\programming\\PHP\\woody\\doc\\examples\\server.php',
      new HtmlControlServer($this->application->getWindow(), 1234));

    $this->callback     = function() {
      if($this->eventFired) {
        $this->server->stop();
        $this->timer->destroy();
        $this->application->stop();

        $this->assertTrue($this->eventFired);
      }
    };

    $this->timer = new Timer($this->callback, $this->application->getWindow(), Timer::TEST_TIMEOUT);
    $htmlControl = new HtmlControl('http://www.loewe.ws', new Point(10, 20), new Dimension(200, 100));

    // the action listener of the HTML control checks, if the received response equals the expected one,
    // and also sets counter to 1
    $htmlControl->addActionListener(new ActionAdapter(function($event) {
            $this->assertEquals('/?woody=great', $event->property->getRawRequest());
            $event->type->write('success');
            $this->eventFired = TRUE;
          }));

    $this->application->getWindow()->getRootPane()->add($htmlControl);

    $this->server->register($htmlControl);

    $this->server->start();

    $this->timer->start();

    // send something to the socket
    file_get_contents('http://127.0.0.1:9991?woody=great');

    $this->application->start();
  }

  /**
   * This method tests registering and untegistering HTML controls to and from the server.
   *
   * @covers \Woody\Server\BuiltInWebServer::register
   * @covers \Woody\Server\BuiltInWebServer::unregister
   */
  public function testRegisterUnregister() {
    $window = $this->getMockBuilder('\Woody\Components\Windows\AbstractWindow')
      ->disableOriginalConstructor()
      ->getMock();

    $replyServer = $this->getMockBuilder('\Woody\Server\HtmlControlServer')
      ->disableOriginalConstructor()
      ->getMock();

    $this->server = new BuiltInWebServer(
      $window,
      9992,
      '.',
      '',
      '',
      $replyServer);

    $htmlControl = $this->getMockBuilder('\Woody\Components\Controls\HtmlControl')
      ->disableOriginalConstructor()
      ->getMock();

    $this->assertInstanceOf('\Woody\Server\BuiltInWebServer', $this->server->register($htmlControl));
    $this->assertInstanceOf('\Woody\Server\BuiltInWebServer', $this->server->unregister($htmlControl));
  }
}