<?php

namespace Woody\Components\Controls;

use \Woody\Model\ListModel;
use \Utils\Geom\Point;
use \Utils\Geom\Dimension;

abstract class ListControl extends Control implements \SplObserver {

    /**
     * the model of the list control
     *
     * @var ListModel
     */
    protected $model        = null;

    /**
     * the cell rederer of the list control
     *
     * @var \Callable
     */
    protected $cellRenderer = null;

    const EDITABLE      = 0x00000000;

    const NON_EDITABLE	= 0x00000040;

    /**
     * This method acts as the constructor of the class.
     *
     * @param Point $topLeftCorner the top left corner of the list control
     * @param Dimension $dimension the dimension of the list control
     */
    public function __construct(Point $topLeftCorner, Dimension $dimension) {
        parent::__construct(null, $topLeftCorner, $dimension);

        $this->cellRenderer = static::getDefaultCellRenderer();
    }

    /**
     * This method returns the default cell renderer for the list control, which returns the result of __toString for objects implementing it and the the passed in element if not.
     *
     * @return \Callable
     */
    protected static function getDefaultCellRenderer() {
        $callback = function($element) {
                        if(is_callable(array($element, '__toString'), FALSE)) {
                            return $element->__toString();
                        } else {
                            return $element;
                        }
                    };

        return $callback;
    }

    /**
     * This method returns the list model of the list control.
     *
     * @return \Woody\Model\ListModel
     */
    public function getModel() {
        return $this->model;
    }

    /**
     * This method sets the list model of the list control.
     *
     * @param \Woody\Model\ListModel $model the model to set
     * @return \Woody\Components\Controls\ListControl $this
     */
    public function setModel(ListModel $model) {
        $this->model = $model;

        return $this;
    }

    /**
     * This method sets the cell renderer of the list control.
     *
     * @param \Callable $cellRenderer
     * @return \Woody\Components\Controls\ListControl $this
     */
    public function setCellRenderer(callable $cellRenderer) {
        $this->cellRenderer = $cellRenderer;

        return $this;
    }

    /**
     * This method updates the content of the list control with the elements given in the list model.
     *
     * @param \SplSubject $listModel the model to update the list control with
     * @return \Woody\Components\Controls\ListControl $this
     */
    public function update(\SplSubject $listModel) {
        $selectedIndex  = max(0, $this->getSelectedIndex());
        $options        = array();
        if(($count = $listModel->count()) > 0) {
            for($i = 0; $i < $count; $i++) {
                $options[] = $this->cellRenderer->__invoke($listModel->getElementAt($i));
            }
        }

        wb_set_text($this->controlID, $options);

        $this->setSelectedIndex($selectedIndex);

        return $this;
    }

    /**
     * This method returns the currently selected index.
     *
     * @return int
     */
    public function getSelectedIndex() {
        return wb_get_selected($this->controlID);
    }

    /**
     * This method sets the currently selected index.
     *
     * @param int $index the index to set
     * @return \Woody\Components\Controls\ListControl $this
     */
    public function setSelectedIndex($index) {
        wb_set_selected($this->controlID, $index);

        return $this;
    }

    /**
     * This method gets the currently selected element.
     *
     * @return mixed
     */
    public function getSelectedElement() {
        $value = null;

        if(($selectedIndex = $this->getSelectedIndex()) >= 0) {
            $value = $this->model->getElementAt($selectedIndex);
        }

        return $value;
    }

    /**
     * This method sets the selected element.
     *
     * @param mixed $selectedValue the element to select
     * @return \Woody\Components\Controls\ListControl $this
     */
    public function setSelectedElement($selectedElement) {
       wb_set_selected($this->controlID, $this->model->getIndexOf($selectedElement));

       return $this;
    }
}