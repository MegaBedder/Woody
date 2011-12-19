<?php

namespace Woody\Components\Controls;

use \Woody\App\TestApplication;
use \Woody\Components\Timer\Timer;
use \Utils\Geom\Point;
use \Utils\Geom\Dimension;

/**
 * Test class for PushButton.
 * Generated by PHPUnit on 2011-12-15 at 22:14:10.
 */
class PushButtonTest extends \PHPUnit_Framework_TestCase {

    /**
     * the push button to test
     *
     * @var \Woody\Components\Controls\PushButton
     */
    private $pushButton     = null;

    /**
     * the test application
     *
     * @var \Woody\App\TestApplication
     */
    private $application    = false;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->application  = new TestApplication();

        $this->pushButton   = new PushButton('buttonLabel', new Point(20, 20), new Dimension(80, 20));

        $this->application->getWindow()->add($this->pushButton);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {

    }

    /**
     * @covers \Woody\Components\Controls\PushButton::getLabel
     * @covers \Woody\Components\Controls\PushButton::setLabel
     */
    public function testGetSetLabel() {
        $this->timer = new Timer(function() {
                            $this->assertEquals('buttonLabel', $this->pushButton->getLabel());

                            $this->pushButton->setLabel('pushButtonNew');
                            $this->assertEquals('pushButtonNew', $this->pushButton->getLabel());

                            $this->timer->destroy();
                            $this->application->stop();
                        }, $this->application->getWindow(), 100);

        $this->timer->start($this->application->getWindow());

        $this->application->start();
    }
}