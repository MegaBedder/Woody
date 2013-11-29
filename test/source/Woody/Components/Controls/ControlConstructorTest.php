<?php

namespace ws\loewe\Woody\Components\Controls;

use \ws\loewe\Woody\Components\Windows\MainWindow;
use \ws\loewe\Utils\Geom\Point;
use \ws\loewe\Utils\Geom\Dimension;

/**
 * Test class for PushButton.
 * Generated by PHPUnit on 2011-12-15 at 22:14:10.
 */
class ControlConstructorTest extends \PHPUnit_Framework_TestCase {
  /**
   * the control to test
   *
   * @var \ws\loewe\Woody\Components\Controls\Control
   */
  private $control = null;

  /**
   * the window to hold the control
   *
   * @var \ws\loewe\Woody\Components\Controls\Windows\AbstractWindow
   */
  private $window = null;

  /**
   * Sets up the fixture, for example, opens a network connection.
   * This method is called before a test is executed.
   */
  protected function setUp() {
    $this->window = new MainWindow('ControlConstructTest', Point::createInstance(10, 10), Dimension::createInstance(300, 200));
    $this->window->create();
  }

  /**
   * Tears down the fixture, for example, closes a network connection.
   * This method is called after a test is executed.
   */
  protected function tearDown() {
    $this->window->close();
  }

  /**
   * @covers \ws\loewe\Woody\Components\Component::__construct
   * @covers \ws\loewe\Woody\Components\Controls\Control::__construct
   * @covers \ws\loewe\Woody\Components\Controls\Calendar::__construct
   */
  public function testConstructCalendar() {
    $this->control = new Calendar(Point::createInstance(20, 20), Dimension::createInstance(120, 20));
    $this->assertNotNull($this->control->getID());
  }

  /**
   * @covers \ws\loewe\Woody\Components\Component::__construct
   * @covers \ws\loewe\Woody\Components\Controls\Control::__construct
   * @covers \ws\loewe\Woody\Components\Controls\Checkbox::__construct
   */
  public function testConstructCheckbox() {
    $this->control = new Checkbox(FALSE, Point::createInstance(20, 20), Dimension::createInstance(120, 20));
    $this->assertNotNull($this->control->getID());
  }

  /**
   * @covers \ws\loewe\Woody\Components\Component::__construct
   * @covers \ws\loewe\Woody\Components\Controls\Control::__construct
   * @covers \ws\loewe\Woody\Components\Controls\ListControl::__construct
   * @covers \ws\loewe\Woody\Components\Controls\ComboBox::__construct
   */
  public function testConstructComboBox() {
    $this->control = new ComboBox(Point::createInstance(20, 20), Dimension::createInstance(120, 20));
    $this->assertNotNull($this->control->getID());
  }

  /**
   * @covers \ws\loewe\Woody\Components\Component::__construct
   * @covers \ws\loewe\Woody\Components\Controls\Control::__construct
   * @covers \ws\loewe\Woody\Components\Controls\EditField::__construct
   * @covers \ws\loewe\Woody\Components\Controls\EditBox::__construct
   */
  public function testConstructEditBox() {
    $this->control = new EditBox('testConstructEditBox', Point::createInstance(20, 20), Dimension::createInstance(120, 20));
    $this->assertNotNull($this->control->getID());
  }

  /**
   * @covers \ws\loewe\Woody\Components\Component::__construct
   * @covers \ws\loewe\Woody\Components\Controls\Control::__construct
   * @covers \ws\loewe\Woody\Components\Controls\EditField::__construct
   * @covers \ws\loewe\Woody\Components\Controls\EditArea::__construct
   */
  public function testConstructEditArea() {
    $this->control = new EditArea('testConstructEditArea', Point::createInstance(20, 20), Dimension::createInstance(120, 20));
    $this->assertNotNull($this->control->getID());
  }

  /**
   * @covers \ws\loewe\Woody\Components\Component::__construct
   * @covers \ws\loewe\Woody\Components\Controls\Control::__construct
   * @covers \ws\loewe\Woody\Components\Controls\Frame::__construct
   * @covers \ws\loewe\Woody\Components\Controls\Frame::create
   */
  public function testConstructFrame() {
    $this->control = new Frame('testConstructFrame', Point::createInstance(20, 20), Dimension::createInstance(120, 20));
    $this->assertNotNull($this->control->getID());

    $this->window->getRootPane()->add($this->control);
    $this->assertEquals($this->window->getRootPane(), $this->control->getParent());
  }

  /**
   * @covers \ws\loewe\Woody\Components\Component::__construct
   * @covers \ws\loewe\Woody\Components\Controls\Control::__construct
   * @covers \ws\loewe\Woody\Components\Controls\HtmlControl::__construct
   * @covers \ws\loewe\Woody\Components\Controls\HtmlControl::create
   */
  public function testConstructHtmlControl() {
    $this->control = new HtmlControl('http://www.loewe.ws', Point::createInstance(20, 20), Dimension::createInstance(120, 20));
    $this->assertNotNull($this->control->getID());

    $this->window->getRootPane()->add($this->control);
    $this->assertEquals($this->window->getRootPane(), $this->control->getParent());
  }

  /**
   * @covers \ws\loewe\Woody\Components\Component::__construct
   * @covers \ws\loewe\Woody\Components\Controls\Control::__construct
   * @covers \ws\loewe\Woody\Components\Controls\Image::__construct
   * @covers \ws\loewe\Woody\Components\Controls\Image::create
   * @covers \ws\loewe\Woody\Components\Controls\Image::setImage
   */
  public function testConstructImage() {
    $imageResource = $this->getMockBuilder('\ws\loewe\Woody\Util\Image\ImageResource')->disableOriginalConstructor()->getMock();
    $this->control = new Image($imageResource, Point::createInstance(20, 20), Dimension::createInstance(120, 20));
    $this->assertNotNull($this->control->getID());

    $imageResource->expects($this->once())
      ->method('getResource')
      ->will($this->returnValue(\ws\loewe\Woody\Util\Image\ImageResource::create(Dimension::createInstance(10, 10))->getResource()));

    $this->window->getRootPane()->add($this->control);
    $this->assertEquals($this->window->getRootPane(), $this->control->getParent());
  }

  /**
   * @covers \ws\loewe\Woody\Components\Component::__construct
   * @covers \ws\loewe\Woody\Components\Controls\Control::__construct
   * @covers \ws\loewe\Woody\Components\Controls\Button::__construct
   * @covers \ws\loewe\Woody\Components\Controls\ImageButton::__construct
   * @covers \ws\loewe\Woody\Components\Controls\ImageButton::create
   * @covers \ws\loewe\Woody\Components\Controls\ImageButton::setImage
   */
  public function testConstructImageButton() {
    $imageResource = $this->getMockBuilder('\ws\loewe\Woody\Util\Image\ImageResource')->disableOriginalConstructor()->getMock();
    $imageResource->expects($this->once())
      ->method('getResource')
      ->will($this->returnValue(\ws\loewe\Woody\Util\Image\ImageResource::create(Dimension::createInstance(10, 10))->getResource()));

    $this->control = new ImageButton($imageResource, Point::createInstance(20, 20), Dimension::createInstance(120, 20));
    $this->assertNotNull($this->control->getID());

    $this->window->getRootPane()->add($this->control);
    $this->assertEquals($this->window->getRootPane(), $this->control->getParent());
  }

  /**
   * @covers \ws\loewe\Woody\Components\Component::__construct
   * @covers \ws\loewe\Woody\Components\Controls\Control::__construct
   * @covers \ws\loewe\Woody\Components\Controls\InvisibleArea::__construct
   */
  public function testConstructInvisibleArea() {
    $this->control = new InvisibleArea(Point::createInstance(20, 20), Dimension::createInstance(120, 20));
    $this->assertNotNull($this->control->getID());
  }

  /**
   * @covers \ws\loewe\Woody\Components\Component::__construct
   * @covers \ws\loewe\Woody\Components\Controls\Control::__construct
   * @covers \ws\loewe\Woody\Components\Controls\Label::__construct
   */
  public function testConstructLabel() {
    $this->control = new Label('testConstructLabel', Point::createInstance(20, 20), Dimension::createInstance(120, 20));
    $this->assertNotNull($this->control->getID());
  }

  /**
   * @covers \ws\loewe\Woody\Components\Component::__construct
   * @covers \ws\loewe\Woody\Components\Controls\Control::__construct
   * @covers \ws\loewe\Woody\Components\Controls\ListControl::__construct
   * @covers \ws\loewe\Woody\Components\Controls\ListControl::getDefaultCellRenderer
   * @covers \ws\loewe\Woody\Components\Controls\ListBox::__construct
   */
  public function testConstructListBox() {
    $this->control = new ListBox(Point::createInstance(20, 20), Dimension::createInstance(120, 20));
    $this->assertNotNull($this->control->getID());
  }

  /**
   * @covers \ws\loewe\Woody\Components\Component::__construct
   * @covers \ws\loewe\Woody\Components\Controls\Control::__construct
   * @covers \ws\loewe\Woody\Components\Controls\ProgressBar::__construct
   */
  public function testConstructProgressBar() {
    $this->control = new ProgressBar(Point::createInstance(20, 20), Dimension::createInstance(120, 20));
    $this->assertNotNull($this->control->getID());
  }

  /**
   * @covers \ws\loewe\Woody\Components\Component::__construct
   * @covers \ws\loewe\Woody\Components\Controls\Control::__construct
   * @covers \ws\loewe\Woody\Components\Controls\Button::__construct
   * @covers \ws\loewe\Woody\Components\Controls\PushButton::__construct
   */
  public function testConstructPushButton() {
    $this->control = new PushButton('buttonConstruct', Point::createInstance(20, 20), Dimension::createInstance(120, 20));
    $this->assertNotNull($this->control->getID());
  }

  /**
   * @covers \ws\loewe\Woody\Components\Component::__construct
   * @covers \ws\loewe\Woody\Components\Controls\Control::__construct
   * @covers \ws\loewe\Woody\Components\Controls\ScrollBar::__construct
   */
  public function testConstructScrollBar() {
    $this->control = new ScrollBar(Point::createInstance(20, 20), Dimension::createInstance(120, 20));
    $this->assertNotNull($this->control->getID());
  }

  /**
   * @covers \ws\loewe\Woody\Components\Component::__construct
   * @covers \ws\loewe\Woody\Components\Controls\Control::__construct
   * @covers \ws\loewe\Woody\Components\Controls\Slider::__construct
   */
  public function testConstructSlider() {
    $this->control = new Slider(Point::createInstance(20, 20), Dimension::createInstance(120, 20));
    $this->assertNotNull($this->control->getID());
  }

  /**
   * @covers \ws\loewe\Woody\Components\Component::__construct
   * @covers \ws\loewe\Woody\Components\Controls\Control::__construct
   * @covers \ws\loewe\Woody\Components\Controls\Spinner::__construct
   */
  public function testConstructSpinner() {
    $this->control = new Spinner(Point::createInstance(20, 20), Dimension::createInstance(120, 20));
    $this->assertNotNull($this->control->getID());
  }

  /**
   * @covers \ws\loewe\Woody\Components\Component::__construct
   * @covers \ws\loewe\Woody\Components\Controls\Control::__construct
   * @covers \ws\loewe\Woody\Components\Controls\Tab::__construct
   */
  public function testConstructTab() {
    $this->control = new Tab(Point::createInstance(20, 20), Dimension::createInstance(120, 20));
    $this->assertNotNull($this->control->getID());
  }

  /**
   * @covers \ws\loewe\Woody\Components\Component::__construct
   * @covers \ws\loewe\Woody\Components\Controls\Control::__construct
   * @covers \ws\loewe\Woody\Components\Controls\Table::__construct
   */
  public function testConstructTable() {
    $this->control = new Table(Point::createInstance(20, 20), Dimension::createInstance(120, 20));
    $this->assertNotNull($this->control->getID());
  }

  /**
   * @covers \ws\loewe\Woody\Components\Component::__construct
   * @covers \ws\loewe\Woody\Components\Controls\Control::__construct
   * @covers \ws\loewe\Woody\Components\Controls\TreeView::__construct
   * @covers \ws\loewe\Woody\Components\Controls\TreeView::getDefaultNodeRenderer
   */
  public function testConstructTreeView() {
    $this->control = new TreeView(Point::createInstance(20, 20), Dimension::createInstance(120, 20));
    $this->assertNotNull($this->control->getID());
  }
}