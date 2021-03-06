<?php

namespace ws\loewe\Woody\Components\Controls;

use \ws\loewe\Utils\Geom\Point;
use \ws\loewe\Utils\Geom\Dimension;

class ComboBox extends ListControl {

  /**
   * This method acts as the constructor of the class.
   *
   * @param Point $topLeftCorner the top left corner of the combo box
   * @param Dimension $dimension the dimension of the combo box
   */
  public function __construct(Point $topLeftCorner, Dimension $dimension) {
    parent::__construct($topLeftCorner, $dimension);

    $this->type = ComboBox;
  }
}