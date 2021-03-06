<?php

namespace ws\loewe\Woody\Components\Controls;

use \ws\loewe\Utils\Geom\Point;
use \ws\loewe\Utils\Geom\Dimension;

class EditBox extends EditField {
  /**
   * This method acts as the constructor of the class.
   *
   * @param mixed $value the preset value of the edit box
   * @param Point $topLeftCorner the top left corner of the edit box
   * @param Dimension $dimension the dimension of the edit box
   */
  public function __construct($value, Point $topLeftCorner, Dimension $dimension) {
    parent::__construct($value, $topLeftCorner, $dimension);
  }
}