<?php

namespace Woody\Components\Controls;

use \Woody\App\TestApplication;
use \Woody\Components\Timer\Timer;
use \Utils\Geom\Point;
use \Utils\Geom\Dimension;
use \Woody\Model\ListModel;

require_once 'SelectBoxTest.php';

/**
 * Test class for ComboBox.
 * Generated by PHPUnit on 2011-12-05 at 22:44:52.
 */
class ComboBoxTest extends SelectBoxTest {

    /**
     * This method returns the object under test to be used in the parent test case class.
     *
     * @return ComboBox the object under test
     */
    protected function getObjectUnderTest() {
        return new ComboBox(new Point(20, 20), new Dimension(80, 200));
    }
}