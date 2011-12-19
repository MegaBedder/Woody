<?php

namespace Woody\Components\Controls;

use \Woody\App\TestApplication;
use \Woody\Components\Timer\Timer;
use \Utils\Geom\Point;
use \Utils\Geom\Dimension;

/**
 * Test class for ProgressBar.
 * Generated by PHPUnit on 2011-12-18 at 19:31:01.
 */
class ProgressBarTest extends \PHPUnit_Framework_TestCase {

    /**
     * the progress bar to test
     *
     * @var \Woody\Components\Controls\Progressbar
     */
    private $progressBar     = null;

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

        $this->progressBar  = new ProgressBar(new Point(20, 20), new Dimension(80, 20));

        $this->application->getWindow()->add($this->progressBar);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {

    }

    /**
     * @covers \Woody\Components\Controls\ProgressBar::getProgress
     * @covers \Woody\Components\Controls\ProgressBar::setProgress
     */
    public function testGetSetValue() {
        $this->timer = new Timer(function() {
                            $this->assertEquals(0, $this->progressBar->getProgress());

                            $this->progressBar->setProgress(100);
                            $this->assertEquals(0, $this->progressBar->getProgress());

                            $this->timer->destroy();
                            $this->application->stop();
                        }, $this->application->getWindow(), 100);

        $this->timer->start($this->application->getWindow());

        $this->application->start();
    }

    /**
     * @covers \Woody\Components\Controls\ProgressBar::setRange
     */
    public function testSetRange() {
        $this->timer = new Timer(function() {
                            $this->assertEquals(0, $this->progressBar->getProgress());

                            $this->progressBar->setRange(0, 1000);
                            $this->progressBar->setProgress(100);
                            $this->assertEquals(0, $this->progressBar->getProgress());

                            $this->timer->destroy();
                            $this->application->stop();
                        }, $this->application->getWindow(), 100);

        $this->timer->start($this->application->getWindow());

        $this->application->start();
    }
}