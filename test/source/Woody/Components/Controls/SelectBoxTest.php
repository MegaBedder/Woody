<?php

namespace Woody\Components\Controls;

use \Woody\App\TestApplication;
use \Woody\Components\Timer\Timer;
use \Utils\Geom\Point;
use \Utils\Geom\Dimension;
use \Woody\Model\ListModel;

/**
 * Test class for SelectBox.
 * Generated by PHPUnit on 2011-12-06 at 15:55:32.
 */
abstract class SelectBoxTest extends \PHPUnit_Framework_TestCase {

    /**
     * the select box under test
     *
     * @var \Woody\Components\Controls\SelectBox
     */
    protected $selectbox        = null;

    /**
     * the test application
     *
     * @var \Woody\App\TestApplication
     */
    protected $application      = null;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->application  = new TestApplication();

        $this->selectbox    = $this->getObjectUnderTest();

        $this->application->getWindow()->add($this->selectbox);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {

    }

    /**
     * @covers \Woody\Components\Controls\ListControl::getModel
     */
    public function testGetModel() {
        $this->timer = new Timer(function() {
                            $this->assertNull($this->selectbox->getModel());

                            $stubModel = $this->getMockBuilder('\Woody\Model\ListModel')
                                ->disableOriginalConstructor()
                                ->getMock();
                            $this->selectbox->setModel($stubModel);
                            $this->assertNotNull($this->selectbox->getModel());

                            $this->timer->destroy();
                            $this->application->stop();
                        }, $this->application->getWindow(), 100);

        $this->timer->start($this->application->getWindow());

        $this->application->start();
    }

    /**
     * @covers \Woody\Components\Controls\ListControl::setModel
     */
    public function testSetModel() {
        $this->timer = new Timer(function() {
                            $this->assertNull($this->selectbox->getModel());

                            $stubModel = $this->getMockBuilder('\Woody\Model\ListModel')
                                 ->disableOriginalConstructor()
                                 ->getMock();
                            $this->selectbox->setModel($stubModel);
                            $this->assertNotNull($this->selectbox->getModel());
                            $this->assertSame($stubModel, $this->selectbox->getModel());


                            $this->timer->destroy();
                            $this->application->stop();
                        }, $this->application->getWindow(), 100);

        $this->timer->start($this->application->getWindow());

        $this->application->start();
    }

    /**
     * @covers \Woody\Components\Controls\ListControl::update
     */
    public function testUpdate() {
        $this->timer = new Timer(function() {
                            $this->selectbox->setModel($model = new ListModel(new \ArrayObject()));

                            $model->attach($this->selectbox);
                            $model->addElement('1');

                            $this->selectbox->setSelectedIndex(0);

                            $this->assertEquals('1', $this->selectbox->getSelectedElement());


                            $this->timer->destroy();
                            $this->application->stop();
                        }, $this->application->getWindow(), 100);

        $this->timer->start($this->application->getWindow());

        $this->application->start();
    }

    /**
     * @covers \Woody\Components\Controls\ListControl::getSelectedIndex
     */
    public function testGetSelectedIndex() {
        $this->timer = new Timer(function() {
                            $this->assertEquals(-1, $this->selectbox->getSelectedIndex());

                            $this->selectbox->setSelectedIndex(10);
                            $this->assertEquals(-1, $this->selectbox->getSelectedIndex());

                            $this->selectbox->setModel($model = new ListModel(new \ArrayObject()));

                            $model->attach($this->selectbox);
                            $model->addElement('one');
                            $model->addElement('two');

                            $this->assertEquals(0, $this->selectbox->getSelectedIndex());

                            $this->selectbox->setSelectedIndex(1);
                            $this->assertEquals(1, $this->selectbox->getSelectedIndex());

                            $this->selectbox->setSelectedIndex(1);
                            $this->assertEquals(1, $this->selectbox->getSelectedIndex());

                            $this->selectbox->setSelectedIndex(2);
                            $this->assertEquals(1, $this->selectbox->getSelectedIndex());

                            $this->selectbox->setSelectedIndex(-1);
                            $this->assertEquals(-1, $this->selectbox->getSelectedIndex());

                            $this->selectbox->setSelectedIndex(1);
                            $this->assertEquals(1, $this->selectbox->getSelectedIndex());


                            $this->timer->destroy();
                            $this->application->stop();
                        }, $this->application->getWindow(), 100);

        $this->timer->start($this->application->getWindow());

        $this->application->start();
    }

    /**
     * @covers \Woody\Components\Controls\ListControl::setSelectedIndex
     */
    public function testSetSelectedIndex() {
        $this->timer = new Timer(function() {
                            $this->assertEquals(-1, $this->selectbox->getSelectedIndex());

                            $this->selectbox->setSelectedIndex(10);
                            $this->assertEquals(-1, $this->selectbox->getSelectedIndex());

                            $this->selectbox->setModel($model = new ListModel(new \ArrayObject()));

                            $model->attach($this->selectbox);
                            $model->addElement('one');
                            $model->addElement('two');

                            $this->assertEquals(0, $this->selectbox->getSelectedIndex());

                            $this->selectbox->setSelectedIndex(1);
                            $this->assertEquals(1, $this->selectbox->getSelectedIndex());

                            $this->selectbox->setSelectedIndex(2);
                            $this->assertEquals(1, $this->selectbox->getSelectedIndex());

                            $this->selectbox->setSelectedIndex(-1);
                            $this->assertEquals(-1, $this->selectbox->getSelectedIndex());

                            $this->selectbox->setSelectedIndex(1);
                            $this->assertEquals(1, $this->selectbox->getSelectedIndex());


                            $this->timer->destroy();
                            $this->application->stop();
                        }, $this->application->getWindow(), 100);

        $this->timer->start($this->application->getWindow());

        $this->application->start();
    }

    /**
     * @covers \Woody\Components\Controls\ListControl::getSelectedElement
     */
    public function testGetSelectedElement() {
        $this->timer = new Timer(function() {
                            $this->selectingElements();

                            $this->timer->destroy();
                            $this->application->stop();
                        }, $this->application->getWindow(), 100);

        $this->timer->start($this->application->getWindow());

        $this->application->start();
    }

    /**
     * @covers \Woody\Components\Controls\ListControl::setSelectedElement
     */
    public function testSetSelectedElement() {
        $this->timer = new Timer(function() {
                            $this->selectingElements();

                            $this->timer->destroy();
                            $this->application->stop();
                        }, $this->application->getWindow(), 100);

        $this->timer->start($this->application->getWindow());

        $this->application->start();
    }

    private function selectingElements() {
        $this->assertEquals(null, $this->selectbox->getSelectedElement());

        $this->selectbox->setSelectedIndex(10);
        $this->assertEquals(null, $this->selectbox->getSelectedElement());

        $this->selectbox->setModel($model = new ListModel(new \ArrayObject()));

        $model->attach($this->selectbox);
        $model->addElement('one');
        $model->addElement('two');

        $this->assertEquals('one', $this->selectbox->getSelectedElement());

        $this->selectbox->setSelectedIndex(1);
        $this->assertEquals('two', $this->selectbox->getSelectedElement());

        $this->selectbox->setSelectedIndex(1);
        $this->assertEquals('two', $this->selectbox->getSelectedElement());

        $this->selectbox->setSelectedIndex(2);
        $this->assertEquals('two', $this->selectbox->getSelectedElement());

        $this->selectbox->setSelectedIndex(-1);
        $this->assertEquals(null, $this->selectbox->getSelectedElement());

        $this->selectbox->setSelectedIndex(1);
        $this->assertEquals('two', $this->selectbox->getSelectedElement());
    }
}