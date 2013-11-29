<?php

namespace ws\loewe\Woody\Components\Controls;

use \ws\loewe\Woody\App\TestApplication;
use \ws\loewe\Woody\Components\Timer\Timer;
use \ws\loewe\Utils\Geom\Point;
use \ws\loewe\Utils\Geom\Dimension;

/**
 * Test class for EditBox.
 * Generated by PHPUnit on 2011-11-15 at 23:23:15.
 */
class EditBoxTest extends \PHPUnit_Framework_TestCase {
  /**
   * the edit box to test
   *
   * @var \ws\loewe\Woody\Components\Controls\EditBox
   */
  private $editBox = null;

  /**
   * the test application
   *
   * @var \ws\loewe\Woody\App\TestApplication
   */
  private $application = null;

/**
   * the timer for the test application
   *
   * @var \ws\loewe\Woody\Components\Timer\Timer
   */
  private $timer = null;

  /**
   * Sets up the fixture, for example, opens a network connection.
   * This method is called before a test is executed.
   */
  protected function setUp() {
    $this->application = new TestApplication();

    $this->editBox = new EditBox('', Point::createInstance(20, 20), Dimension::createInstance(100, 18));

    $this->application->getWindow()->getRootPane()->add($this->editBox);
  }

  /**
   * Tears down the fixture, for example, closes a network connection.
   * This method is called after a test is executed.
   */
  protected function tearDown() {
  }

  /**
   * This method tests retrieving the value from the editbox.
   *
   * @covers \ws\loewe\Woody\Components\Controls\EditBox::getValue
   */
  public function testGetValue() {
    $this->timer = new Timer(function() {
          $value = 'testGetValue';
          $this->editBox->setValue($value);
          $this->assertEquals($value, $this->editBox->getValue());

          $this->editBox->setValue('   ');
          $this->assertNull($this->editBox->getValue());

          $this->editBox->setValue(null);
          $this->assertNull($this->editBox->getValue());

          $this->timer->destroy();
          $this->application->stop();
        }, $this->application->getWindow(), Timer::TEST_TIMEOUT);

    $this->timer->start();

    $this->application->start();
  }

  /**
   * This method tests retrieving the trimmed value from the editbox.
   *
   * @covers \ws\loewe\Woody\Components\Controls\EditBox::getValue
   */
  public function testGetValueTrimmed() {
    $this->timer = new Timer(function() {
                              $value = '     testGetValueTrimmed     ';
                              $this->editBox->setValue($value);
                              $this->assertEquals(trim($value), $this->editBox->getValue());

                              $this->timer->destroy();
                              $this->application->stop();
                            }, $this->application->getWindow(), Timer::TEST_TIMEOUT);

    $this->timer->start();

    $this->application->start();
  }

  /**
   * This method tests retrieving the non-trimmed value from the editbox.
   *
   * @covers \ws\loewe\Woody\Components\Controls\EditBox::getValue
   */
  public function testGetValueNotTrimmed() {
    $this->timer = new Timer(function() {
                              $value = '     testGetValueNotTrimmed     ';
                              $this->editBox->setValue($value);
                              $this->assertEquals($value, $this->editBox->getValue(FALSE));
                              $this->timer->destroy();

                              $this->application->stop();
                            }, $this->application->getWindow(), Timer::TEST_TIMEOUT);

    $this->timer->start();
    $this->application->start();
  }

  /**
   * This method tests setting a text value for the editbox.
   *
   * @covers \ws\loewe\Woody\Components\Controls\EditBox::setValue
   */
  public function testSetValueText() {
    $this->timer = new Timer(function() {
                              $value = 'someNewValue';
                              $this->editBox->setValue($value);
                              $this->assertEquals($value, $this->editBox->getValue(FALSE));
                              $this->timer->destroy();

                              $this->application->stop();
                            }, $this->application->getWindow(), Timer::TEST_TIMEOUT);

    $this->timer->start();
    $this->application->start();
  }

  /**
   * This method tests setting a integer value for the editbox.
   *
   * @covers \ws\loewe\Woody\Components\Controls\EditBox::setValue
   */
  public function testSetValueInteger() {
    $this->timer = new Timer(function() {
                              $value = 123;
                              $this->editBox->setValue($value);
                              $this->assertEquals($value, $this->editBox->getValue(FALSE));
                              $this->timer->destroy();

                              $this->application->stop();
                            }, $this->application->getWindow(), Timer::TEST_TIMEOUT);

    $this->timer->start();
    $this->application->start();
  }

  /**
   * This method tests setting a decimal value for the editbox.
   *
   * @covers \ws\loewe\Woody\Components\Controls\EditBox::setValue
   */
  public function testSetValueDecimal() {
    $this->timer = new Timer(function() {
                              $value = 123.99;
                              $this->editBox->setValue($value);
                              $this->assertEquals($value, $this->editBox->getValue(FALSE));
                              $this->timer->destroy();

                              $this->application->stop();
                            }, $this->application->getWindow(), Timer::TEST_TIMEOUT);

    $this->timer->start();
    $this->application->start();
  }

  /**
   * This method tests setting the editbox readonly.
   *
   * @covers \ws\loewe\Woody\Components\Controls\EditBox::setReadOnly
   */
  public function testSetReadOnly() {
    $callback = function() {
      $this->assertSame($this->editBox, $this->editBox->setReadOnly(TRUE));
      $this->assertSame($this->editBox, $this->editBox->setReadOnly(FALSE));

      $this->timer->destroy();
      $this->application->stop();
    };
    $this->timer = new Timer($callback, $this->application->getWindow(), Timer::TEST_TIMEOUT);

    $this->timer->start();
    $this->application->start();
  }

  /**
   * This method tests setting the cursor of the editbox.
   *
   * @covers \ws\loewe\Woody\Components\Controls\EditBox::setCursor
   */
  public function testSetCursor() {
    $callback = function() {
      $this->editBox->setValue('');
      $this->assertSame($this->editBox, $this->editBox->setCursor(0));
      $this->assertSame($this->editBox, $this->editBox->setCursor(-1));

      $this->editBox->setValue('someText');
      $this->assertSame($this->editBox, $this->editBox->setCursor(0));
      $this->assertSame($this->editBox, $this->editBox->setCursor(-1));
      $this->assertSame($this->editBox, $this->editBox->setCursor(7));
      $this->assertSame($this->editBox, $this->editBox->setCursor(8));
      $this->assertSame($this->editBox, $this->editBox->setCursor(9));
      $this->assertSame($this->editBox, $this->editBox->setCursor(10));

      $this->timer->destroy();
      $this->application->stop();
    };
    $this->timer = new Timer($callback, $this->application->getWindow(), Timer::TEST_TIMEOUT);

    $this->timer->start();
    $this->application->start();
  }
}