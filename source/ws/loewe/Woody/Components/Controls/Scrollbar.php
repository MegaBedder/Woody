<?php

namespace ws\loewe\Woody\Components\Controls;

use \ws\loewe\Utils\Geom\Point;
use \ws\loewe\Utils\Geom\Dimension;

class ScrollBar extends Control implements Actionable {
  /**
   * This method acts as the constructor of the class.
   *
   * @param Point $topLeftCorner the top left corner of the scroll bar
   * @param Dimension $dimension the dimension of the scroll bar
   */
  public function __construct(Point $topLeftCorner, Dimension $dimension) {
    parent::__construct(null, $topLeftCorner, $dimension);

    $this->type = ScrollBar;
  }

  /**
   * This method gets the current value of the scroll bar.
   *
   * @return int the current value of the scroll bar
   */
  public function getOffset() {
    return wb_get_value($this->controlID);
  }

  /**
   * This method sets the current value of the scroll bar.
   *
   * @param $value the new value of the scroll bar
   * @return \ws\loewe\Woody\Components\Controls\ScrollBar $this
   */
  public function setOffset($value) {
    wb_set_value($this->controlID, $value);

    return $this;
  }

  /**
   * This method sets the range of the scroll bar.
   *
   * @param int $min the minimal value of the scroll bar
   * @param int $max the maximal value of the scroll bar
   * @return \ws\loewe\Woody\Components\Controls\ScrollBar $this
   */
  public function setRange($min, $max) {
    wb_set_range($this->controlID, $min, $max);

    return $this;
  }
}