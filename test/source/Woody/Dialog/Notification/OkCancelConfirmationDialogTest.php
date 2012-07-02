<?php

namespace Woody\Dialog\Notification;

/**
 * Test class for OkCancelConfirmationDialog.
 * Generated by PHPUnit on 2012-07-02 at 23:35:13.
 */
class OkCancelConfirmationDialogTest extends \PHPUnit_Framework_TestCase {
  /**
   * @var OkCancelConfirmationDialog
   */
  protected $dialog;

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
   * This method tests creating the dialog.
   *
   * @covers \Woody\Dialog\FileSystem\OkCancelConfirmationDialog::__construct
   * @covers \Woody\Dialog\FileSystem\ConfirmationDialog::__construct
   * @covers \Woody\Dialog\FileSystem\ModalSystemDialog::__construct
   */
  public function YesNoCancelConfirmationDialog() {
    $this->dialog = new OkCancelConfirmationDialog('testConstruct', 'testConstruct', null);

    $this->assertInstanceOf('\Woody\Dialog\FileSystem\OkCancelConfirmationDialog', $this->dialog);
  }
}