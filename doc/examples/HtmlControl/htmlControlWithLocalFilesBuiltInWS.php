<?php

require_once(realpath(__DIR__.'/../../../source/bootstrap.php'));

use ws\loewe\Utils\Geom\Dimension;
use ws\loewe\Utils\Geom\Point;
use ws\loewe\Utils\Logging\Logger;
use ws\loewe\Woody\App\Application;
use ws\loewe\Woody\Components\Controls\HTMLControl;
use ws\loewe\Woody\Components\Controls\PushButton;
use ws\loewe\Woody\Components\Windows\MainWindow;
use ws\loewe\Woody\Event\ActionAdapter;
use ws\loewe\Woody\Event\ActionEvent;
use ws\loewe\Woody\Event\WindowCloseAdapter;
use ws\loewe\Woody\Server\BuiltInWebServer;
use ws\loewe\Woody\Server\HtmlControlServer;

class HTMLControlDemoBuiltInWebServer extends Application {

    /**
     * the BuiltInWebServer this application uses to server and interact with content
     *
     * @var BuiltInWebServer
     */
    private $server = null;

    /**
     * the document root of the web server
     *
     * @var string
     */
    private $documentRoot = null;

    /**
     * the port on which the server is listening on.
     *
     * @var int
     */
    private $port   = null;

    public function __construct($port) {
        parent::__construct();
        Logger::setLogLevel(Logger::ALL);
        $this->port         = $port;

        $this->documentRoot = __DIR__.'\\www';

        $this->window       = new MainWindow('built-in-webserver', Point::createInstance(50, 50), Dimension::createInstance(800, 500));
        $this->window->create();

        $this->htmlControl  = new HTMLControl('http://127.0.0.1:'.$this->port, Point::createInstance(20, 25), Dimension::createInstance(760, 300));$this->btnRoot      = new PushButton("document root", Point::createInstance(20, 345), Dimension::createInstance(100, 22));
        $this->btnWeb       = new PushButton("www.google.com", Point::createInstance(135, 345), Dimension::createInstance(100, 22));
        $this->btnPhpInfo   = new PushButton("phpinfo()", Point::createInstance(250, 345), Dimension::createInstance(100, 22));

        $this->htmlControl->addActionListener(new ActionAdapter($this->getHtmlControlCallback()));
        $this->window->getRootPane()->add($this->htmlControl);

        $this->btnRoot->addActionListener(new ActionAdapter($this->getBtnRootCallback()));
        $this->window->getRootPane()->add($this->btnRoot);

        $this->btnWeb->addActionListener(new ActionAdapter($this->getBtnWebCallback()));
        $this->window->getRootPane()->add($this->btnWeb);

        $this->btnPhpInfo->addActionListener(new ActionAdapter($this->getBtnPhpInfoCallback()));
        $this->window->getRootPane()->add($this->btnPhpInfo);

        $this->window->setWindowCloseListener(
          new WindowCloseAdapter(
            function($event) {
              $event->getSource()->close();
            }));
    }

    private function getHtmlControlCallback() {
        return function(ActionEvent $event) {
                    $content = '<h1>header, large</h1>'
                      .'<br>followed by an image ...<br>'
                      .'<img src="woody.png">';
                    $event->type->write($content);
                    $event->type->write(file_get_contents($this->documentRoot.'\\woody.png'));
                };
    }

    private function getBtnRootCallback() {
        return function() {
            $this->htmlControl->setUrl('http://127.0.0.1:'.$this->port);
        };
    }

    private function getBtnWebCallback() {
        return function() {
            $this->htmlControl->setUrl('http://www.google.com');
        };
    }

    private function getBtnPhpInfoCallback() {
        return function() {
            $this->htmlControl->setUrl('http://127.0.0.1:'.$this->port.'/phpinfo.php');
        };
    }

    public function start() {
        $this->server = new BuiltInWebServer(
          $this->window,
          $this->port,
          $this->documentRoot,
          'php.exe',
          'server.php',
          new HtmlControlServer($this->window, 1234));

        $this->server->start()->register($this->htmlControl);

        parent::start();
    }

    public function stop() {
        $this->server->stop();
    }
}

$app = new HTMLControlDemoBuiltInWebServer(5555);
$app->start();
$app->stop();