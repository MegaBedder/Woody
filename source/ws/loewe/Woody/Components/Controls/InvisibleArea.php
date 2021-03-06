<?php

namespace ws\loewe\Woody\Components\Controls;

use \ws\loewe\Utils\Geom\Point;
use \ws\loewe\Utils\Geom\Dimension;

class InvisibleArea extends Control implements Actionable {
  /**
   * This method acts as the constructor of the class.
   *
   * @param Point $topLeftCorner the top left corner of the invisible area
   * @param Dimension $dimension the dimension of the invisible area
   */
  public function __construct(Point $topLeftCorner, Dimension $dimension) {
    parent::__construct(null, $topLeftCorner, $dimension);

    $this->type = InvisibleArea;
  }
}